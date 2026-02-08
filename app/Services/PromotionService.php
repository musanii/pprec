<?php
namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\PromotionLog;
use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class PromotionService{

public function preview(AcademicYear $year, string $action = 'promote'): array
{
    if (!$year->is_active) {
        throw ValidationException::withMessages([
            'year' => 'Only the active academic year can be previewed.',
        ]);
    }

    $finalTerm = Term::where('academic_year_id', $year->id)
        ->where('is_active', true)
        ->first();

    if (!$finalTerm) {
        throw ValidationException::withMessages([
            'term' => 'Active term not found for this academic year.',
        ]);
    }

    $enrollments = Enrollment::query()
        ->where('term_id', $finalTerm->id)
        ->where('is_active', true)
        ->with(['student', 'schoolClass'])
        ->get();

    $summary = [
        'total' => 0,
        'promoted' => 0,
        'repeated' => 0,
        'graduated' => 0,
        'by_class' => [],
    ];

    foreach ($enrollments as $enrollment) {
        $summary['total']++;

        $class = $enrollment->schoolClass;

        if ($action === 'graduate' || $class->is_final) {
            $summary['graduated']++;
            continue;
        }

        if ($action === 'repeat') {
            $summary['repeated']++;
            continue;
        }

        $nextClass = $this->nextClass($class);

        if (!$nextClass) {
            $summary['graduated']++;
            continue;
        }

        $summary['promoted']++;

        $summary['by_class'][$class->name][] = $nextClass->name;
    }

    return $summary;
}


public function promote(AcademicYear $year, string $action='promote'){


$summary = $this->preview($year, $action);

    DB::transaction(function() use($year, $action){
        if(!$year->is_active){
            throw ValidationException::withMessages(['error'=>'Promotions can only be run for the active academic year.']);
        }

        $nextYear = AcademicYear::where('start_date', '>', $year->start_date)->orderBy('start_date')->first();


        if(!$nextYear && $action !=='graduate'){
            throw ValidationException::withMessages(['error'=>'No next academic year found. Please create the next academic year before promoting students.']);
        }

        $finalTerm = Term::where('academic_year_id', $year->id)
        ->where('is_active', true)
        ->first();

        if(!$finalTerm){
            throw ValidationException::withMessages(['error'=>'No active term found for the current academic year. Please activate a term before promoting students.']);
        }

        $enrollments = Enrollment::query()
        ->where('term_id', $finalTerm->id)
        ->where('is_active', true)
        ->with('student','schoolClass')
        ->get();

        foreach ($enrollments as $enrollment) {
                $this->handleEnrollment($enrollment, $action, $nextYear);
            }

        //Deactivate current academic year
        $year->update(['is_active'=>false]);
        if($nextYear){
            $nextYear->update(['is_active'=>true]);
        }
    });

    PromotionLog::create([
        'academic_year_id'=>$year->id,
        'user_id'=>auth()->id(),
        'action'=>$action,
        'total_students'=>$summary['total'],
        'promoted'=>$summary['promoted'],
        'graduated'=>$summary['graduated'],
        'repeated'=>$summary['repeated'],
    ]);
}

protected function handleEnrollment(Enrollment $enrollment, string $action, ?AcademicYear $nextYear){
    $student = $enrollment->student;
    $currentClass = $enrollment->schoolClass;

    //close current enrollment
    $enrollment->update(['is_active' => false]);

    if($action ==='graduate' || $currentClass->is_final){
        $student->update(['status'=>'alumni']);
        return;
    }

    $targetClass = match($action){
        'repeat' => $currentClass,
        'promote' => $this->nextClass($currentClass),
        default => throw ValidationException::withMessages(['error'=>'Invalid promotion action.']),
    };
    if(!$targetClass){
        $student->update(['status'=>'alumni']);
        return;
    }
    $nextTerm = Term::where('academic_year_id', $nextYear->id)
    ->orderBy('start_date')
    ->first();

    Enrollment::create([
        'student_id'=>$student->id,
        'class_id'=>$targetClass->id,
        'stream_id'=>null,
        'term_id'=>$nextTerm->id,
        'is_active'=>true,
    ]);
}

protected function nextClass(SchoolClass $class){
    return SchoolClass::where('level','>', $class->level)
    ->orderBy('level')
    ->first();
}


}
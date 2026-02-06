<?php
namespace App\Services;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;

class StudentService
{
    /**
     * Enroll a student into a class/stream for a term
     *  -Deactivates any existing active enrollment
     * - Creates a new  enrollment for a given (or active)n term
     */
    public function enroll(Student $student, int $classId, ?int $streamId = null, ?int $termId = null): Enrollment
    {
        $term = $this->resolveTerm($termId);

        if($student->status ==='alumni'){
            throw ValidationException::withMessages([
                'student'=> 'Cannot enroll an alumni student.',
            ]);

        }

        return DB::transaction(function() use($student, $classId,$streamId,$term){
            $alreadyEnrolled = Enrollment::query()
            ->where('student_id',$student->id)
            ->where('term_id', $term->id)
            ->exists();

            if ($alreadyEnrolled) {
                throw ValidationException::withMessages([
                    'term_id' => "Student is already enrolled for {$term->name}.",
                ]);
            }

            //Deactivate all current active enrollments
            Enrollment::query()
            ->where('student_id',$student->id)
            ->where('is_active',true)
            ->update(['is_active'=>false]);

            $enrollment= Enrollment::create([
                'student_id'=>$student->id,
                'class_id'=>$classId,
                'stream_id'=>$streamId,
                'term_id'=>$term->id,
                'is_active'=>true,
            ]);

            if($student->status ==='admitted'){
                $student->update(['status'=>'active']);
            }

            return $enrollment;

        });

    }

    /**
     * Promote student to a new class/stream in the next term
     */

    public function promote(Student $student, int $classId,?int $streamId=null, ?int $termId=null){
        $term = $this->resolveTerm($termId);
        if(!in_array($student->status,['active','admitted'], true)){
            throw  ValidationException::withMessages([
                'student'=>'Only active/admitted students can be promoted.',
            ]);
        }
        return $this->enroll($student, $classId,$streamId,$term->id);
    }

    /**
     * Widthdraw student
     */
    public function suspend(Student $student, string $reason=null){
        DB::transaction(function() use($student){
            Enrollment::query()
            ->where('student_id', $student->id)
            ->where('is_active', true)
            ->update(['is_active'=>false]);

            $student->update(['status'=>'suspended']);
        });
    }

    /**
     * Mark student as an alumni
     */
    public function graduate(Student $student){
        DB::transaction(function() use($student){
            Enrollment::query()
            ->where('student_id',$student->id)
            ->where('is_active',true)
            ->update(['status'=>false]);

            $student->update(['status'=>'alumni']);

        });
    }

    /**
     * Resolve Term by ID, or fall back to currently active term
     */

    private function resolveTerm(?int $termId){
        if($termId){
            $term = Term::query()->find($termId);
            if(!$term){
                throw ValidationException::withMessages([
                    'term_id'=>'Selected term does not exist.',
                ]);
            }
            return $term;
        }

        $activeTerm = Term::query()->where('is_active', true)->first();

        if(!$activeTerm){
            throw ValidationException::withMessages([
                'term'=>'No active term found. Please set an active term before enrolling student.',

            ]);
        }
        return $activeTerm;
    }
}

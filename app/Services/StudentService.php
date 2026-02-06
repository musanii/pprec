<?php
namespace App\Services;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Validation\ValidationException;
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

    public function updateProfile(Student $student, array $data){
        return DB::transaction(function() use($student,$data){
            //Student User
            $student->user()->update([
                'name'=>$data['student_name'],
            ]);

            //Parent User + Profile
            $parentProfile = $student->parent;
            $parentProfile?->user?->update([
                 'name' => $data['parent_name'],
            // 'email' => $data['parent_email'] ?? $parentProfile->user->email,

            ]);

            $parentProfile?->update([
                'phone'=>$data['parent_phone'] ?? null
            ]);

            $student->update([
                'admission_no'=>$data['admission_no'],
                'gender'=>$data['gender'] ?? null,
                'status'=>$data['status'],
            ]);
            return $student->fresh(['user','parent.user','activeEnrollment.schoolClass','activeEnrollment.stream']);
        });
    }

   public function changeStatus(Student $student, string $status): Student
{
    return DB::transaction(function () use ($student, $status) {

        // If trying to mark Active but no active enrollment exists, block (optional but professional)
        if ($status === 'active') {
            $hasActiveEnrollment = Enrollment::query()
                ->where('student_id', $student->id)
                ->where('is_active', true)
                ->exists();

            if (! $hasActiveEnrollment) {
                throw ValidationException::withMessages([
                    'status' => 'Cannot set student to Active without an active enrollment. Transfer/enroll the student first.',
                ]);
            }
        }

        // If Alumni or Archived, deactivate any active enrollment (prevents “ghost active” students)
        if (in_array($status, ['alumni', 'archived'], true)) {
            Enrollment::query()
                ->where('student_id', $student->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $student->update(['status' => $status]);

        return $student->fresh();
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

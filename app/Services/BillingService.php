<?php
Namespace App\Services;

use App\Models\AcademicYear;
use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\StudentBill;
use App\Models\Term;


class BillingService
{
    // This service will handle all billing related logic, such as generating bills for students based on fee structures, applying discounts, and processing payments.

    public function generateBillsForTerm(
        AcademicYear $academicYear,
        Term $term
    ){
        $students = Student::with('activeEnrollment')->where('status','active')->get();


        foreach($students as $student){
            $classId = $student->activeEnrollment?->class_id;

            if(! $classId){
                continue; // Skip students without an active enrollment
            }

            $feeStructure = FeeStructure::where([
                'academic_year_id' => $academicYear->id,
                'term_id' => $term->id,
                'class_id' => $classId,
                'is_active' => true,
            ])->get();

            foreach($feeStructure as $fee){
                StudentBill::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'fee_structure_id' => $fee->id,
                    ],
                    [
                        'amount' => $fee->amount,
                        'balance' => $fee->amount, // Initial balance is the full amount
                    ]
                );
            }

        }
    }
}
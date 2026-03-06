<?php 

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\Term;


class PolicyService
{
    /**
     * Attendance Policy
     */

    public function checkAttendanceEligibility(Student $student, Term $term)
    {
        $total = $student->attendances()
        ->whereHas('session.slot', fn($q)=> 
            $q->where('term_id', $term->id))
        ->count();

        $present = $student->attendances()
            ->where('status','present')
            ->whereHas('session.slot', fn($q) => 
                $q->where('term_id', $term->id)
            )->count();

        if($total ===0)
            {
                return false;
            }

            $percentage = ($present/$total) * 100;
            return $percentage >= 75;


    }

    /**
     * Finance Policy
     */

    public function checkFinancialClearance(Student $student)
    {
        return $student->bills()
        ->where('balance','>', 0)
        ->count() === 0;
    }

    /**
     * Exam Eligibility
     */

    public function checkExamEligibility(Student $student, Term $term)
    {
        if(!$this->checkAttendanceEligibility($student,$term))
            {
                return false;
            }

            if(!$this->checkFinancialClearance($student)){
                return false;
            }
            return true;
    }

    /**
     * Promotion Eligibility
     */
    public function checkPromotionEligibility(Student $student, AcademicYear $year)
    {
        $term = $year = $year->terms()->where('is_active', true)->first();

        if(!$term)
            {
                return false;
            }
            return $this->checkExamEligibility($student, $term);
    }
}
<?php

use App\Http\Controllers\Admin\AcademicIntelligenceController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\ClassSubjectController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\ExamMarkController;
use App\Http\Controllers\Admin\ExamRankingController;
use App\Http\Controllers\Admin\ExamReportController;
use App\Http\Controllers\Admin\ExamStreamRankingController;
use App\Http\Controllers\Admin\FeeStructureController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\PromotionLogController;
use App\Http\Controllers\Admin\ReportCardController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SchoolPeriodController;
use App\Http\Controllers\Admin\StreamController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentExamResultController;
use App\Http\Controllers\Admin\StudentStatusController;
use App\Http\Controllers\Admin\StudentTranscriptController;
use App\Http\Controllers\Admin\StudentTransferController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherAssignmentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\TermReportController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\Parent\ParentDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\ResultController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Parent\ResultController as ParentResultController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

 Route::get('students/{student}/transcript/pdf',[StudentTranscriptController::class,'download'])->name('students.transcript.pdf');
    Route::get('/verify/{hash}', [VerificationController::class, ' verify'])->name('results.verify');
Route::middleware('auth')->get('/dashboard', function () {
    return match (true) {
        auth()->user()->hasRole('admin') => redirect()->route('admin.dashboard'),
        auth()->user()->hasRole('teacher') => redirect()->route('teacher.dashboard'),
        auth()->user()->hasRole('student') => redirect()->route('student.dashboard'),
        auth()->user()->hasRole('parent') => redirect()->route('parent.dashboard'),
        default => abort(403),
    };
})->name('dashboard');




// Admin Portal ROutes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', StudentController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::post('students/{student}/transfer', [StudentTransferController::class, 'store'])->name('students.transfer');
    Route::patch('students/{student}/status', [StudentStatusController::class, 'update'])->name('students.status');

    Route::resource('teachers', TeacherController::class)->except(['show']);
    Route::patch('teachers/{teacher}/status', [TeacherController::class, 'status'])
        ->name('teachers.status');

    Route::get('teachers/{teacher}/assignments', [TeacherAssignmentController::class, 'edit'])->name('teachers.assignments.edit');
    Route::post('teachers/{teacher}/assignments', [TeacherAssignmentController::class, 'update'])
        ->name('teachers.assignments.update');

    Route::resource('exams',ExamController::class)->except(['show']);
    Route::get('exams/{exam}/marks', [ExamMarkController::class, 'edit'])
    ->name('exams.marks.edit');
    Route::post('exams/{exam}/marks', [ExamMarkController::class, 'update'])
    ->name('exams.marks.update');

    Route::get('exams/{exam}/classes/{class}/rankings', [ExamRankingController::class,'index'])->name('exams.classes.rankings');
    Route::get('exams/{exam}/classes/{class}/streams/{stream}/rankings', [ExamStreamRankingController::class,'index'])->name('exams.classes.streams.rankings');
   
    
    Route::patch('exams/{exam}/publish',[ExamController::class,'publish'])->name('exams.publish');
    Route::patch('exams/{exam}/unpublish',[ExamController::class,'unpublish'])->name('exams.unpublish');
   
    Route::get('students/{student}/exams/{exam}',[StudentExamResultController::class,'show'])->name('students.exams.show');

    Route::get('students/{student}/exams/{exam}/report', [ReportCardController::class,'show'])->name('students.exams.report');
    
    Route::get('students/{student}/exams/{exam}/report/pdf', [ReportCardController::class,'pdf'])->name('students.exams.report.pdf');

    Route::get('student/{student}/terms/{term}/report', [TermReportController::class,'show'])->name('students.terms.report');

    Route::patch('academic-years/{year}/lock', [AcademicYearController::class, 'lock'])->name('academic-years.lock');

    Route::post('academic-years/{academicYear}/promotions/preview',[PromotionController::class, 'preview'])->name('promotions.preview');
    Route::post('academic-years/{year}/promotions',[PromotionController::class,'store'])->name('promotions.store');
    Route::get('promotions/logs', [PromotionLogController::class,'index'])->name('promotion-logs.index');        
    // Academics routes
    Route::resource('classes', SchoolClassController::class)->except(['show']);
    Route::resource('streams', StreamController::class)->except(['show']);

    Route::resource('academic-years', AcademicYearController::class)->except('show');
    Route::patch('academic-years/{academic_year}/activate', [AcademicYearController::class, 'activate'])
        ->name('academic-years.activate');

    Route::resource('terms', TermController::class)->except(['show']);
    Route::patch('terms/{term}/activate', [TermController::class, 'activate'])
        ->name('terms.activate');

    Route::resource('subjects', SubjectController::class)->except('show');
    Route::patch('subjects/{subject}/activate', [SubjectController::class, 'activate'])->name('subjects.activate');

    Route::get('classes/{class}/subjects', [ClassSubjectController::class, 'edit'])->name('classes.subjects.edit');
    Route::post('classes/{class}/subjects', [ClassSubjectController::class, 'update'])->name('classes.subjects.update');

    //Finance Routes
    Route::resource('fee-structures', FeeStructureController::class)->except(['show']);
    Route::patch('fee-structures/{fee_structure}/toggle', [FeeStructureController::class, 'toggle'])->name('fee-structures.toggle');

    Route::post('academic-years/{year}/terms/{term}/generate-bills', [BillingController::class, 'generate'])->name('billing.generate');

    Route::get('finance',[FinanceController::class,'index'])->name('finance.index');

    Route::post('bills/{bill}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');

    Route::get('finance/export/excel', [FinanceController::class, 'exportExcel'])->name('finance.export.excel');
    Route::get('finance/export/pdf', [FinanceController::class, 'exportPdf'])->name('finance.export.pdf');
    Route::post('finance/apply-penalties', [FinanceController::class, 'applyPenalties'])->name('finance.penalties.apply');
    

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');     
    Route::get('/analytics/academic', [AcademicIntelligenceController::class, 'index'])->name('analytics.academic'); 

    Route::get('exams/{exam}/students/{student}/report-card',[ExamReportController::class,'show'])->name('exams.report');
    Route::get('students/{student}/transcript',[StudentTranscriptController::class,'show'])->name('students.transcript');

    Route::resource('school-periods', SchoolPeriodController::class)->names('school-periods');

    Route::resource('timetable',TimetableController::class)->only('index', 'store', 'update','destroy')->names('timetable');
    
   

   
});


//Student Routes
Route::middleware(['auth','role:student'])->prefix('student')->name('student.')->group(function(){
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::get('/results', [ResultController::class, 'index'])->name('results');

    Route::get('/results/{term}', [ResultController::class, 'show'])->name('results.show');
});

//Parent Routes  ,

Route::middleware(['auth','role:parent'])->prefix('parent')->name('parent.')->group(function(){
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/students/{student}/results', [ParentResultController::class, 'show'])->name('students.results');
    Route::get('finance', [\App\Http\Controllers\Parent\FinanceController::class,'index'])->name('finance');
   
});

//Teacher Routes
Route::middleware(['auth','role:teacher'])->prefix('teacher')->name('teacher.')->group(function(){
     Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

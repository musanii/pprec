<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateStudentRequest;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Stream;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {

        $q = $request->string('q')->toString();
        $status = $request->string('status')->toString();      // admitted|active|alumni|suspended
        $classId = $request->integer('class_id') ?: null;
        $streamId = $request->integer('stream_id') ?: null;
        $students = Student::query()->with([
            'user',
            'parent.user',
            'activeEnrollment.schoolClass',
            'activeEnrollment.stream',
        ])
            ->when(!$status, fn($q) => $q->whereNotIn('status', ['archived']))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($classId, function ($query) use ($classId) {
                $query->whereHas('activeEnrollment', fn ($q) => $q->where('class_id', $classId));
            })
            ->when($streamId, function ($query) use ($streamId) {
                $query->whereHas('activeEnrollment', fn ($q) => $q->where('stream_id', $streamId));
            })
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('admission_no', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('parent', fn ($p) => $p->where('phone', 'like', "%{$q}%"))
                        ->orWhereHas('parent.user', fn ($pu) => $pu->where('name', 'like', "%{$q}%"));
                });
            })->latest()
            ->paginate(20)
            ->withQueryString();
            $exams = Exam::where('is_published', true)
            ->orderByDesc('start_date')
            ->get();

        return view('admin.students.index',
            [
                'students' => $students,
                'filters' => [
                    'q' => $q,
                    'status' => $status,
                    'class_id' => $classId,
                    'stream_id' => $streamId,
                ],

                'classes' => SchoolClass::orderBy('level')->get(),
                'streams' => Stream::orderBy('name')->get(),
                'exams'=>$exams,
                

            ]);
    }

    public function create()
    {

        $classes = SchoolClass::orderBy('level')->get();
        $streamsByClass = Stream::query()
            ->orderBy('name')
            ->get()
            ->groupBy('class_id')
            ->map(fn ($items) => $items->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
            ])->values())
            ->toArray();

        return view('admin.students.create', [
            'classes' => $classes,
            'streamsByClass' => $streamsByClass,
        ]);
    }

    public function store(Request $request, StudentService $studentService)
    {
        $data = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'admission_no' => ['required', 'string', 'unique:students,admission_no'],
            'gender' => ['nullable', 'in:male,female'],

            'parent_name' => ['required', 'string', 'max:255'],
            'parent_email' => ['required', 'email', 'unique:users,email'],
            'parent_phone' => ['nullable', 'string'],

            'class_id' => ['required', 'exists:classes,id'],
            'stream_id' => [
                'nullable',
                Rule::exists('streams', 'id')->where(fn ($q) => $q->where('class_id', $request->input('class_id'))),
            ],
        ], [
            'class_id.required' => 'Please select a class.',
            'class_id.exists' => 'The selected class is invalid.',
            'stream_id.exists' => 'The selected stream is invalid for the chosen class.',

        ]);

        DB::transaction(function () use ($data, $studentService) {
            // Parent User
            $parentUser = User::create([
                'name' => $data['parent_name'],
                'email' => $data['parent_email'],
                'password' => bcrypt(Str::random(10)),
            ]);

            $parentUser->assignRole('parent');

            $parentProfile = $parentUser->parentProfile()->create([
                'phone' => $data['parent_phone'] ?? null,
            ]);

            // Student User
            $studentUser = User::create([
                'name' => $data['student_name'],
                'email' => Str::uuid().'@student.local',
                'password' => bcrypt(Str::random(10)),

            ]);
            $studentUser->assignRole('student');

            $student = Student::create([
                'user_id' => $studentUser->id,
                'parent_id' => $parentProfile->id,
                'admission_no' => $data['admission_no'],
                'gender' => $data['gender'] ?? null,
                'status' => 'admitted',
            ]);

            // Enrollment
            $studentService->enroll(
                $student,
                $data['class_id'],
                $data['stream_id'] ?? null
            );

        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student created and enrolled successfully.');

    }

    public function edit(Student $student){
                                                                                        
    $student->load(['user','parent.user','parent','activeEnrollment.schoolClass','activeEnrollment.stream']);
        $classes = SchoolClass::orderBy('level')->get();
        $streamsByClass = Stream::query()
            ->orderBy('name')
            ->get()
            ->groupBy('class_id')
            ->map(fn ($items) => $items->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
            ])->values())
            ->toArray();

            return view('admin.students.edit',[
                'student'=>$student,
                'classes'=>$classes,
                'streamsByClass'=>$streamsByClass
            ]);

    }

    public function update(UpdateStudentRequest $request, Student $student, StudentService $studentService){
        $studentService->updateProfile($student, $request->validated());

        return redirect()
        ->route('admin.students.edit',$student)
        ->with('success', 'Student updated successfully.');
    }
}

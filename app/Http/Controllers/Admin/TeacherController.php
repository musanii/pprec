<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeacherRequest;
use App\Http\Requests\Admin\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('user')
        ->orderByDesc('created_at')
        ->paginate(20);

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function() use($data){
            $user = User::create([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=> bcrypt(Str::random(10)),
            ]);

            $user->assignRole('teacher');
            Teacher::create([
                'user_id'=>$user->id,
                'staff_no'=>$data['staff_no'],
                'phone'=> $data['phone'] ?? null,
                'gender' =>$data['gender'] ?? null,
            ]);

        });

        return redirect()
        ->route('admin.teachers.index')
        ->with('success','teacher created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {

   
      
        $data = $request->validated();

        DB::transaction(function() use($teacher,$data){
            $teacher->user->update([
                'name'=>$data['name']
            ]);

            $teacher->update([
                'staff_no'=> $data['staff_no'],
                'phone'=>$data['phone'] ?? null,
                'gender'=>$data['gender'] ?? null,
                'is_active' => $data['is_active'] ?? false,

            ]);

        });

       return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Subject created successfully.');
    }

    public function status(Request $request, Teacher $teacher)
    {
        $teacher->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Teacher status updated.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStreamRequest;
use App\Http\Requests\Admin\UpdateStreamRequest;
use App\Models\SchoolClass;
use App\Models\Stream;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classId = $request->integer('class_id') ?: null;

        $streams = Stream::query()
            ->with('schoolClass')
            ->when($classId, fn($q) => $q->where('class_id', $classId))
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $classes = SchoolClass::orderBy('level')->get();

        return view('admin.academics.streams.index', compact('streams', 'classes', 'classId'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        $classes = SchoolClass::orderBy('level')->get();
        return view('admin.academics.streams.create', compact('classes'));
    }
    /**
     * Store a newly created resource in storage.
     */
 public function store(StoreStreamRequest $request)
    {
        Stream::create([
            'class_id' => $request->class_id,
            'name' => $request->name,
            'is_active' => (bool)($request->boolean('is_active', true)),
        ]);

        return redirect()->route('admin.streams.index')->with('success', 'Stream created.');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
   
    public function edit(Stream $stream)
    {
        $classes = SchoolClass::orderBy('level')->get();
        return view('admin.academics.streams.edit', compact('stream', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStreamRequest $request, Stream $stream)
    {
        $stream->update([
            'class_id' => $request->class_id,
            'name' => $request->name,
            'is_active' => (bool)($request->boolean('is_active', true)),
        ]);

        return redirect()->route('admin.streams.index')->with('success', 'Stream updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

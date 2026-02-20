<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTimeTableRequest;
use App\Services\TimetableService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TimetableController extends Controller
{
    public function store(StoreTimeTableRequest $request, TimetableService $service)
    {
        $data = $request->validated();
         try {
         $service->assign($data);
        return back()->with('success', 'Slot assigned');
    } catch (ValidationException $e) {
        return back()
            ->withErrors($e->errors())
            ->withInput();
    }

  
    }
}

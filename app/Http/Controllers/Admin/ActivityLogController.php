<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
       $logs = ActivityLog::with(['performer'])
       ->when($request->domain, fn($q)=>
           $q->where('domain', $request->domain)
       )
       ->latest()
       ->paginate(20)
       ->withQueryString();

        return view('admin.activity_logs.index', compact('logs'));
    }
}

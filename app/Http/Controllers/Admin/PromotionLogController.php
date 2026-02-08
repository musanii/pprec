<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionLog;
use Illuminate\Http\Request;

class PromotionLogController extends Controller
{
public function index()
{
    $logs = PromotionLog::with(['academicYear', 'user'])->latest()->paginate(15);
    return view('admin.promotions.logs', compact('logs'));
}
}

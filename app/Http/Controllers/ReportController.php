<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reportable_id' => 'required|integer',
            'reportable_type' => 'required|string',
            'message' => 'nullable|string|max:1000',
        ]);

        Report::create([
            'reportable_id' => $request->reportable_id,
            'reportable_type' => $request->reportable_type,
            'reported_by' => Auth::id(),
            'message' => $request->message,
        ]);

        return response()->json(['success' => true, 'message' => 'Report submitted successfully.']);
    }
}

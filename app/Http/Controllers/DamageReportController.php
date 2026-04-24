<?php

namespace App\Http\Controllers;

use App\Models\DamageReport;
use Illuminate\Http\Request;

class DamageReportController extends Controller
{
    /**
     * GET /api/reports
     */
    public function index(Request $request)
    {
        $query = DamageReport::query();

        // filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('equipment_name', 'like', "%{$request->search}%")
                  ->orWhere('operator_name', 'like', "%{$request->search}%");
            });
        }

        return response()->json($query->latest()->get());
    }

    /**
     * GET /api/reports/{id}
     */
    public function show($id)
    {
        $report = DamageReport::find($id);

        if (!$report) {
            return response()->json(['message' => 'Report not found'], 404);
        }

        return response()->json($report);
    }

    /**
     * PATCH /api/reports/{id}/approve
     */
    public function approve($id)
    {
        $report = DamageReport::findOrFail($id);
        $report->status = 'approved';
        $report->save();

        return response()->json($report);
    }

    /**
     * PATCH /api/reports/{id}/reject
     */
    public function reject($id)
    {
        $report = DamageReport::findOrFail($id);
        $report->status = 'rejected';
        $report->save();

        return response()->json($report);
    }

    /**
     * GET /api/reports/latest
     */
    public function latest()
    {
        $reports = DamageReport::latest()->take(5)->get();

        return response()->json($reports);
    }
}
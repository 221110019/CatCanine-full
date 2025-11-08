<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return Report::orderByDesc('created_at')->get();
    }

    public function show($id)
    {
        return Report::findOrFail($id);
    }

    public function destroy($id)
    {
        Report::findOrFail($id)->delete();
        return response()->noContent();
    }

    public function reportPost(Request $request, $id)
    {
        $data = $request->validate(['reason' => 'required|string|max:255']);
        $report = Report::create([
            'reporter_id' => $request->user()->id,
            'reported_post_id' => $id,
            'reason' => $data['reason'],
        ]);
        return response()->json($report, 201);
    }
}

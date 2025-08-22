<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkExperienceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'project_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        
        // If marked as current, set end_date to null
        if ($request->boolean('is_current')) {
            $data['end_date'] = null;
        }

        WorkExperience::create($data);

        return redirect()->back()->with('success', 'Work experience added successfully!');
    }

    public function update(Request $request, WorkExperience $workExperience)
    {
        // Ensure user can only update their own work experience
        if ($workExperience->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'project_type' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        $data = $request->all();
        
        // If marked as current, set end_date to null
        if ($request->boolean('is_current')) {
            $data['end_date'] = null;
        }

        $workExperience->update($data);

        return redirect()->back()->with('success', 'Work experience updated successfully!');
    }

    public function destroy(WorkExperience $workExperience)
    {
        // Ensure user can only delete their own work experience
        if ($workExperience->user_id !== Auth::id()) {
            abort(403);
        }

        $workExperience->delete();

        return redirect()->back()->with('success', 'Work experience deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Employment\Models\EmploymentHistory;
use Modules\Employment\Models\Employer;

class EmploymentController extends Controller
{
    /**
     * Display a listing of employment histories
     */
    public function index()
    {
        $alumni = Auth::guard('alumni')->user();
        
        $employments = EmploymentHistory::where('alumni_id', $alumni->alumni_id)
            ->with('employer')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('alumni.employment.index', compact('employments'));
    }

    /**
     * Show the form for creating a new employment
     */
    public function create()
    {
        $alumni = Auth::guard('alumni')->user();
        $employers = Employer::orderBy('employer_name')->get();
        
        return view('alumni.employment.create', compact('employers'));
    }

    /**
     * Store a newly created employment
     */
    public function store(Request $request)
    {
        $alumni = Auth::guard('alumni')->user();
        
        $validated = $request->validate([
            'employment_status' => 'required|in:employed,unemployed,studying,entrepreneur',
            'employer_id' => 'nullable|exists:employers,employer_id',
            'company_name' => 'required_if:employment_status,employed,entrepreneur|nullable|string|max:255',
            'industry_type' => 'required_if:employment_status,employed,entrepreneur|nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'company_phone' => 'nullable|string|max:20',
            'job_title' => 'required_if:employment_status,employed,entrepreneur|nullable|string|max:255',
            'job_level' => 'required_if:employment_status,employed|nullable|in:entry,junior,mid,senior,lead,supervisor,manager,director,vp,ceo',
            'contract_type' => 'required_if:employment_status,employed|nullable|in:full_time,part_time,contract,freelance,internship',
            'job_description' => 'nullable|string',
            'institution_name' => 'required_if:employment_status,studying|nullable|string|max:255',
            'study_level' => 'required_if:employment_status,studying|nullable|string|max:100',
            'major' => 'required_if:employment_status,studying|nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Find or create employer
        $employer = null;
        if ($request->filled('employer_id')) {
            // Use existing employer
            $employer = Employer::find($request->employer_id);
        } elseif ($request->filled('company_name')) {
            // Create new employer or find by exact name
            $employer = Employer::firstOrCreate(
                ['employer_name' => $request->company_name],
                [
                    'industry_type' => $request->industry_type,
                    'website' => $request->website,
                ]
            );
        }

        // If setting as active, deactivate other employments
        if ($request->boolean('is_active')) {
            EmploymentHistory::where('alumni_id', $alumni->alumni_id)
                ->update(['is_active' => false]);
        }

        // Create employment history
        $employment = EmploymentHistory::create([
            'alumni_id' => $alumni->alumni_id,
            'employer_id' => $employer?->employer_id,
            'employment_status' => $validated['employment_status'],
            'is_active' => $request->boolean('is_active'),
            'job_title' => $validated['job_title'] ?? null,
            'job_level' => $validated['job_level'] ?? null,
            'contract_type' => $validated['contract_type'] ?? null,
            'job_description' => $validated['job_description'] ?? null,
            'company_phone' => $validated['company_phone'] ?? null,
            'institution_name' => $validated['institution_name'] ?? null,
            'study_level' => $validated['study_level'] ?? null,
            'major' => $validated['major'] ?? null,
        ]);

        return redirect()->route('alumni.employment.index')
            ->with('success', 'Data pekerjaan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified employment
     */
    public function edit(EmploymentHistory $employment)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($employment->alumni_id !== $alumni->alumni_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $employers = Employer::orderBy('employer_name')->get();
        
        return view('alumni.employment.edit', compact('employment', 'employers'));
    }

    /**
     * Update the specified employment
     */
    public function update(Request $request, EmploymentHistory $employment)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($employment->alumni_id !== $alumni->alumni_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'employment_status' => 'required|in:employed,unemployed,studying,entrepreneur',
            'employer_id' => 'nullable|exists:employers,employer_id',
            'company_name' => 'required_if:employment_status,employed,entrepreneur|nullable|string|max:255',
            'industry_type' => 'required_if:employment_status,employed,entrepreneur|nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'company_phone' => 'nullable|string|max:20',
            'job_title' => 'required_if:employment_status,employed,entrepreneur|nullable|string|max:255',
            'job_level' => 'required_if:employment_status,employed|nullable|in:entry,junior,mid,senior,lead,supervisor,manager,director,vp,ceo',
            'contract_type' => 'required_if:employment_status,employed|nullable|in:full_time,part_time,contract,freelance,internship',
            'job_description' => 'nullable|string',
            'institution_name' => 'required_if:employment_status,studying|nullable|string|max:255',
            'study_level' => 'required_if:employment_status,studying|nullable|string|max:100',
            'major' => 'required_if:employment_status,studying|nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Find or create employer
        $employer = null;
        if ($request->filled('employer_id')) {
            // Use existing employer
            $employer = Employer::find($request->employer_id);
        } elseif ($request->filled('company_name')) {
            // Create new employer or find by exact name
            $employer = Employer::firstOrCreate(
                ['employer_name' => $request->company_name],
                [
                    'industry_type' => $request->industry_type,
                    'website' => $request->website,
                ]
            );
        }

        // If setting as active, deactivate other employments
        if ($request->boolean('is_active')) {
            EmploymentHistory::where('alumni_id', $alumni->alumni_id)
                ->where('employment_id', '!=', $employment->employment_id)
                ->update(['is_active' => false]);
        }

        // Update employment history
        $employment->update([
            'employer_id' => $employer?->employer_id,
            'employment_status' => $validated['employment_status'],
            'is_active' => $request->boolean('is_active'),
            'job_title' => $validated['job_title'] ?? null,
            'job_level' => $validated['job_level'] ?? null,
            'contract_type' => $validated['contract_type'] ?? null,
            'job_description' => $validated['job_description'] ?? null,
            'company_phone' => $validated['company_phone'] ?? null,
            'institution_name' => $validated['institution_name'] ?? null,
            'study_level' => $validated['study_level'] ?? null,
            'major' => $validated['major'] ?? null,
        ]);

        return redirect()->route('alumni.employment.index')
            ->with('success', 'Data pekerjaan berhasil diperbarui!');
    }

    /**
     * Remove the specified employment
     */
    public function destroy(EmploymentHistory $employment)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($employment->alumni_id !== $alumni->alumni_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $employment->delete();
        
        return redirect()->route('alumni.employment.index')
            ->with('success', 'Data pekerjaan berhasil dihapus!');
    }



    /**
     * Search employers for autocomplete
     */
    public function searchEmployers(Request $request)
    {
        $search = $request->get('q', '');
        
        $employers = Employer::where('employer_name', 'like', "%{$search}%")
            ->orWhere('industry_type', 'like', "%{$search}%")
            ->orderBy('employer_name')
            ->limit(10)
            ->get(['employer_id', 'employer_name', 'industry_type', 'website']);
        
        return response()->json($employers);
    }
}

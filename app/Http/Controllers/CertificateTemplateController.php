<?php

namespace App\Http\Controllers;

use App\Models\CertificateTemplate;
use App\Models\District;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $query = CertificateTemplate::with(['district', 'school']);

        if ($user->hasRole('Super Admin') || $user->hasRole('Pentadbir')) {
            // see all
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $query->where('district_id', $user->district_id);
        } else {
            // Guru Besar / Guru KAFA — school level only
            $query->where('school_id', $user->school_id);
        }

        $templates = $query->latest()->paginate(10);

        return view('certificates.templates.index', compact('templates'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('Super Admin') || $user->hasRole('Pentadbir')) {
            $districts = District::orderBy('name')->get();
            $schools   = School::orderBy('name')->get();
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $districts = District::where('id', $user->district_id)->get();
            $schools   = School::where('district_id', $user->district_id)->orderBy('name')->get();
        } else {
            $districts = collect();
            $schools   = School::where('id', $user->school_id)->get();
        }

        return view('certificates.templates.create', compact('districts', 'schools'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'              => 'required|string|max:255',
            'level'             => 'required|in:daerah,sekolah',
            'layout_style'      => 'required|in:center,bottom,left,right',
            'background'        => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'signature'         => 'nullable|image|mimes:jpeg,png|max:2048',
            'include_signature' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'level', 'layout_style']);
        $data['include_signature'] = $request->boolean('include_signature');

        // Enforce scope
        if ($user->hasRole('Penyelia KAFA') || $user->hasRole('Super Admin') || $user->hasRole('Pentadbir')) {
            $data['district_id'] = $request->district_id ?? $user->district_id;
            if ($request->level === 'sekolah') {
                $data['school_id'] = $request->school_id;
            }
        } else {
            $data['school_id'] = $user->school_id;
            $data['level']     = 'sekolah';
        }

        if ($request->hasFile('background')) {
            $data['background_path'] = $request->file('background')->store('certificates/backgrounds', 'public');
        }
        if ($request->hasFile('signature')) {
            $data['signature_path'] = $request->file('signature')->store('certificates/signatures', 'public');
        }

        CertificateTemplate::create($data);

        return redirect()->route('certificates.templates.index')
            ->with('success', 'Templat sijil berjaya dibuat.');
    }

    public function destroy(CertificateTemplate $certificatesTemplate)
    {
        if ($certificatesTemplate->background_path) {
            Storage::disk('public')->delete($certificatesTemplate->background_path);
        }
        if ($certificatesTemplate->signature_path) {
            Storage::disk('public')->delete($certificatesTemplate->signature_path);
        }
        $certificatesTemplate->delete();

        return redirect()->route('certificates.templates.index')
            ->with('success', 'Templat sijil telah dipadam.');
    }
}

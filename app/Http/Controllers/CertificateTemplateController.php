<?php

namespace App\Http\Controllers;

use App\Models\CertificateTemplate;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $query = CertificateTemplate::with('school');

        // Tenants see their own templates plus platform templates (school_id NULL)
        if (!$user->isSuperAdmin()) {
            $query->where(fn($q) => $q->where('school_id', $user->school_id)->orWhereNull('school_id'));
        }

        $templates = $query->latest()->paginate(10);

        return view('certificates.templates.index', compact('templates'));
    }

    public function create()
    {
        $user = Auth::user();

        $schools = $user->isSuperAdmin()
            ? School::orderBy('name')->get()
            : School::where('id', $user->school_id)->get();

        return view('certificates.templates.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'              => 'required|string|max:255',
            'layout_style'      => 'required|in:center,bottom,left,right',
            'background'        => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'signature'         => 'nullable|image|mimes:jpeg,png|max:2048',
            'include_signature' => 'nullable|boolean',
            'school_id'         => 'nullable|exists:schools,id',
        ]);

        $data = $request->only(['name', 'layout_style']);
        $data['level'] = 'sekolah';
        $data['include_signature'] = $request->boolean('include_signature');

        // Super Admin may publish a platform template (no school); tenants always own theirs
        $data['school_id'] = $user->isSuperAdmin() ? $request->school_id : $user->school_id;

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
        $user = Auth::user();
        if (!$user->isSuperAdmin() && (int) $certificatesTemplate->school_id !== (int) $user->school_id) {
            abort(403, 'Anda tidak dibenarkan memadam templat ini.');
        }

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

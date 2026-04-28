<?php

namespace App\Http\Controllers;

use App\Models\RphRecord;
use App\Models\RphPeriod;
use App\Models\KafaClass;
use App\Models\School;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RphRecordController extends Controller
{
    public function index()
    {
        $user  = auth()->user();
        $query = RphRecord::with(['user', 'periods' => fn($q) => $q->where('period_no', 1)]);

        if ($user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            // all records
        } elseif ($user->hasRole('Penyelia KAFA')) {
            $query->whereHas('school', fn($q) => $q->where('district_id', $user->district_id));
        } else {
            $query->where('school_id', $user->school_id);
            if ($user->hasRole('Guru KAFA')) {
                $query->where('user_id', $user->id);
            }
        }

        $rphs = $query->orderBy('date', 'desc')->paginate(10)->withQueryString();
        return view('rph.index', compact('rphs'));
    }

    public function create()
    {
        $user  = auth()->user();
        $query = KafaClass::query();
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $query->where('school_id', $user->school_id);
        }
        $classes = $query->orderBy('tahun')->orderBy('name')->get();
        $timeSlots = $user->school_id
            ? TimeSlot::where('school_id', $user->school_id)->orderBy('start_time')->get()
            : collect();
        return view('rph.create', compact('classes', 'timeSlots'));
    }

    public function createGabungan()
    {
        $user  = auth()->user();
        $query = KafaClass::query();
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            $query->where('school_id', $user->school_id);
        }
        $classes = $query->orderBy('tahun')->orderBy('name')->get();
        return view('rph.create_gabungan', compact('classes'));
    }

    public function store(Request $request)
    {
        // Check if this is a gabungan submission
        if ($request->class_type === 'gabungan') {
            return $this->storeGabungan($request);
        }

        // Original validation for biasa
        $request->validate([
            'date'                         => 'required|date',
            'hari'                         => 'required|string',
            'week'                         => 'required|integer|min:1|max:52',
            'periods.1.kafa_class_id'      => 'required|exists:kafa_classes,id',
            'periods.1.topic_jawi'         => 'required|string',
            'periods.1.kemahiran_jawi'     => 'required|string',
            'periods.1.isi_pelajaran_jawi' => 'required|string',
            'periods.1.objective_jawi'     => 'required|string',
            'periods.1.aktiviti_jawi'      => 'required|string',
            'periods.2.kafa_class_id'      => 'nullable|exists:kafa_classes,id',
            'periods.3.kafa_class_id'      => 'nullable|exists:kafa_classes,id',
        ]);

        $p1 = $request->input('periods.1', []);

        DB::transaction(function () use ($request, $p1) {
            $rph = RphRecord::create([
                'school_id'      => auth()->user()->school_id,
                'user_id'        => auth()->id(),
                'kafa_class_id'  => $p1['kafa_class_id'],
                'date'           => $request->date,
                'hari'           => $request->hari,
                'week'           => $request->week,
                'topic_jawi'     => $p1['topic_jawi'] ?? null,
                'class_type'     => 'biasa',
                'status'         => 'pending',
            ]);

            foreach ([1, 2, 3] as $no) {
                $p = $request->input("periods.{$no}", []);
                $hasData = !empty($p['kafa_class_id']) || !empty($p['topic_jawi']);
                if ($hasData || $no === 1) {
                    RphPeriod::create([
                        'rph_id'               => $rph->id,
                        'period_no'            => $no,
                        'kafa_class_id'        => $p['kafa_class_id'] ?? null,
                        'masa'                 => $p['masa'] ?? null,
                        'mata_pelajaran_jawi'  => $p['mata_pelajaran_jawi'] ?? null,
                        'topic_jawi'           => $p['topic_jawi'] ?? null,
                        'kemahiran_jawi'       => $p['kemahiran_jawi'] ?? null,
                        'isi_pelajaran_jawi'   => $p['isi_pelajaran_jawi'] ?? null,
                        'objective_jawi'       => $p['objective_jawi'] ?? null,
                        'aktiviti_jawi'        => $p['aktiviti_jawi'] ?? null,
                        'reflection_jawi'      => $p['reflection_jawi'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('rph.index')->with('success', 'RPH berjaya dihantar untuk semakan.');
    }

    private function storeGabungan(Request $request)
    {
        $request->validate([
            'date'                    => 'required|date',
            'hari'                    => 'required|string',
            'week'                    => 'required|integer|min:1|max:52',
            'masa'                    => 'required|string',
            'mata_pelajaran'          => 'required|string',
            'topic'                   => 'required|string',
            'kafa_class_id'           => 'required|exists:kafa_classes,id',
            'combined_years'          => 'required|array|min:2|max:3',
            'combined_years.*'        => 'integer|between:1,6',
            'objectives_by_year.*'    => 'required|string',
            'standards_by_year.*'     => 'required|string',
            'activities_by_year.*'    => 'required|string',
            'assessment_by_year.*'    => 'nullable|string',
        ]);

        RphRecord::create([
            'school_id'          => auth()->user()->school_id,
            'user_id'            => auth()->id(),
            'kafa_class_id'      => $request->kafa_class_id,
            'date'               => $request->date,
            'hari'               => $request->hari,
            'week'               => $request->week,
            'masa'               => $request->masa,
            'mata_pelajaran'     => $request->mata_pelajaran,
            'topic'              => $request->topic,
            'class_type'         => 'gabungan',
            'combined_years'     => $request->combined_years,
            'objectives_by_year' => $request->objectives_by_year,
            'standards_by_year'  => $request->standards_by_year,
            'activities_by_year' => $request->activities_by_year,
            'assessment_by_year' => $request->assessment_by_year,
            'status'             => 'pending',
        ]);

        return redirect()->route('rph.index')->with('success', 'RPH Gabungan berjaya dihantar untuk semakan.');
    }

    public function show(RphRecord $rph)
    {
        $user = auth()->user();
        if (!$user->hasAnyRole(['Super Admin', 'Pentadbir'])) {
            if ($user->hasRole('Penyelia KAFA')) {
                if (!School::where('id', $rph->school_id)->where('district_id', $user->district_id)->exists()) abort(403);
            } else {
                if ($rph->school_id !== $user->school_id) abort(403);
            }
        }
        $rph->load(['periods.kafaClass', 'user', 'reviewer']);
        return view('rph.show', compact('rph'));
    }

    public function edit(RphRecord $rph)
    {
        if ($rph->user_id !== auth()->id()) abort(403);
        if ($rph->status === 'approved') {
            return redirect()->route('rph.index')->with('error', 'RPH yang telah diluluskan tidak boleh disunting.');
        }
        $classes = KafaClass::where('school_id', auth()->user()->school_id)->orderBy('name')->get();
        $timeSlots = auth()->user()->school_id
            ? TimeSlot::where('school_id', auth()->user()->school_id)->orderBy('start_time')->get()
            : collect();
        $rph->load('periods.kafaClass');
        return view('rph.edit', compact('rph', 'classes', 'timeSlots'));
    }

    public function update(Request $request, RphRecord $rph)
    {
        if ($rph->user_id !== auth()->id()) abort(403);
        if ($rph->status === 'approved') {
            return redirect()->route('rph.index')->with('error', 'RPH yang telah diluluskan tidak boleh disunting.');
        }

        $request->validate([
            'date'                         => 'required|date',
            'hari'                         => 'required|string',
            'week'                         => 'required|integer|min:1|max:52',
            'periods.1.kafa_class_id'      => 'required|exists:kafa_classes,id',
            'periods.1.topic_jawi'         => 'required|string',
            'periods.1.kemahiran_jawi'     => 'required|string',
            'periods.1.isi_pelajaran_jawi' => 'required|string',
            'periods.1.objective_jawi'     => 'required|string',
            'periods.1.aktiviti_jawi'      => 'required|string',
            'periods.2.kafa_class_id'      => 'nullable|exists:kafa_classes,id',
            'periods.3.kafa_class_id'      => 'nullable|exists:kafa_classes,id',
        ]);

        $p1 = $request->input('periods.1', []);

        DB::transaction(function () use ($request, $rph, $p1) {
            $rph->update([
                'kafa_class_id'  => $p1['kafa_class_id'],
                'date'           => $request->date,
                'hari'           => $request->hari,
                'week'           => $request->week,
                'topic_jawi'     => $p1['topic_jawi'] ?? null,
                'status'         => 'pending',
                'review_comment' => null,
                'reviewer_id'    => null,
            ]);

            // Sync periods: delete old, recreate
            $rph->periods()->delete();
            foreach ([1, 2, 3] as $no) {
                $p = $request->input("periods.{$no}", []);
                $hasData = !empty($p['kafa_class_id']) || !empty($p['topic_jawi']);
                if ($hasData || $no === 1) {
                    RphPeriod::create([
                        'rph_id'               => $rph->id,
                        'period_no'            => $no,
                        'kafa_class_id'        => $p['kafa_class_id'] ?? null,
                        'masa'                 => $p['masa'] ?? null,
                        'mata_pelajaran_jawi'  => $p['mata_pelajaran_jawi'] ?? null,
                        'topic_jawi'           => $p['topic_jawi'] ?? null,
                        'kemahiran_jawi'       => $p['kemahiran_jawi'] ?? null,
                        'isi_pelajaran_jawi'   => $p['isi_pelajaran_jawi'] ?? null,
                        'objective_jawi'       => $p['objective_jawi'] ?? null,
                        'aktiviti_jawi'        => $p['aktiviti_jawi'] ?? null,
                        'reflection_jawi'      => $p['reflection_jawi'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('rph.index')->with('success', 'RPH berjaya dikemaskini dan dihantar semula untuk semakan.');
    }

    public function destroy(RphRecord $rph)
    {
        if ($rph->user_id !== auth()->id()) abort(403);
        if ($rph->status === 'approved') {
            return redirect()->route('rph.index')->with('error', 'RPH yang telah diluluskan tidak boleh dipadam.');
        }
        $rph->delete();
        return redirect()->route('rph.index')->with('success', 'Rekod RPH dipadam.');
    }
}

{{-- Super Admin only: pick the school for a school-level report. Params: $schools, $school --}}
@if($schools->isNotEmpty())
<div class="flex-1 min-w-48">
    <label class="ek-label">Sekolah</label>
    <select name="school_id" required class="ek-input" onchange="this.form.submit()">
        <option value="">-- Pilih Sekolah --</option>
        @foreach($schools as $s)
            <option value="{{ $s->id }}" {{ $school?->id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
        @endforeach
    </select>
</div>
@endif

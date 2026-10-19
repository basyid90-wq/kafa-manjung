@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="ek-page-title">Kemaskini Jadual Waktu</h1>
        <a href="{{ route('timetable.index') }}"
           class="ek-btn-secondary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 mb-4 text-sm text-red-700">
        {{ session('error') }}
    </div>
    @endif

    <div class="ek-card">
        <form action="{{ route('timetable.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">

                <div>
                    <label class="ek-label">Kelas <span class="text-red-500">*</span></label>
                    <select name="kafa_class_id" required
                            class="ek-input">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="ek-label">Hari <span class="text-red-500">*</span></label>
                    <select name="day_of_week" required
                            class="ek-input">
                        @foreach($days as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="ek-label">Slot Masa <span class="text-red-500">*</span></label>
                    <select name="time_slot_id" required
                            class="ek-input">
                        @forelse($slots as $slot)
                            <option value="{{ $slot->id }}">
                                {{ $slot->name }} ({{ date('h:i A', strtotime($slot->start_time)) }} - {{ date('h:i A', strtotime($slot->end_time)) }})
                            </option>
                        @empty
                            <option value="">-- Tiada Slot Masa --</option>
                        @endforelse
                    </select>
                    @if($slots->isEmpty())
                    <p class="text-xs text-red-500 mt-1">Sila <a href="{{ route('time_slots.index') }}" class="underline">tetapkan slot masa</a> terlebih dahulu.</p>
                    @endif
                </div>

                <div>
                    <label class="ek-label">Mata Pelajaran <span class="text-red-500">*</span></label>
                    <select name="subject_id" required
                            class="ek-input">
                        @forelse($subjects as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                        @empty
                            <option value="">-- Tiada Mata Pelajaran --</option>
                        @endforelse
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="ek-label">Guru Pengajar <span class="text-red-500">*</span></label>
                    <select name="user_id" required
                            class="ek-input">
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ auth()->id() == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="ek-btn-primary">
                    Simpan Jadual
                </button>
                <a href="{{ route('timetable.index') }}"
                   class="ek-btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

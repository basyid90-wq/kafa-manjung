@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Jadual Waktu</h1>
        <a href="{{ route('timetable.index', ['kafa_class_id' => $timetable->kafa_class_id]) }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg px-4 py-3 mb-4 text-sm text-red-700 dark:text-red-400">
        {{ session('error') }}
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
        <form action="{{ route('timetable.update', $timetable->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kafa_class_id" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $timetable->kafa_class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hari <span class="text-red-500">*</span></label>
                    <select name="day_of_week" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach($days as $day)
                            <option value="{{ $day }}" {{ $timetable->day_of_week == $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slot Masa <span class="text-red-500">*</span></label>
                    <select name="time_slot_id" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @forelse($slots as $slot)
                            <option value="{{ $slot->id }}" {{ $timetable->time_slot_id == $slot->id ? 'selected' : '' }}>
                                {{ $slot->name }} ({{ date('h:i A', strtotime($slot->start_time)) }} - {{ date('h:i A', strtotime($slot->end_time)) }})
                            </option>
                        @empty
                            <option value="">-- Tiada Slot Masa --</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mata Pelajaran <span class="text-red-500">*</span></label>
                    <select name="subject_id" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @forelse($subjects as $sub)
                            <option value="{{ $sub->id }}" {{ $timetable->subject_id == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @empty
                            <option value="">-- Tiada Mata Pelajaran --</option>
                        @endforelse
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Guru Pengajar <span class="text-red-500">*</span></label>
                    <select name="user_id" required
                            class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ $timetable->user_id == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Kemaskini
                </button>
                <a href="{{ route('timetable.index', ['kafa_class_id' => $timetable->kafa_class_id]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

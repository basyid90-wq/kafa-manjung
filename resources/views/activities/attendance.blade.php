@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Kehadiran: {{ $activity->name }}</h1>
            <div class="flex items-center gap-2 mt-1">
                @php
                    $badge = match($activity->tahap ?? '') {
                        'sekolah' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                        'daerah'  => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                        default   => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                    };
                @endphp
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $badge }}">{{ $activity->tahap_label }}</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">Tandakan murid yang menyertai program ini.</p>
            </div>
        </div>
        <a href="{{ route('activities.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <form action="{{ route('activities.save_attendance', $activity) }}" method="POST">
        @csrf

        @foreach($students as $groupName => $groupStudents)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-4">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <input type="checkbox" class="select-all-group w-4 h-4 rounded text-blue-600 border-gray-300"
                           data-group="{{ Str::slug($groupName) }}" title="Pilih semua">
                    <h3 class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $groupName }}</h3>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $groupStudents->count() }} murid</span>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/30 text-xs text-gray-500 dark:text-gray-400 uppercase">
                    <tr>
                        <th class="px-4 py-2 text-left w-10"></th>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama Murid</th>
                        @if($activity->tahap !== 'sekolah')
                        <th class="px-4 py-2 text-left">Kelas</th>
                        @endif
                        <th class="px-4 py-2 text-left">MyKid</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($groupStudents as $i => $student)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-4 py-2.5">
                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                   class="group-checkbox group-{{ Str::slug($groupName) }} w-4 h-4 rounded text-blue-600 border-gray-300"
                                   {{ in_array($student->id, $attendedStudentIds) ? 'checked' : '' }}>
                        </td>
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900 dark:text-white">{{ $student->name }}</td>
                        @if($activity->tahap !== 'sekolah')
                        <td class="px-4 py-2.5 text-gray-600 dark:text-gray-300">{{ optional($student->kafaClass)->display_name ?? '—' }}</td>
                        @endif
                        <td class="px-4 py-2.5 text-gray-500 dark:text-gray-400 text-xs font-mono">{{ $student->mykid }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach

        <div class="flex gap-3 mt-5">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                Simpan Kehadiran
            </button>
            <a href="{{ route('activities.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.select-all-group').forEach(function(selectAll) {
    var group = selectAll.dataset.group;
    var checkboxes = document.querySelectorAll('.group-' + group);

    selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
    selectAll.indeterminate = !selectAll.checked && Array.from(checkboxes).some(cb => cb.checked);

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    checkboxes.forEach(function(cb) {
        cb.addEventListener('change', function() {
            selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.indeterminate = !selectAll.checked && Array.from(checkboxes).some(cb => cb.checked);
        });
    });
});
</script>
@endsection

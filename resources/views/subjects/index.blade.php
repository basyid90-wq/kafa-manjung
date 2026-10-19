@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Pengurusan Mata Pelajaran</h1>
            <p class="ek-page-sub mt-1">Senarai mata pelajaran yang diajar</p>
        </div>
        <a href="{{ route('subjects.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Subjek
        </a>
    </div>

    {{-- ── Filter (Super Admin) ── --}}
    @role('Super Admin')
    <div class="ek-card mb-5">
        <form action="{{ route('subjects.index') }}" method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Penapis Sekolah</label>
                <select name="school_id" onchange="this.form.submit()"
                        class="ek-input">
                    <option value="">Semua Sekolah</option>
                    @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('subjects.index') }}"
               class="ek-btn-secondary">
                Reset
            </a>
        </form>
    </div>
    @endrole

    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Kod</th>
                        <th class="px-5 py-3">Mata Pelajaran</th>
                        @role('Super Admin')
                        <th class="px-5 py-3">Sekolah</th>
                        @endrole
                        <th class="px-5 py-3 text-center w-28">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $index => $subject)
                    @php
                        $canModify = false;
                        if (auth()->user()->hasAnyRole(['Super Admin'])) {
                            $canModify = true;
                        } elseif (auth()->user()->hasAnyRole(['Guru Besar', 'Guru KAFA'])) {
                            if ($subject->school_id == auth()->user()->school_id && $subject->school_id !== null) {
                                $canModify = true;
                            }
                        }
                    @endphp
                    <tr id="row-{{ $subject->id }}">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $index + 1 }}</td>
                        <td class="px-5 py-3">
                            <code class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-xs font-mono font-medium">{{ $subject->code }}</code>
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $subject->name }}</td>
                        @role('Super Admin')
                        <td class="px-5 py-3">
                            @if($subject->school)
                                <span class="text-xs text-gray-600">{{ $subject->school->name }}</span>
                            @else
                                <span class="ek-badge ek-badge-gray">Global</span>
                            @endif
                        </td>
                        @endrole
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-center gap-2">
                                @if($canModify)
                                <a href="{{ route('subjects.edit', $subject->id) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                      data-delete-form data-name="mata pelajaran {{ $subject->name }}">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Padam">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-gray-400 italic">Paparan sahaja</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada data mata pelajaran dijumpai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

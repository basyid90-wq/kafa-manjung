@extends('layout-fb.layout')

@section('content')
<div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="ek-page-title">Bank Templat Sijil Digital</h1>
            <p class="ek-page-sub mt-1">Templat sijil yang tersedia untuk aktiviti dan program</p>
        </div>
        <a href="{{ route('certificates.templates.create') }}"
           class="ek-btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Templat
        </a>
    </div>

    <div class="ek-table-wrap">
        <div class="overflow-x-auto">
            <table class="ek-table">
                <thead>
                    <tr>
                        <th class="px-5 py-3 w-12">No</th>
                        <th class="px-5 py-3">Nama Templat</th>
                        <th class="px-5 py-3">Peringkat</th>
                        <th class="px-5 py-3">Susun Atur</th>
                        <th class="px-5 py-3">Sekolah / Daerah</th>
                        <th class="px-5 py-3 text-center w-20">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $i => $t)
                    <tr id="row-{{ $t->id }}">
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $templates->firstItem() + $i }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <p class="font-medium text-gray-900">{{ $t->name }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $t->level === 'daerah'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($t->level) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ ucfirst($t->layout_style) }}</td>
                        <td class="px-5 py-3 text-xs text-gray-500">
                            {{ $t->school->name ?? 'Templat Platform' }}
                        </td>
                        <td class="px-5 py-3 text-center">
                            <form method="POST"
                                  action="{{ route('certificates.templates.destroy', $t) }}"
                                  data-delete-form data-name="templat {{ $t->name }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Padam">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Tiada templat sijil didaftarkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($templates->hasPages())
        <div class="px-5 py-4 border-t border-gray-200">
            {{ $templates->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

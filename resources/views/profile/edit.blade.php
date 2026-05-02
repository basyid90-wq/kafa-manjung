@extends('layout-fb.layout')

@section('content')
<div class="p-4 md:p-6">

    <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Tetapan Profil</h1>

    {{-- Tabs --}}
    <div class="flex gap-1 mb-5 bg-gray-100 dark:bg-gray-800 rounded-xl p-1" id="profileTabs">
        <button type="button" id="tab-profile"
                onclick="switchTab('profile')"
                class="flex-1 px-4 py-2 text-xs font-medium rounded-lg transition-colors bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm">
            Maklumat Profil
        </button>
        <button type="button" id="tab-password"
                onclick="switchTab('password')"
                class="flex-1 px-4 py-2 text-xs font-medium rounded-lg transition-colors text-gray-500 dark:text-gray-400 hover:text-gray-700">
            Kata Laluan
        </button>
    </div>

    {{-- Profile Panel --}}
    <div id="panel-profile">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Password Panel --}}
    <div id="panel-password" class="hidden">
        @include('profile.partials.update-password-form')
    </div>
</div>

<script>
function switchTab(tab) {
    ['profile','password'].forEach(function(t) {
        document.getElementById('panel-' + t).classList.add('hidden');
        document.getElementById('tab-' + t).classList.remove('bg-white','dark:bg-gray-700','text-blue-600','dark:text-blue-400','shadow-sm');
        document.getElementById('tab-' + t).classList.add('text-gray-500','dark:text-gray-400');
    });
    document.getElementById('panel-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.add('bg-white','dark:bg-gray-700','text-blue-600','dark:text-blue-400','shadow-sm');
    document.getElementById('tab-' + tab).classList.remove('text-gray-500','dark:text-gray-400');
}
// Auto-open password tab if there are password errors
@if($errors->updatePassword->any())
document.addEventListener('DOMContentLoaded', function() { switchTab('password'); });
@endif
</script>
@endsection

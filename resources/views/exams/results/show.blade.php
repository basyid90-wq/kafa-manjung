@extends('layout.layout')

@section('content')
<a class="close_side_menu" href="javascript:void(0);"></a>
<x-background/>

<div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
    <div class="container">
        <div class="row mt--0">
            @include('partials.sidebar')

            <div class="col-lg-9">
                <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
                    <div class="content">
                        <div class="section-title d-flex justify-content-between align-items-center mb--30">
                            <div>
                                <h4 class="rbt-title-style-3">Paparan Markah</h4>
                                <span class="badge bg-primary-opacity text-primary px-3">{{ $exam->name }}</span>
                                <span class="badge bg-secondary-opacity text-secondary px-3">{{ $kafaClass->display_name }}</span>
                                <span class="badge bg-info-opacity text-info px-3">{{ $subject->name }}</span>
                            </div>
                            
                            <div class="rbt-button-group">
                                @if(!$is_locked)
                                    <a href="{{ route('exams.results.enter', request()->all()) }}" class="rbt-btn btn-sm btn-gradient">
                                        <i class="feather-edit me-1"></i> Kemaskini Markah
                                    </a>
                                    
                                    @role('Guru Besar')
                                    <form action="{{ route('exams.results.lock') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                                        <input type="hidden" name="kafa_class_id" value="{{ $kafaClass->id }}">
                                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                                        <button type="submit" class="rbt-btn btn-sm btn-danger px-4" style="background-color: #dc3545; border-color: #dc3545;" onclick="return confirm('Adakah anda pasti untuk mengesahkan dan mengunci markah ini? Tindakan ini tidak boleh diubah.')">
                                            <i class="feather-lock me-1"></i> Sahkan & Kunci
                                        </button>
                                    </form>
                                    @endrole
                                @else
                                    <span class="badge bg-success-opacity text-success p-3" style="font-size: 16px;">
                                        <i class="feather-check-circle me-1"></i> Disahkan & Dikunci
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- FIX 1: Warning if subject not linked to Rekod Pencapaian --}}
                        @if(!empty($slot_warning))
                        <div class="alert alert-warning d-flex align-items-start gap-2 mb--20">
                            <i class="feather-alert-triangle mt-1 flex-shrink-0"></i>
                            <div>
                                <strong>Subjek ini tiada <code>form_slot</code> yang dikenali.</strong>
                                Markah akan disimpan tetapi <strong>tidak akan muncul dalam Rekod Pencapaian Murid</strong>.
                                Sila tetapkan <em>Form Slot</em> yang betul pada subjek ini dalam Pengurusan Subjek.
                            </div>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="rbt-table table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Murid</th>
                                        <th>MyKid</th>
                                        <th class="text-center">Markah</th>
                                        <th class="text-center">Gred</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                    @php $res = $results->get($student->id); @endphp
                                    <tr id="row-{{ $student->id }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $student->name }}</strong></td>
                                        <td><small class="text-muted">{{ $student->mykid }}</small></td>
                                        <td class="text-center">
                                            @if($res)
                                                <span class="h5 mb-0">{{ $res->marks ?? '-' }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($res)
                                                @php $gradeClass = in_array($res->grade, ['E', 'TH']) ? 'bg-danger' : 'bg-primary'; @endphp
                                                <span class="badge {{ $gradeClass }} px-3">{{ $res->grade }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($res && $res->is_absent)
                                                <span class="badge bg-warning-opacity text-warning px-3">TH (Tidak Hadir)</span>
                                            @elseif($res && $res->marks !== null)
                                                <span class="badge bg-success-opacity text-success px-3">Hadir</span>
                                            @else
                                                <span class="badge bg-secondary-opacity text-secondary px-3">Belum Berisi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if($students->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center p-5 text-muted">Tiada senarai murid dijumpai untuk kelas ini.</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt--30">
                            <a href="{{ route('exams.results.index') }}" class="rbt-btn btn-border btn-sm">
                                <i class="feather-arrow-left me-1"></i> Kembali ke Pemilihan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary-opacity { background: rgba(110, 65, 255, 0.1); color: #6e41ff; }
    .bg-secondary-opacity { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .bg-info-opacity { background: rgba(0, 123, 255, 0.1); color: #007bff; }
    .bg-success-opacity { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .bg-warning-opacity { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
</style>
@endsection

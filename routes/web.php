<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookOrderController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DisciplinaryController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\TimetableController;


use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('home');

// Public routes — boleh akses tanpa login (dari login page)
Route::post('announcements/{announcement}/increment-view', [AnnouncementController::class, 'incrementView'])
    ->name('announcements.increment-view');

Route::get('/waktu-solat', function (\Illuminate\Http\Request $req) {
    $zone = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $req->query('zone', 'PRK09')));
    if (!preg_match('/^[A-Z]{2,3}\d{2}$/', $zone)) $zone = 'PRK09';
    try {
        $res = \Illuminate\Support\Facades\Http::timeout(10)
            ->get("https://www.e-solat.gov.my/index.php?r=esolatApi/takwimsolat&period=today&zone={$zone}");
        return response()->json($res->json());
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Gagal mendapatkan waktu solat'], 503);
    }
})->name('waktu.solat');

Route::middleware('auth')->group(function () {
    // 1. Dashboard & Profile
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Data Asas (Super Admin | Pentadbir sahaja)
    Route::middleware(['role:Super Admin|Pentadbir'])->group(function () {
        Route::resource('districts', DistrictController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('books', BookController::class)->except(['index']);
    });

    // Katalog Buku: Penyelia KAFA boleh lihat sahaja (read-only)
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA'])->group(function () {
        Route::get('books', [BookController::class, 'index'])->name('books.index');
    });

    // 2b. Pengurusan Sekolah & Pengguna (Penyelia KAFA - skop daerah)
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar'])->group(function () {
        Route::resource('schools', SchoolController::class);
        Route::resource('users', UserController::class);
        Route::resource('time_slots', TimeSlotController::class);
    });

    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA'])->group(function () {
        Route::resource('kafa_classes', \App\Http\Controllers\KafaClassController::class);
        Route::get('/get-teachers/{school_id}', [\App\Http\Controllers\KafaClassController::class, 'getTeachersBySchool'])->name('kafa_classes.get_teachers');
        Route::get('/get-classes/{school_id}', [\App\Http\Controllers\KafaClassController::class, 'getClassesBySchool'])->name('kafa_classes.get_classes');
        // Laluan spesifik students MESTI di atas Route::resource() supaya tidak ditangkap oleh {student} wildcard
        Route::post('students/bulk-delete', [\App\Http\Controllers\StudentController::class, 'bulkDestroy'])->name('students.bulk-delete');
        Route::post('students/import', [\App\Http\Controllers\StudentImportController::class, 'import'])->name('students.import');
        Route::get('students/import-summary', [\App\Http\Controllers\StudentImportController::class, 'summary'])->name('students.import_summary');
        Route::resource('students', \App\Http\Controllers\StudentController::class);
        Route::resource('exams', \App\Http\Controllers\ExamController::class);
        Route::resource('subjects', SubjectController::class);
    });

    // 3. Kehadiran
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar|Ibu Bapa'])->group(function () {
        Route::resource('attendances', \App\Http\Controllers\AttendanceController::class)->only(['index', 'store']);
    });
    // Cuti Berjadual — MESTI sebelum resource supaya 'bulk-leave' tidak ditangkap wildcard
    Route::middleware(['role:Super Admin|Pentadbir|Guru KAFA|Guru Besar'])->group(function () {
        Route::post('attendances/bulk-leave', [\App\Http\Controllers\AttendanceController::class, 'storeBulkLeave'])->name('attendances.bulk_leave');
    });
    // Kiosk QR scan
    Route::middleware(['role:Guru Besar|Guru KAFA|Super Admin|Pentadbir'])->group(function () {
        Route::get('kiosk', [\App\Http\Controllers\AttendanceController::class, 'kiosk'])->name('kiosk.index');
        Route::post('kiosk/scan', [\App\Http\Controllers\AttendanceController::class, 'scan'])->name('kiosk.scan');
    });
    // Cetak buku kedatangan PDF (bulan, tahun, total_days dihantar sebagai query string)
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar'])->group(function () {
        Route::get('attendances/{kafaClass}/pdf', [\App\Http\Controllers\AttendanceController::class, 'printPdf'])->name('attendances.pdf');
    });
    // Cetak kad QR murid mengikut kelas
    Route::middleware(['role:Super Admin|Pentadbir|Guru KAFA|Guru Besar'])->group(function () {
        Route::get('students/qr-cards/{kafaClass}', [\App\Http\Controllers\StudentController::class, 'printQrCards'])->name('students.qr_cards');
    });

    // 4. RPH (Rekod & Kelulusan)
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar'])->group(function () {
        Route::get('rph/create-gabungan', [\App\Http\Controllers\RphRecordController::class, 'createGabungan'])->name('rph.create_gabungan');
        Route::resource('rph', \App\Http\Controllers\RphRecordController::class);
        Route::get('rph/{rph}/pdf', [\App\Http\Controllers\RphPdfController::class, 'download'])->name('rph.pdf');
    });
    // Guru Besar: semak RPH Guru KAFA; Penyelia KAFA & Pentadbir: semak RPH Guru Besar
    Route::middleware(['role:Super Admin|Pentadbir|Guru Besar|Penyelia KAFA'])->group(function () {
        Route::get('rph_approvals', [\App\Http\Controllers\RphApprovalController::class, 'index'])->name('rph_approvals.index');
        Route::get('rph_approvals/history', [\App\Http\Controllers\RphApprovalController::class, 'history'])->name('rph_approvals.history');
        Route::put('rph_approvals/{rph}', [\App\Http\Controllers\RphApprovalController::class, 'update'])->name('rph_approvals.update');
    });
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA'])->group(function () {
        Route::put('rph_approvals/{rph}/revert', [\App\Http\Controllers\RphApprovalController::class, 'revert'])->name('rph_approvals.revert');
    });

    // 5. Peperiksaan & Markah
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar'])->group(function () {
        Route::get('exam-results', [\App\Http\Controllers\ExamResultController::class, 'index'])->name('exams.results.index');
        Route::get('exam-results/show', [\App\Http\Controllers\ExamResultController::class, 'show'])->name('exams.results.show');
        Route::get('exam-results/enter', [\App\Http\Controllers\ExamResultController::class, 'enterMarks'])->name('exams.results.enter');
        Route::post('exam-results', [\App\Http\Controllers\ExamResultController::class, 'store'])->name('exams.results.store');
        Route::post('exam-results/lock', [\App\Http\Controllers\ExamResultController::class, 'lockMarks'])->name('exams.results.lock');
    });
    Route::middleware(['role:Ibu Bapa'])->group(function () {
        Route::get('parent/dashboard', [\App\Http\Controllers\ParentController::class, 'dashboard'])->name('parent.dashboard');
        Route::get('my-children/{student}', [\App\Http\Controllers\ParentController::class, 'showStudent'])->name('parent.student.show');
        Route::get('my-children', [\App\Http\Controllers\ParentResultController::class, 'index'])->name('parent.results.index');
        Route::get('my-children/{student}/exams', [\App\Http\Controllers\ParentResultController::class, 'showResults'])->name('parent.results.show');
        Route::get('my-children/{student}/exams/{exam}', [\App\Http\Controllers\ParentResultController::class, 'detail'])->name('parent.results.detail');
    });
    // Certificate single download (Ibu Bapa + staff)
    Route::middleware('auth')->get('certificates/{studentCertificate}/pdf', [\App\Http\Controllers\CertificateBulkController::class, 'downloadSingle'])->name('certificates.single.pdf');

    // 6. Jadual Waktu
    Route::get('timetable', [\App\Http\Controllers\TimetableController::class, 'index'])->name('timetable.index');
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA'])->group(function () {
        Route::get('/timetable/create', [TimetableController::class, 'create'])->name('timetable.create');
        Route::post('/timetable', [TimetableController::class, 'store'])->name('timetable.store');
        Route::get('/timetable/print/{kafa_class_id}', [TimetableController::class, 'printPdf'])->name('timetable.pdf');
        Route::get('/timetable/{id}/edit', [TimetableController::class, 'edit'])->name('timetable.edit');
        Route::put('/timetable/{id}', [TimetableController::class, 'update'])->name('timetable.update');
        Route::delete('/timetable/{id}', [TimetableController::class, 'destroy'])->name('timetable.destroy');
    });

    // 7. Buku (Tempahan)
    // Cart routes MUST be before resource to avoid {book_order} wildcard capturing 'cart'
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar'])->group(function () {
        Route::get('book_orders/cart', [BookOrderController::class, 'cartView'])->name('book_orders.cart');
        Route::post('book_orders/cart/add', [BookOrderController::class, 'cartAdd'])->name('book_orders.cart.add');
        Route::post('book_orders/cart/clear', [BookOrderController::class, 'cartClear'])->name('book_orders.cart.clear');
        Route::get('supplier-summary', [BookOrderController::class, 'supplierSummary'])->name('book_orders.supplier_summary');
        Route::get('supplier-summary/pdf', [BookOrderController::class, 'supplierSummaryPdf'])->name('book_orders.supplier_summary.pdf');
    });

    Route::middleware(['role:Super Admin|Pentadbir|Pembekal|Penyelia KAFA|Guru Besar'])->group(function () {
        Route::get('book_orders/supplier', [BookOrderController::class, 'supplierIndex'])->name('book_orders.supplier_index');
    });

    Route::middleware(['role:Super Admin|Pentadbir|Pembekal|Guru Besar'])->group(function () {
        Route::post('book_orders/{book_order}/process', [BookOrderController::class, 'process'])->name('book_orders.process');
        Route::post('book_orders/{book_order}/deliver', [BookOrderController::class, 'deliver'])->name('book_orders.deliver');
    });

    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar'])->group(function () {
        Route::resource('book_orders', BookOrderController::class)->except(['show']);
        Route::post('book_orders/{book_order}/submit', [BookOrderController::class, 'submit'])->name('book_orders.submit');
        Route::post('book_orders/{book_order}/approve', [BookOrderController::class, 'approve'])->name('book_orders.approve');
        Route::post('book_orders/{book_order}/complete', [BookOrderController::class, 'complete'])->name('book_orders.complete');
    });

    // Wildcard show route at the bottom
    Route::get('book_orders/{book_order}', [BookOrderController::class, 'show'])
        ->name('book_orders.show')
        ->middleware(['role:Super Admin|Pentadbir|Pembekal|Penyelia KAFA|Guru Besar']);

    // 8. Komunikasi (Hebahan)
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Pembekal'])->group(function () {
        Route::get('announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

    // Super Admin only: Homepage announcements
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::get('announcements/create-homepage', [AnnouncementController::class, 'createHomepage'])->name('announcements.create-homepage');
        Route::post('announcements/store-homepage', [AnnouncementController::class, 'storeHomepage'])->name('announcements.store-homepage');
        Route::get('announcements/{announcement}/edit-homepage', [AnnouncementController::class, 'editHomepage'])->name('announcements.edit-homepage');
        Route::put('announcements/{announcement}/update-homepage', [AnnouncementController::class, 'updateHomepage'])->name('announcements.update-homepage');
    });

    // All authenticated users (except Ibu Bapa) can view announcements
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA|Pembekal|Bendahari Sekolah'])->group(function () {
        Route::get('announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    });

    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsReadAndRedirect'])->name('notifications.read');
    Route::post('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markRead');

    // 9. Kewangan
    // Penyelia KAFA: read-only (semak daerah) — tanpa keupayaan cipta atau simpan rekod
    Route::middleware(['role:Super Admin|Pentadbir|Bendahari Sekolah|Penyelia KAFA|Guru Besar'])->group(function () {
        Route::get('financial', [\App\Http\Controllers\FinancialController::class, 'index'])->name('financial.index');
        Route::get('financial/{record}/export', [\App\Http\Controllers\FinancialController::class, 'export'])->name('financial.export');
    });
    Route::middleware(['role:Super Admin|Pentadbir|Bendahari Sekolah'])->group(function () {
        Route::get('financial/create', [\App\Http\Controllers\FinancialController::class, 'create'])->name('financial.create');
        Route::post('financial', [\App\Http\Controllers\FinancialController::class, 'store'])->name('financial.store');
    });

    // 10. Disiplin Murid
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar|Ibu Bapa'])->group(function () {
        Route::get('disciplinary', [DisciplinaryController::class, 'index'])->name('disciplinary.index');
    });
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar'])->group(function () {
        Route::resource('disciplinary', DisciplinaryController::class)->only(['create', 'store', 'destroy']);
    });

    // 11. Aktiviti & Program
    // PENTING: group write (create/edit) MESTI didaftar DULU sebelum group show
    // supaya GET /activities/create tidak tersalah match dengan GET /activities/{activity}
    // Cipta, kemaskini, padam & kehadiran (Pentadbir TIDAK dibenarkan)
    Route::middleware(['role:Super Admin|Penyelia KAFA|Guru KAFA|Guru Besar'])->group(function () {
        Route::resource('activities', ActivityController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
        Route::get('activities/{activity}/attendance', [ActivityController::class, 'attendance'])->name('activities.attendance');
        Route::post('activities/{activity}/attendance', [ActivityController::class, 'saveAttendance'])->name('activities.save_attendance');
    });
    // Lihat sahaja (Pentadbir boleh view, tapi tak boleh cipta/edit/padam/kehadiran)
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru KAFA|Guru Besar'])->group(function () {
        Route::resource('activities', ActivityController::class)->only(['index', 'show']);
    });

    // 14. Sijil Digital
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA'])->group(function () {
        Route::get('certificates/templates', [\App\Http\Controllers\CertificateTemplateController::class, 'index'])->name('certificates.templates.index');
        Route::get('certificates/templates/create', [\App\Http\Controllers\CertificateTemplateController::class, 'create'])->name('certificates.templates.create');
        Route::post('certificates/templates', [\App\Http\Controllers\CertificateTemplateController::class, 'store'])->name('certificates.templates.store');
        Route::delete('certificates/templates/{certificatesTemplate}', [\App\Http\Controllers\CertificateTemplateController::class, 'destroy'])->name('certificates.templates.destroy');
        Route::post('activities/{activity}/certificates/generate', [\App\Http\Controllers\CertificateBulkController::class, 'generate'])->name('certificates.bulk.generate');
    });

    // 12. Laporan & Analisis
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar'])->group(function () {
        // Laluan spesifik MESTI di atas laluan wildcard {student}
        Route::get('reports/attendance', [\App\Http\Controllers\ReportController::class, 'attendance'])->name('reports.attendance');
        Route::get('reports/exams', [\App\Http\Controllers\ReportController::class, 'exams'])->name('reports.exams');
        Route::get('reports/exams/{school}/detail', [\App\Http\Controllers\ReportController::class, 'examsSchoolDetail'])->name('reports.exams.detail');
        Route::get('reports/rph', [ReportController::class, 'rphKpi'])->name('reports.rph_kpi');
        
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/bulk-export', [ReportController::class, 'bulkExport'])->name('reports.bulk.export');
        Route::get('reports/{student}', [ReportController::class, 'show'])->name('reports.show');
        Route::get('reports/{student}/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        Route::get('reports/{student}/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    });

    // 13. Pindah Murid
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar'])->group(function () {
        Route::get('student_transfers/get-students/{class_id}', [\App\Http\Controllers\StudentTransferController::class, 'getStudentsByClass'])->name('student_transfers.get_students');
        Route::resource('student_transfers', \App\Http\Controllers\StudentTransferController::class);
    });


    Route::get('/pengurusan', function () { return view('pengurusan.index'); })->name('pengurusan.index');

    // 16. Rekod Pencapaian Murid
    Route::middleware(['role:Super Admin|Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA'])->group(function () {
        Route::get('achievements', [\App\Http\Controllers\StudentAchievementController::class, 'index'])->name('achievements.index');
        Route::get('achievements/school/{school}', [\App\Http\Controllers\StudentAchievementController::class, 'schoolList'])->name('achievements.school_list');
        Route::get('achievements/create', [\App\Http\Controllers\StudentAchievementController::class, 'create'])->name('achievements.create');
        Route::post('achievements', [\App\Http\Controllers\StudentAchievementController::class, 'store'])->name('achievements.store');
        Route::get('achievements/{achievement}/edit', [\App\Http\Controllers\StudentAchievementController::class, 'edit'])->name('achievements.edit');
        Route::get('achievements/{achievement}', [\App\Http\Controllers\StudentAchievementController::class, 'show'])->name('achievements.show');
        Route::get('achievements/{achievement}/pdf', [\App\Http\Controllers\StudentAchievementController::class, 'generatePdf'])->name('achievements.pdf');
        Route::post('achievements/bulk-finalize', [\App\Http\Controllers\StudentAchievementController::class, 'bulkFinalize'])->name('achievements.bulk_finalize');
        Route::post('achievements/{achievement}/unlock', [\App\Http\Controllers\StudentAchievementController::class, 'unlock'])->name('achievements.unlock');
    });

    // 15. Panduan Pengguna
    Route::get('/manual/download', [\App\Http\Controllers\ManualController::class, 'download'])->name('manual.download');
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::get('/admin/manual-logs', [\App\Http\Controllers\ManualController::class, 'logs'])->name('admin.manual.logs');
    });

    // 18. Chatbot AI
    // All authenticated users — send message
    Route::post('chatbot/message', [\App\Http\Controllers\ChatbotController::class, 'message'])->name('chatbot.message');
    // Super Admin only — manage settings
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::get('super-admin/chatbot-settings', [\App\Http\Controllers\ChatbotController::class, 'settings'])->name('chatbot.settings');
        Route::patch('super-admin/chatbot-settings/provider/{provider}', [\App\Http\Controllers\ChatbotController::class, 'updateProvider'])->name('chatbot.provider.update');
        Route::post('super-admin/chatbot-settings/activate/{provider}', [\App\Http\Controllers\ChatbotController::class, 'activateProvider'])->name('chatbot.provider.activate');
        Route::post('super-admin/chatbot-settings/toggle-data', [\App\Http\Controllers\ChatbotController::class, 'toggleDataAccess'])->name('chatbot.toggle-data');
        Route::post('super-admin/chatbot-settings/bot-profile', [\App\Http\Controllers\ChatbotController::class, 'updateBotProfile'])->name('chatbot.bot-profile');
    });

    // 17. Aduan / Laporkan Masalah
    // Semua role kecuali Super Admin boleh hantar aduan
    Route::middleware(['role:Pentadbir|Penyelia KAFA|Guru Besar|Guru KAFA|Pembekal|Bendahari Sekolah|Ibu Bapa'])->group(function () {
        Route::get('feedback/create', [\App\Http\Controllers\FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');
    });
    // Super Admin: lihat & urus semua aduan
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::get('feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('feedback/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'show'])->name('feedback.show');
        Route::patch('feedback/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'update'])->name('feedback.update');
        Route::get('admin/system-log', [\App\Http\Controllers\FeedbackController::class, 'systemLog'])->name('admin.system_log');
    });
});

// Public certificate verification (no auth required)
Route::get('/verify-certificate/{refNo}', [\App\Http\Controllers\CertificateBulkController::class, 'verify'])->name('certificates.verify');

require __DIR__.'/auth.php';

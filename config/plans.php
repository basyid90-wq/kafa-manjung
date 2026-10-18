<?php

/*
|--------------------------------------------------------------------------
| eKafa Online subscription plans
|--------------------------------------------------------------------------
| Plans are ranked: a module unlocked in a lower plan is included in every
| higher plan. Limits set to null are unlimited. A paid plan that expired
| more than `grace_days` ago falls back to "free" (data is kept, modules lock).
*/

return [

    'grace_days' => 3,

    'plans' => [
        'free' => [
            'label'                  => 'Percuma',
            'rank'                   => 0,
            'max_classes'            => 3,
            'max_students_per_class' => 40,
        ],
        'personal' => [
            'label'                  => 'Personal',
            'rank'                   => 1,
            'max_classes'            => null,
            'max_students_per_class' => null,
        ],
        'sekolah' => [
            'label'                  => 'Sekolah',
            'rank'                   => 2,
            'max_classes'            => null,
            'max_students_per_class' => null,
        ],
    ],

    // Which plans each workspace type may subscribe to
    'types' => [
        'personal' => ['label' => 'Guru (Personal)', 'plans' => ['free', 'personal']],
        'sekolah'  => ['label' => 'Sekolah',         'plans' => ['free', 'sekolah']],
    ],

    // module key => [label, minimum plan]
    'modules' => [
        // Percuma
        'kelas'            => ['label' => 'Kelas',                     'plan' => 'free'],
        'murid'            => ['label' => 'Murid',                     'plan' => 'free'],
        'kehadiran'        => ['label' => 'Kehadiran Harian',          'plan' => 'free'],
        'jadual_waktu'     => ['label' => 'Jadual Waktu',              'plan' => 'free'],
        'peperiksaan'      => ['label' => 'Peperiksaan & Markah',      'plan' => 'free'],

        // Personal
        'kehadiran_qr'     => ['label' => 'Kehadiran QR / Kiosk',      'plan' => 'personal'],
        'import_murid'     => ['label' => 'Import Murid (Excel)',      'plan' => 'personal'],
        'rph'              => ['label' => 'Rekod RPH',                 'plan' => 'personal'],
        'pencapaian'       => ['label' => 'Rekod Pencapaian Murid',    'plan' => 'personal'],
        'disiplin'         => ['label' => 'Disiplin Murid',            'plan' => 'personal'],
        'aktiviti'         => ['label' => 'Aktiviti',                  'plan' => 'personal'],
        'sijil'            => ['label' => 'Sijil Digital',             'plan' => 'personal'],
        'laporan_murid'    => ['label' => 'Laporan Murid',             'plan' => 'personal'],
        'chatbot'          => ['label' => 'Pembantu AI',               'plan' => 'personal'],

        // Sekolah
        'pengguna'         => ['label' => 'Urus Guru & Pengguna',      'plan' => 'sekolah'],
        'kelulusan_rph'    => ['label' => 'Semakan & Kelulusan RPH',   'plan' => 'sekolah'],
        'laporan_sekolah'  => ['label' => 'Laporan & KPI Sekolah',     'plan' => 'sekolah'],
        'kewangan'         => ['label' => 'Kewangan',                  'plan' => 'sekolah'],
        'hebahan'          => ['label' => 'Hebahan Sekolah',           'plan' => 'sekolah'],
        'portal_ibu_bapa'  => ['label' => 'Portal Ibu Bapa',           'plan' => 'sekolah'],
        'pindah_murid'     => ['label' => 'Pindah Murid',              'plan' => 'sekolah'],
    ],

];

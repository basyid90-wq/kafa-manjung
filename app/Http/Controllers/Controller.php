<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /** Tenant guard: abort 403 unless the current user may access data of the given school. */
    protected function authorizeSchool($schoolId): void
    {
        abort_unless(auth()->user()?->canAccessSchool($schoolId), 403);
    }

    /** Student guard: abort 403 unless the user may access the student (Guru KAFA: own classes only). */
    protected function authorizeStudent(\App\Models\Student $student): void
    {
        abort_unless(auth()->user()?->canAccessStudent($student), 403);
    }
}

<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /** Tenant guard: abort 403 unless the current user may access data of the given school. */
    protected function authorizeSchool($schoolId): void
    {
        abort_unless(auth()->user()?->canAccessSchool($schoolId), 403);
    }
}

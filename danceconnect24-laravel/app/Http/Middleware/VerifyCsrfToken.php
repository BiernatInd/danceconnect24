<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/authentication/login',
        '/authentication/register',
        '/authentication/recover-password',
        '/authentication/reset-password',
        '/authentication/logout',
        '/authentication/admin-access',
        '/authentication/school-access',
        '/authentication/user-access',

        '/main/classes',
        '/main/checkout',
        '/main/buy-school-account',
        '/main/contact',

        '/user/classes',
        '/user/classes-page',
        '/user/change-email',
        '/user/change-password',
        '/user/delete',

        '/school/classes',
        '/school/classes-page',
        '/school/clients',
        '/school/edit',
        '/school/delete',
        '/school/change-email',
        '/school/change-password',
        '/school/add',
        '/school/delete-account',

        '/admin/change-email',
        '/admin/change-password',
        '/admin/events-page',
        '/admin/classes-page',
        '/admin/classes',
        '/admin/users',
        '/admin/classes-delete',
        '/admin/users-delete',
    ];
}

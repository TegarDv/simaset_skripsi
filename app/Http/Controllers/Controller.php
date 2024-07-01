<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Gate;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function authorizeSuperAdmin()
    {
        if (!Gate::allows('isSuperAdmin')) {
            abort(403);
        }
    }
    protected function authorizeAdminOrSuperAdmin()
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin')) {
            abort(403);
        }
    }
    protected function authorizeAllUser()
    {
        if (!Gate::allows('isSuperAdmin') && !Gate::allows('isAdmin') && !Gate::allows('isUser')) {
            abort(403);
        }
    }
}

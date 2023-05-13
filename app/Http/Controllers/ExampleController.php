<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenException;
use App\Exceptions\ServiceException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExampleController extends BaseController
{
    public function index(Request $request)
    {
        return $this->responseSuccess(User::customPaginate(1, 2));
    }
}

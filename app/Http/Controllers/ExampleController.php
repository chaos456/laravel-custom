<?php

namespace App\Http\Controllers;

use App\Constants\ResponseCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExampleController extends BaseController
{
    public function index(Request $request)
    {
        Log::info('123');
        $data = User::query()->customPaginate();

        return $this->response(ResponseCode::SUCCESS, $data, '成功');
    }
}

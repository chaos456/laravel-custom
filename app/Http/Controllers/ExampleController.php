<?php

namespace App\Http\Controllers;

use App\Constants\ResponseCode;
use App\Models\User;
use Illuminate\Http\Request;

class ExampleController extends BaseController
{
    public function index(Request $request)
    {
        $data = User::query()->whereEqDate('updated_at', '2023-05-13')->customPaginate(1);

        return $this->response(ResponseCode::SUCCESS, $data, '成功');
    }
}

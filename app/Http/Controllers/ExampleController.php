<?php

namespace App\Http\Controllers;

use App\Constants\ResponseCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class ExampleController extends BaseController
{
    public function index(Request $request)
    {
        return $this->response(ResponseCode::SUCCESS, [], '成功');
    }
}

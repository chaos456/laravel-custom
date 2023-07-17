<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Support\AsyncExec;
use App\Support\CustomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    public function customPage(Request $request)
    {
        $user = Admin::query()->customPaginate();

        return $this->responseSuccess($user);
    }

    public function customSimplePage()
    {
        $user = Admin::query()->customSimplePaginate();

        return $this->responseSuccess($user);
    }

    public function exception()
    {
        $a = new \stdClass();

        return $this->responseSuccess([
            'a' => $a->name
        ]);
    }

    public function serial(Request $request)
    {
        sleep(5);

        return $this->responseSuccess();
    }

    public function asyncExec(Request $request)
    {
        AsyncExec::defer(function () {
            sleep(5);
            Log::info('abc');
        });

        return $this->responseSuccess();
    }

    public function whereEqDate(Request $request)
    {
        $user = Admin::query()->whereEqDate('created_at', '2018-03-15')->customPaginate();

        $user->getCollection()->transform(function ($value) {
            return [
                'id'         => $value->id,
                'nickname'   => $value->nickname,
                'created_at' => $value->created_at->toDateTimeString(),
            ];
        });

        return $this->responseSuccess($user);
    }

    public function log()
    {
        Log::info('123');
        CustomLog::channel('test')->info('123');
        return $this->responseSuccess();
    }
}

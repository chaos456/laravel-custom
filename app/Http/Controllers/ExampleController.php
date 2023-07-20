<?php

namespace App\Http\Controllers;

use App\Enums\LogChannelEnum;
use App\Exceptions\CommonException;
use App\Models\AdminModel;
use App\Support\AsyncExec\AsyncExec;
use App\Support\Log\CustomLog;
use Illuminate\Http\Request;

class ExampleController extends BaseController
{
    public function customPage(Request $request)
    {
        $user = AdminModel::query()->customPaginate();

        // 如果需要修改list各元素返回信息，比如这里我想如下那么返回
        $user->getCollection()->transform(function ($value) {
            return [
                'id' => $value->id
            ];
        });

        return $this->responseSuccess($user);
    }

    public function customSimplePage()
    {
        $user = AdminModel::query()->customSimplePaginate();

        return $this->responseSuccess($user);
    }

    public function exception()
    {
        throw new CommonException('报错啦');
        $a = new \stdClass();

        return $this->responseSuccess([
            'a' => $a->name
        ]);
    }

    public function serial(Request $request)
    {
        sleep(8);

        return $this->responseSuccess();
    }

    public function asyncExec(Request $request)
    {
        AsyncExec::defer(function () {
            sleep(5);
            CustomLog::channel()->info('abc');
        });

        return $this->responseSuccess();
    }

    public function apiPre(Request $request)
    {
        return $this->responseSuccess();
    }
}

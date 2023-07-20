<?php

namespace App\Http\Controllers;

use App\Support\Traits\ApiResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

abstract class BaseController extends Controller
{
    //
    use ApiResponse;

    public function __construct(Request $request)
    {
        $controllerName = $request->route()[1]["uses"];

        $flag = preg_match("/Controllers\\\(.*)@(.*)/", $controllerName, $match);
        if ($flag) {
            $controllerName = $match[1];
            $actionName = $match[2];
            $class = "\\App\\Http\\Validate\\$controllerName" . "Validate";
            //判断验证是否存在
            if (class_exists($class) && method_exists($class, $actionName)) {
                $instance = new $class();
                $instance->$actionName($request);
            }
        }
    }
}

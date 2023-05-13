# laravel-custom
个人自定义laravel项目，用于快速构建laravel api项目<br/>
主要改动如下
## 目录结构

- Support 存放支持项目运行的类与助手函数文件helper.php
- Traits 存放项目用到的trait
- Services 存放服务类 包括三方接口服务、项目服务等
- Constants 存放常量类、枚举类 

## 统一接口响应
### 响应结构
``` code
{
    "code": 1, // int 类型
    "data": {}, // object 类型
    "msg": "成功" // string 类型
}
```
### 响应码、响应msg枚举
详见 [ResponseCode](./app/Constants/ResponseCode.php)
### 实现
在需要标准返回的类中引入trait [ApiResponse](./app/Traits/ApiResponse.php) 并调用其三个方法之一
```php
<?php

namespace App\Http\Controllers;

use App\Constants\ResponseCode;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ExampleController extends BaseController
{
    use ApiResponse;
    
    public function responseExample(Request $request)
    {
        $data = [
            'name' => '张三'
        ];

        return $this->response(ResponseCode::SUCCESS, $data, '成功');
    }

    public function responseSuccessExample(Request $request)
    {
        $data = [
            'name' => '张三'
        ];
        return $this->responseSuccess($data);
    }

    public function responseErrorExample(Request $request)
    {
        return $this->responseError('系统开小差了～');
    }
}
```
## 统一异常处理


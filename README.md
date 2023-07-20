<h1 align="center">lumen api基础框架</h1>
<p align="center">基于lumen框架再封装，方便api接口项目的统一规范快速开发</p>

<!-- TOC -->
* [新增目录结构及注意点](#新增目录结构及注意点)
  * [Services](#services)
  * [Logics](#logics)
  * [Enums](#enums)
  * [Bean](#bean)
  * [Contracts](#contracts)
  * [Http/Validate](#httpvalidate)
  * [Rules](#rules)
  * [Jobs/Consumers](#jobsconsumers)
  * [Support](#support)
* [写法规范及建议](#写法规范及建议)
  * [controller层](#controller层)
  * [command层](#command层)
  * [model层](#model层)
  * [路由规范](#路由规范)
  * [接口出入参规范](#接口出入参规范)
  * [其他规范](#其他规范)
* [基础框架新特性及使用建议](#基础框架新特性及使用建议)
  * [统一api json响应](#统一api-json响应)
    * [响应码、响应msg枚举](#响应码响应msg枚举)
    * [实现](#实现)
    * [使用](#使用)
  * [统一分页接口出入参](#统一分页接口出入参)
    * [响应结构](#响应结构)
    * [页码参数、每页条数参数定义](#页码参数每页条数参数定义)
    * [使用](#使用-1)
  * [统一异常处理](#统一异常处理)
    * [概述](#概述)
    * [预定的异常类型](#预定的异常类型)
  * [日志](#日志)
    * [概述](#概述-1)
    * [使用参考](#使用参考)
    * [待完善](#待完善)
  * [为Eloquent Model定义实用宏方法](#为eloquent-model定义实用宏方法)
    * [概述](#概述-2)
    * [自定义方法综述](#自定义方法综述)
    * [使用参考](#使用参考-1)
  * [串行化（防止一个资源在同一时间被占用）中间件](#串行化防止一个资源在同一时间被占用中间件)
    * [概述](#概述-3)
    * [使用参考](#使用参考-2)
  * [定义 service controller model等基类](#定义-service-controller-model等基类)
  * [异步执行者](#异步执行者)
    * [概述](#概述-4)
    * [使用参考](#使用参考-3)
  * [枚举类翻译](#枚举类翻译)
    * [概述](#概述-5)
    * [使用参考](#使用参考-4)
  * [InstanceMake trait](#instancemake-trait)
    * [概述](#概述-6)
    * [使用参考](#使用参考-5)
  * [api 请求前置验证](#api-请求前置验证)
    * [概述](#概述-7)
    * [使用参考](#使用参考-6)
  * [统一对外接口访问http client](#统一对外接口访问http-client)
    * [概述](#概述-8)
    * [使用参考](#使用参考-7)
* [其他](#其他)
  * [待完善归集](#待完善归集)
  * [问答](#问答)
<!-- TOC -->

# 新增目录结构及注意点
在lumen框架的基础上新增了若干基础目录，方便代码分层，下述目录皆在app目录下
## Services
- 服务层，如外部接口服务、通用服务（短信、邮件、文件上传）等
- 命名规则XxxService
- 部分service未来可视情况改造为由写通用composer包引入
- 不应将项目业务逻辑写在service层，应在logic层
## Logics
- 通用业务逻辑层，不建议将一次性的业务逻辑写在此处，应写在具体的controller、command、队列层
- 命名规则XxxLogic
## Enums
- 常量枚举层
- 命名规则XxxEnum
## Bean
- 数据对象层
- 当调用某个方法的实际传参超过3个建议引入bean精简以及规范写法
- 命名规则BeanLogic
- Bean各属性命名采用蛇形命名（方便与数据库字段和前端入参保持一致）
## Contracts
- 契约层，存放代码中通用需要遵守的契约
- 命名规则XxxContract
- 只允许存放interface文件
## Http/Validate
- 验证层，存放控制器某某方法需要的前置验证
- 建议将api接口前置的验证操作写在此处
- 命名规则XxxControllerValidate
- 目录结构层级和对应的Controller应保持一致 
## Rules
- 自定义验证规则层，如手机号、邮箱、身份证验证规则等
- 命名规则XxxRule
## Jobs/Consumers
- rabbitmq消费者层
- 命名后缀不用跟Consumer
- 在consumer直接完成代码逻辑编写（注意是否有通用的service、logic等可以调用，精简代码编写）
- 建议将订阅同一个事件的consumer放在同一子目录，方便查看该事件执行了哪些操作
## Support
- 支持层，存放支持框架运转的类库
- 一般这层开发者不需要改造
- 目录下helpers文件，可以写一些通用助手函数
- 注意support层突出维持基础框架运转，不应该service层完成某某具体功能混淆
- 未来部分类库可视情况改造为由写通用composer包引入
# 写法规范及建议
## controller层
- 视情况是否需要引入Http/Validate验证层完成前置验证
- 在controller直接完成代码逻辑编写（注意是否有通用的service、logic等可以调用，精简代码编写）
## command层
- 在command直接完成代码逻辑编写（注意是否有通用的service、logic等可以调用，精简代码编写）
- 命名后缀不用跟command
- command 的signature建议参考官方统一小写
- 建议在command的description描述好命令具体实现功能
- 建议同功能模块的command加入同一命名空间并放入同一目录作统一管理，参考官方例子如下
```
 queue
  queue:batches-table  Create a migration for the batches database table
  queue:clear          Delete all of the jobs from the specified queue
  queue:failed         List all of the failed queue jobs
  queue:failed-table   Create a migration for the failed queue jobs database table
  queue:flush          Flush all of the failed queue jobs
  queue:forget         Delete a failed queue job
  queue:listen         Listen to a given queue
  queue:restart        Restart queue worker daemons after their current job
  queue:retry          Retry a failed queue job
  queue:table          Create a migration for the queue jobs database table
  queue:work           Start processing jobs on the queue as a daemon
```
## model层
- 命名规则XxxModel
- 数据模型的访问器、关联关系等可以写在此
- 模型中不建议写通用查询方法，建议放在业务逻辑层
## 路由规范
- 只使用get、post方法，一般而言获取信息用get，其他都用post
- 用路由名称表达语义，尽量做到见名知意
## 接口出入参规范
- 出参，入参变量名统一采用蛇形命名如order_id而不是orderId
- 出入参变量类型应与接口文档保持一致
- data只应该响应对象，不应该偶尔响应数组偶尔响应对象，如果data需要响应数组需在外层加一个list包裹（若data一下是array一下是object对强类型语言不太友好）
## 其他规范
- 接口错误响应码，建议需要前端特殊处理的地方定义特殊错误码，如401代码认证失败，前端需要重新登录认证。其他错误用通用错误码返回即可，利用具体msg区分
# 基础框架新特性及使用建议
## 统一api json响应
### 响应码、响应msg枚举
详见 [ResponseCode](./app/Enums/ResponseCodeEnum.php)<br/>
所有需要返回的响应码及响应信息建议统一在此处管理
### 实现
详见 [ApiResponse](./app/Support/Traits/ApiResponse.php)
### 使用
```php
class ExampleController
{
    // 在需要统一json响应的地方引入此trait
    use \App\Support\Traits\ApiResponse;
    
    // 通用成功响应
    public function success()
    {
        return $this->responseSuccess(['name' => 'abc']);
    }
    
    // 通用失败响应
    public function error()
    {
        // 默认错误返回码为500，可以在第二个参数调整
        return $this->responseError('报错啦！', 502);
        
        return $this->responseError('系统错误');
    }
    
    // 自定义响应（一般很少用到）
    public function custom()
    {
        return $this->response(123, ['name' => 'abc'], '自定义');
    }
}
```
## 统一分页接口出入参
### 响应结构
```
// 普通分页，需要查询count
{
    "code": 200,
    "data": {
        "total": 15,
        "list": [
            {
                "id": 7
            }
        ]
    },
    "msg": "成功",
    "log_id": "9216febf3716463384113e033c49f8ad"
}

// 简单分页，不查询count
{
    "code": 200,
    "data": {
        "list": [
            {
                "id": 7
            }
        ]
    },
    "msg": "成功",
    "log_id": "9216febf3716463384113e033c49f8ad"
}
```
### 页码参数、每页条数参数定义
[support.php](./config/support.php)中pagination部分
### 使用
参考[ExampleController](./app/Http/Controllers/ExampleController.php)中customPage及customSimplePage
## 统一异常处理
### 概述
- 所有未在程序中捕获处理的异常统一会在[Handler](./app/Exceptions/Handler.php)中处理，我们可以在此处理程序遇到异常时的报告和前端响应
- 遇到预料之外的错误，当在调试环境时会返回具体错误信息，非调试环境只会返回系统错误，两者都会返回log_id方便排错及调试
- 我们可以在Exceptions目录中定义异常类型及他们的render（影响错误响应）和report（影响错误具体报告）方法，默认走的是[Handler](./app/Exceptions/Handler.php)的处理方式
### 预定的异常类型
- CommonException 通用异常，只作前端异常提示，不会记录错误日志
- UnauthorizedException 认知失败异常，响应码401，在用户未登录/token失效时抛出
- ForbiddenException 权限不足异常，响应码403
- ServiceException services层遇到具体错误可以抛出此异常
- LogicException logics层遇到具体错误可以抛出此异常

## 日志
### 概述
- api接口日志已通过相关中间件根据log_id打通，所有日志将携带统一的log_id，方便调试排错
- 日志可记入不同channel，目前不同channel的日志是放在不同文件
- api请求日志，mysql、redis查询日志可通过env控制开不开启，建议本地，测试环境全都打开，线上环境看情况决定打不打开
- 可在command或job开始执行前 执行 \App\Support\Log\LogContext::instance()->setLogId(); 打通日志链路
- 我们在拿到log_id后可以通过进入日志目录通过 cat * | grep 'log_id'命令 或在 sls服务中输入log_id查看某次请求、command、job过程中打印的所有日志
### 使用参考
详见[Example命令](./app/Console/Commands/Example.php)log方法
```bash
php artisan example log
```
### 待完善
- 通过配置项支持日志的不同输出形式，如日志输出为同一条json，减少磁盘io
## 为Eloquent Model定义实用宏方法
### 概述
- 我们在日常开发过程中，经常会遇到一些类似的查询比如说我要查某时间字段（格式为Y-m-d H:i:s）时间为今天的，
这边为模型增加了相关自定义宏方法方便调用，前面提到的统一模型查询分页也是据此实现
- 开发者可按需在[BuilderMacro](./app/Support/Macros/BuilderMacro.php)中定义自己的常用宏方法，并在[BuildMacroIdeHelper](./app/Support/Macros/BuildMacroIdeHelper.php)添加注释以获得编辑器友好提示
- 因为BaseModel引入了[BuildMacroIdeHelper](./app/Support/Macros/BuildMacroIdeHelper.php)所以能得到编辑器友好提示
### 自定义方法综述
- whereEqDate(string $field, string $date)
- whereToday(string $field)
- whereYesterday(string $field)
- whereLike(string $field, string $value, string $type = "left|right|")
- customPaginate(int $page = null, int $perPage = null)
- customSimplePaginate(int $page = null, int $perPage = null)
- customExist()
- insertOnDuplicate(array $attribute, array $onDuplicate)
### 使用参考
详见[Example命令](./app/Console/Commands/Example.php)中的buildMacro方法
```bash
php artisan example buildMacro
```
## 串行化（防止一个资源在同一时间被占用）中间件
### 概述
- 我们日常开发过程中，经常会遇到类似的场景，比如同一个资源在同一时间内，我只允许有一个请求在处理
- 具体实现参考[Serial](./app/Http/Middleware/Serial.php)，利用了laravel框架自带的redis lock
### 使用参考
```php
// 此处代表这个路由，对请求参数order_id加锁5秒，对于同一order_id的请求只会有一个在运行
// 如果请求获取不到锁，会 throw new CommonException('当前资源正在被处理，请稍后再试~') 进行统一异常处理
$router->get('/example/serial', ['middleware' => 'serial:order_id,5', 'uses' => 'ExampleController@serial']);
```

## 定义 service controller model等基类
- [BaseController](./app/Http/Controllers/BaseController.php)
- [BaseModel](./app/Models/BaseModel.php)
- [BaseService](./app/Services/BaseService.php)
- [BaseLogic](./app/Logics/BaseLogic.php)
## 异步执行者
### 概述
- 我们日常api开发中，可以选择将一些简单次要的流程交由异步执行者处理，而不是只有队列一个选择
- 异步执行者会在响应http请求后继续占用php fpm运行
- 不应该将大量耗时的任务交由异步执行者处理，如果有大量请求，会导致php fpm进程大量被占用
### 使用参考
详见[ExampleController](./app/Http/Controllers/ExampleController.php)中asyncExec方法
## 枚举类翻译
### 概述
- 我们日常开发中经常需要对枚举类进行相关翻译，这里进行了统一封装
- 需要翻译的枚举类需要继承[BaseEnum](./app/Enums/BaseEnum.php)
### 使用参考
详见[Example命令](./app/Console/Commands/Example.php)中的enum方法
```bash
php artisan example enum
```

## InstanceMake trait
### 概述 
- 引入此trait可以完成类快速的实例化
- 可以快速初始化实例或者单例
### 使用参考
详见[Example命令](./app/Console/Commands/Example.php)中的instanceMake方法
```bash
php artisan example instanceMake
```
## api 请求前置验证
### 概述
我们在api开发过程中，经常需要对请求进行前置认证，可以选择在与XxxController目录层级以及名称对应的Validate层完成前置验证操作，这里要求a和b参数都存在且为int，然后加起来大于10才通过验证
### 使用参考
参考[ExampleController](./app/Http/Controllers/ExampleController.php)中apiPre方法及[ExampleController](./app/Http/Validate/ExampleControllerValidate.php)中apiPre方法
## 统一对外接口访问http client
### 概述
- 我们在项目开发中，经常需要对某一个api服务进行访问，这边进行了统一[UnityHttpClient](./app/Support/Http/UnityHttpClient.php)封装
- 统一unity http client使用了InstanceMake trait
### 使用参考
- [ExampleApiService](./app/Services/ExampleApiService.php)，注意查看每个方法具体注释
# 其他
## 待完善归集
- 许多可复用的service服务类，比如发短信，oss文件处理等服务未来可做成composer包，方便各方引入调用
- 框架Support层相关类库未来可以做成composer包方便各方引入调用
- 通过配置项支持日志的不同输出形式，如日志输出为同一条json，减少磁盘io
## 问答
- Q:为什么选择直接在controller、command、job层写代码逻辑而不是直接转发给XxLogic处理？<br/>A:因为目前大部分控制器、命令的代码逻辑都是一次性的，经过讨论决定直接在这些层写代码逻辑，无谓多一层转发（注意是否有可复用的service或logic可以调用）。
- Q:为什么service、logic、model等类名需要跟XxxService、XxxLogic等后缀，而command、mq消费者、middleware等不跟<br/>A:因为service、logic等层面的代码需要在其他层面调用，为了做到见名知意。而command、middleware基本不会在外部调用，或者调用的地方已经确定了它是command、middleware。

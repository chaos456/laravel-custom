<?php

namespace App\Console\Commands;

use App\Bean\ExampleBean;
use App\Enums\ExampleEnum;
use App\Enums\ResponseCodeEnum;
use App\Models\AdminModel;
use App\Services\ExampleService;
use App\Support\AsyncExec\AsyncExec;
use App\Support\Log\CustomLog;
use App\Support\Log\LogContext;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Example extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'example {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'example';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->$name();

        return self::SUCCESS;
    }

    /**
     * log example
     * @return void
     */
    public function log()
    {
        // 打通日志链路
        LogContext::instance()->setLogId();

        // 不指定channel名称在默认channel记录日志
        CustomLog::channel()->info('日志1', ['a' => 1]);

        // 指定channel名称记录日志，不同channel日志会记录在不同的文件里面（支持子目录形式）
        CustomLog::channel('abc')->info('日志2', ['a' => 1]);
        CustomLog::channel('abc/abc')->info('日志3', ['a' => 1]);
    }

    /**
     * enum example
     * @return void
     */
    public function enum()
    {
        // 翻译sex列SEX_MALE常量
        dump(ExampleEnum::useColumn('sex')->translate(ExampleEnum::SEX_MALE));

        // 翻译status列STATUS_OPEN常量
        dump(ExampleEnum::useColumn('status')->translate(ExampleEnum::STATUS_OPEN));

        // 获取sex列所有值
        dump(ExampleEnum::useColumn('sex')->values());

        // 检索sex列是否有某值
        dump(ExampleEnum::useColumn('sex')->has(1));
        dump(ExampleEnum::useColumn('sex')->has(3));
    }

    /**
     * buildMacro example
     * @return void
     */
    public function buildMacro()
    {
        // 打通日志链路
        LogContext::instance()->setLogId();

        // select * from `admin` where `created_at` between '2023-07-01 00:00:00' and '2023-07-01 23:59:59'
        AdminModel::query()->whereEqDate('created_at', '2023-07-01')->get();

        // select * from `admin` where `created_at` between '2023-07-20 00:00:00' and '2023-07-20 23:59:59'
        // 注意以具体时间为准
        AdminModel::query()->whereToday('created_at')->get();

        // select * from `admin` where `admin_name` like '%王%'
        AdminModel::query()->whereLike('admin_name', '王')->get();

        // select * from `admin` where `admin_name` like '王%'
        AdminModel::query()->whereLike('admin_name', '王', 'l')->get();

        // select * from `admin` where `admin_name` like '%王'
        AdminModel::query()->whereLike('admin_name', '王', 'r')->get();
    }

    /**
     * instanceMake example
     * @return void
     */
    public function instanceMake()
    {
        // make和instance具体的参数列表由具体类__construct函数决定，如果不需要具体参数就不传

        // 获取ExampleService单例，下面例子会输出孙，孙，孙
        dump(ExampleService::instance('孙', 11)->getName());
        dump(ExampleService::instance('李', 12)->getName());
        dump(ExampleService::instance()->getName());

        // 获取ExampleService实例，下面例子会输出赵，钱，孙
        dump(ExampleService::make('赵', 13)->getName());
        dump(ExampleService::make('钱', 14)->getName());
        dump(ExampleService::instance()->getName());
    }
}

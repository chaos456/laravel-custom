<?php

namespace Tests\Feature;

use App\Services\HolidayApiService;
use Tests\TestCase;

class HolidayApiServiceTest extends TestCase
{
    public function testDayInfo()
    {
        $res = HolidayApiService::make()->dayInfo('20230520');

        dump($res);

        $this->assertIsArray($res);
    }
}

<?php

namespace App\Http\Controllers;

class TestController extends BaseController
{
    protected function validateRequest()
    {
    }
    public function __invoke()
    {
        $this->validateRequest();
        $this->run();
    }

    protected function run()
    {

    }
}

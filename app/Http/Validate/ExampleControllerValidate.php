<?php


namespace App\Http\Validate;

use App\Exceptions\CommonException;
use Illuminate\Http\Request;

class ExampleControllerValidate extends BaseValidate
{
    public function apiPre(Request $request)
    {
        $this->validate($request, [
            'a' => 'required|integer',
            'b' => 'required|integer'
        ]);

        $a = $request->integer('a');
        $b = $request->integer('b');
        if ($a + $b < 10) {
            throw new CommonException('a与b之和小于10');
        }
    }
}

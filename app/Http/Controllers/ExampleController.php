<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        $user = User::query()->customPaginate();
        $user->getCollection()->transform(function ($value) {
            return [
                'created_at' => $value['created_at']->format('Y-m-d')
            ];
        });

        return $this->responseSuccess($user);
    }
}

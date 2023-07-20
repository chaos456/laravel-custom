<?php

namespace App\Models;

use App\Support\Macros\BuildMacroIdeHelper;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use BuildMacroIdeHelper;

    protected $guarded = ['id'];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

<?php

namespace App\Models;

use App\Support\Traits\ModelMacroIdeHelper;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use ModelMacroIdeHelper;

    protected $guarded = ['id'];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}

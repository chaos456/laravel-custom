<?php

namespace App\Traits;

use App\Support\BuilderMacro;
use Illuminate\Database\Eloquent\Builder;


/**
 * @method static $this|Builder whereEqDate(string $field, string $date)
 * @method static $this|Builder whereToday(string $field)
 * @method static $this|Builder customPaginate(int $page = null, int $perPage = null)
 * @see BuilderMacro;
 */
trait ModelMacroIdeHelper
{

}

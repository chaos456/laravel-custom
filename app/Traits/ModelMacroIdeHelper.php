<?php

namespace App\Traits;

use App\Support\BuilderMacro;
use Illuminate\Database\Eloquent\Builder;


/**
 * @method Builder|static query()
 * @method Builder|static|$this whereEqDate(string $field, string $date)
 * @method Builder|static|$this whereToday(string $field)
 * @method Builder|static|$this whereYesterday(string $field)
 * @method \App\Support\CustomPaginator customPaginate(int $page = null, int $perPage = null)
 * @method \App\Support\SimplePaginator customSimplePaginate(int $page = null, int $perPage = null)
 * @see BuilderMacro;
 */
trait ModelMacroIdeHelper
{

}
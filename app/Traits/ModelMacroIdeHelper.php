<?php

namespace App\Traits;

use App\Support\BuilderMacro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;


/**
 * @method static Builder|static query() {@see \Illuminate\Database\Eloquent::query }
 * @method Builder|static|$this whereEqDate(string $field, string $date)
 * @method Builder|static|$this whereToday(string $field)
 * @method Builder|static|$this whereYesterday(string $field)
 * @method Builder|static|$this customPaginate(int $page = null, int $perPage = null)
 * @see BuilderMacro;
 */
trait ModelMacroIdeHelper
{

}

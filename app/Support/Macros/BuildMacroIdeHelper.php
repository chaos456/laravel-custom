<?php

namespace App\Support\Macros;

use Illuminate\Database\Eloquent\Builder;


/**
 * @method static Builder|static query()
 * @method Builder|static|$this whereEqDate(string $field, string $date)
 * @method Builder|static|$this whereToday(string $field)
 * @method Builder|static|$this whereYesterday(string $field)
 * @method Builder|static|$this whereLike(string $field, string $value, string $type = "left|right")
 * @method \App\Support\Pagination\CustomPaginator customPaginate(int $page = null, int $perPage = null)
 * @method \App\Support\Pagination\CustomSimplePaginator customSimplePaginate(int $page = null, int $perPage = null)
 * @method bool customExist()
 * @method bool insertOnDuplicate(array $attribute, array $onDuplicate)
 * @see BuilderMacro;
 */
trait BuildMacroIdeHelper
{

}

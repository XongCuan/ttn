<?php

namespace TCore\Base\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static TCore\Base\Traits\ResponseTrait responseAjax(bool $error = false, string $msg = null, $data = null, $statusCode = 200)
 * @method static TCore\Base\Traits\ResponseTrait responseBack(bool $error = false, string $msg = null, bool $withInput = false)
 * @method static TCore\Base\Traits\ResponseTrait toRoute(string $name, array|int|string $params = null, bool $error = false, string $msg = null)
 * @method static TCore\Base\Traits\ResponseTrait handleType(bool  $error = false, string $msg = null)
 *
 * @see TCore\Base\Traits\ResponseTrait
 */
class UtilitiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'utilities';
    }
}
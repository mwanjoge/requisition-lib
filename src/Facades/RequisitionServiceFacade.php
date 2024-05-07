<?php

namespace Nisimpo\Requisition\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class RequisitionService
 * @mixin \Nisimpo\Requisition\Services\RequisitionService
 * @package \Nisimpo\Requisition\Facades
 */
class RequisitionServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Nisimpo\Requisition\Services\RequisitionService::class;
    }
}

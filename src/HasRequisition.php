<?php

namespace Nisimpo\Requisition;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nisimpo\Requisition\Facades\RequisitionServiceFacade;

trait HasRequisition
{
    use Lineable;
    public function requisitions(): MorphMany
    {
        return $this->morphMany(\Nisimpo\Requisition\Models\Requisition::class,'requisable');
    }

    /**
     * @return MorphMany
     */
    public function lineItems(): MorphMany{
        return $this->morphMany(\Nisimpo\Requisition\Models\LineItem::class, 'lineable');
    }

    public function createRequisition(array $input): \Illuminate\Database\Eloquent\Model|Models\Requisition
    {
        return RequisitionServiceFacade::createRequisition($this, $input);
    }
    public function findAllRequisitions(){

    }

    public function getRequisition(int $id){

    }
}

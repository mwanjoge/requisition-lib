<?php

namespace Nisimpo\Requisition;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nisimpo\Requisition\Facades\RequisitionServiceFacade;
use Nisimpo\Requisition\Models\LineItem;
use Nisimpo\Requisition\Models\Requisition;

trait Lineable
{
    /**
     * @return MorphMany
     */
    public function lineItems(): MorphMany{
        return $this->morphMany(\Nisimpo\Requisition\Models\LineItem::class, 'lineable');
    }

    /**
     * Assigning single requisition item
     * @param Requisition $requisition
     * @param int $quantity
     * @param Model|null $item
     * @param string|null $itemName
     * @param float $unitAmount
     * @param float $subTotalAmount
     * @param string|null $currency
     * @param string|null $currencyPair
     * @param string|null $description
     * @param int|null $unitId
     * @param string|null $unit
     * @return LineItem|Model
     */
    public function createLineableRequisitionItem(
        Requisition $requisition, int $quantity, string $itemName = null, float $unitAmount = 0,
        float $subTotalAmount = 0, string $currency = null, string $currencyPair = null,
        string $description = null, int $unitId = null, string $unit = null): Model|LineItem
    {
        //dd($this);
        return RequisitionServiceFacade::createLineableRequisitionItem(
            $requisition,$this,$quantity,$itemName,$unitAmount, $subTotalAmount,
            $currency,$currencyPair,$description,$unitId,$unit);
    }

}

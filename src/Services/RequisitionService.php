<?php

namespace Nisimpo\Requisition\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Money\Money;
use Nisimpo\Requisition\Models\LineItem;
use Nisimpo\Requisition\Models\Requisition;
use Nisimpo\Requisition\Models\RequisitionItem;
use Nisimpo\Requisition\Repositories\RequisitionItemRepository;
use Nisimpo\Requisition\Repositories\RequisitionRepository;

class RequisitionService
{

    public function __construct(
        protected RequisitionRepository $requisitionRepository,
        protected RequisitionItemRepository $requisitionItemRepository,
        //protected GeneralLineItemRepository $generalLineItemRepository
    ){}

    /**
     * Creating new requisition
     * @param $model
     * @param array $input
     * @return Requisition|Model
     */
    public function createRequisition($model, array $input):Requisition|Model
    {
        $totalAmount = 0;
        if(isset($input['item_id']) || isset($input['item_name'])){
            $items = $input['item_id'] ?? $input['item_name'];
            $totalAmount = $this->calculateTotalRequisitionAmount($items,$input['unit_amount'],$input['quantity']);
        }
        return $this->requisitionRepository->createWithRelation($input, $model,'requisitions');
    }
    public function createBulkRequisitionItems(Requisition $requisition, array $items, array $unitAmounts, array $currencies, array $quantities, ?array $units): void
    {
        foreach ($items as $key => $value) {
            if (!empty($value)) {

                $unitAmount = new Money($unitAmounts[$key], $currencies[$key]);
                $quantity = $quantities[$key];
                $totalAmount = $unitAmount->multiply($quantity);

                //Prepare requisition item input
                $requisitionItemInputs = [
                    'name' => $value,
                    'requisition_id' => $requisition->id,
                ];

                $itemId = is_integer($value) ? $value : null;

                DB::transaction(function ()
                    use(
                        $requisitionItemInputs,
                        $requisition,
                        $value,
                        $key,
                        $itemId,
                        $unitAmounts,
                        $units,
                        $quantities,
                        $totalAmount,
                    )
                {
                    $requisitionItem = $this->requisitionItemRepository
                        ->createWithRelation($requisitionItemInputs, $requisition, 'goodRequisitionItems');

                    $generalLineItemsInput = $this->setGeneralLineItemsInputs($value, $quantities[$key], $totalAmount,
                            $unitAmounts[$key], $itemId, $units[$key]);

                    $this->createRequisitionGeneralItems($requisitionItem,$generalLineItemsInput,'generalLineItem');

                });
            }
        }
    }

    /**
     * Assigning single requisition item
     * @param Requisition $requisition
     * @param Model $item
     * @param int $quantity
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
    public function createLineableRequisitionItem(Requisition $requisition, Model $item, int $quantity, string $itemName = null, float $unitAmount = 0,
                                                  float       $subTotalAmount = 0, string $currency = null, string $currencyPair = null,
                                                  string      $description = null, int $unitId = null, string $unit = null): Model|LineItem
    {
        $lineItem = new LineItem([
            'quantity' => $quantity,
            'name' => $itemName ?? $item->name,
            'unit_amount' => $unitAmount,
            'sub_total_amount' => $subTotalAmount == 0 ? $this->calculateSubTotalAmount($quantity, $unitAmount) : $subTotalAmount,
            'currency' => $currency,
            'currency_pair' => $currencyPair,
            'description' => $description,
            'unit' => $unit,
            'unit_id' => $unitId,
        ]);

        if(!is_null($item)){
            $lineItem->requisition_id = $requisition->id;
            $item->lineItems()->save($lineItem);
        }
        else{
            $requisition->lineItems()->save($lineItem);
        }

        return $lineItem;
    }

    /**
     * Calculate the total requisition amount by sum all requisition item amount
     * @param array $items requisition items
     * @param array $unitAmounts list of items amounts
     * @param array $quantities list of quantities amounts
     * @return float | int return as float or integer of total amounts
     */
    public function calculateTotalRequisitionAmount(array $items, array $unitAmounts, array $quantities): float|int
    {
        $total = 0;
        foreach ($items as $key => $value) {
            if(!empty($unitAmounts[$key])){
                $total = $total + $unitAmounts[$key] * $quantities[$key];
            }
        }
        return $total;
    }

    /**
     * @param int $quantity
     * @param float $amount
     * @return float
     */
    public function calculateSubTotalAmount(int $quantity, float $amount): float
    {
        return $quantity * $amount;
    }

    private function setGeneralLineItemsInputs(string $itemName, int $quantity, Money $totalAmount, Money $unitAmount, ?int $itemId, ?int $unitId): array
    {
        return [
            'name' => $itemName,
            'quantity' => $quantity,
            'sub_total_amount' => $totalAmount,
            'unit_amount' => $unitAmount,
            'item_id' => $itemId,
            'unit_id' => $unitId
        ];
    }
}

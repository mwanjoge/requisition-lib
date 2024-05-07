<?php

namespace Nisimpo\Requisition\Repositories;

use Nisimpo\Requisition\Models\RequisitionItem;

/**
 * Class GoodRequisitionItemRepository
 * @package App\Repositories\Inventory
 * @version August 16, 2017, 8:40 pm UTC
 *
 * @method RequisitionItem findWithoutFail($id, $columns = ['*'])
 * @method RequisitionItem find($id, $columns = ['*'])
 * @method RequisitionItem first($columns = ['*'])
*/
class RequisitionItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected array $fieldSearchable = [
        'name',
        'quantity',
        'unit',
        'amount',
        'currency',
        'description'
    ];
    protected array $tablesJoinable;

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return RequisitionItem::class;
    }

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getTablesJoinable(): array
    {
        return $this->tablesJoinable;
    }
}

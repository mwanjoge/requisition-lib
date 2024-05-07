<?php

namespace Nisimpo\Requisition\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * @SWG\Definition(
 *      definition="GoodRequisitionItem",
 *      required={"name", "quantity", "unit", "amount", "currency", "currency_pair"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="quantity",
 *          description="quantity",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="unit",
 *          description="unit",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="amount",
 *          description="amount",
 *          type="number",
 *          format="float"
 *      ),
 *        @SWG\Property(
 *          property="unit_amount",
 *          description="unit_amount",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="currency",
 *          description="currency",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="description",
 *          description="description",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_by",
 *          description="created_by",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="updated_by",
 *          description="updated_by",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="good_requisition_id",
 *          description="good_requisition_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="item_id",
 *          description="item_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class RequisitionItem extends Model
{
    use SoftDeletes;

    public $table = 'requisition_items';


    protected array $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'created_by',
        'updated_by',
        'requisition_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'goods_requisition_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'name' => 'required|max:100|min:3',
    ];

    /**
     * @return BelongsTo
     **/
    public function requisition(): BelongsTo
    {
        return $this->belongsTo(Requisition::class);
    }

    /**
     * @return MorphOne
     **/
    public function generalLineItem(): MorphOne
    {
        return $this->morphOne(GeneralLineItem::class, 'lineable');
    }

    /**
     * Get the good requisition item's name
     *
     */
    public function getName()
    {
        return $this->generalLineItem->name;
    }

    /**
     * Get the goods requisition item's quantity.
     * @internal param $id
     */
    public function getQuantity()
    {
       // return $this->generalLineItem->quantity;
    }


    /**
     * Get the requisition item's unit.

     */
    public function getUnit()
    {
       // return $this->generalLineItem->itemUnit;
    }

    public function getCurrency()
    {
        return $this->goodRequisition->getCurrencyAttribute();
    }


    /**
     * Get the requisition  item unit amount, formatted with a thousand separator and currency.
     * @return string
     * @internal param $id
     */
    public function getFormattedUnitAmount(): string
    {
        $unitAmount = 0 . " " . $this->getCurrency()->getCode();
        if ($this->generalLineItem->exists()) {
            $unitAmount = $this->generalLineItem->getFormattedUnitAmount();
        }
        return $unitAmount;
    }

    /**
     * Get the requisition  total amount, formatted with a thousand separator and currency.
     * @return string
     * @internal param $id
     */
    public function getFormattedSubTotalAmount(): string
    {
        $subTotalAmount = 0 . " " . $this->getCurrency()->getCode();
        if ($this->generalLineItem->exists()) {
            $subTotalAmount = $this->generalLineItem->getFormattedSubTotalAmount();
        }
        return $subTotalAmount;
    }


}

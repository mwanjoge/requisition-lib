<?php

namespace Nisimpo\Requisition\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="GeneralLineItem",
 *      required={"name", "quantity", "unit_amount", "sub_total_amount", "currency"},
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
 *          property="unit_amount",
 *          description="unit_amount",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="sub_total_amount",
 *          description="sub_total_amount",
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
 *          property="item_id",
 *          description="item_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="unit_id",
 *          description="unit_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class LineItem extends Model
{
    use SoftDeletes;

    public $table = 'line_items';


    protected array $dates = ['deleted_at'];

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'quantity' => 'integer',
        'currency' => 'string',
        'description' => 'string',
        'item_id' => 'integer',
        'unit_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'name' => 'required|max:100|min:3',
        'quantity' => 'required',
        'unit_amount' => 'required',
        'sub_total_amount' => 'required',
        'currency' => 'required|max:3|min:3'
    ];

    public function itemUnit()
    {
       // return $this->belongsTo(ItemUnit::class,'unit_id');
    }

    /**
     * @return MorphTo
     **/
    public function lineable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the general line item subtotal amount, formatted with thousands separator and currency.
     * @return string
     * @internal param $id
     */
    public function getFormattedSubTotalAmount(): string
    {
        return number_format($this->attributes['sub_total_amount']) . ' ' . $this->attributes['currency'];
    }

    /**
     * Get the general item subtotal amount.
     * @return string
     * @internal param $id
     */
    public function getSubTotalAmount(): string
    {
        return  $this->attributes['sub_total_amount'].' '.$this->attributes['currency'];
    }


    /**
     * Get the general line item's unit amount.
     * @return string object
     * @internal param string $value
     */
    public function getUnitAmountAttribute(): string
    {
        return $this->attributes['unit_amount'].' '.$this->attributes['currency'];
    }
}

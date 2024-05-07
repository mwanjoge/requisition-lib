<?php /** @noinspection DuplicatedCode */

namespace Nisimpo\Requisition\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Requisition extends Model
{
    use SoftDeletes;

    public $table = 'requisitions';


    protected array $dates = ['deleted_at', 'date'];


    public $fillable = [
        'requested_by',
        'issued_at',
        'reference_no',
        'status',
        'total_amount',
        'currency',
        'currency_pair',
        'is_approved',
        'is_maintenance',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'requested_by' => 'integer',
        'issued_at' => 'datetime',
        'reference_no' => 'string',
        'status' => 'string',
        'currency' => 'string',
        'is_approved' => 'boolean',
        'is_maintenance' => 'boolean',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'currency' => 'required|max:3|min:3',
    ];

    public function requisable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return HasMany
     **/
    public function requisitionItems(): HasMany
    {
        return $this->hasMany(RequisitionItem::class);
    }

    /**
     * @return HasMany
     **/
    public function lineItems(): HasMany
    {
        return $this->hasMany(LineItem::class);
    }


    /**
     * @return MorphOne
     **/
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    public function onGoodRequisitionApproval($approval)
    {

        Log::info("goods requisition   approved: " . print_r(get_class_methods($approval->id), true));

    }

    /**
     * Get the purchase order  total amount, formatted with a thousand separator and currency.
     * @return string
     * @internal param $id
     */
    public function getFormattedTotalAmount(): string
    {
        return  number_format($this->attributes['total_amount']) .' '. $this->getCurrencyAttribute()->getCode();
    }

    /**
     * Get the requisition's total_amount.
     * @return string object
     * @internal param string $value
     */
    public function getTotalAmountAttribute(): string
    {
       /* return new Money( $this->attributes['total_amount'], $this->getCurrencyAttribute());*/

        $money = new Money($this->attributes['total_amount'], $this->getCurrencyAttribute());

        return json_encode($money);
    }

    /**
     *
     * Get the requisition's currency.
     * @return Currency object
     * @internal param string $value
     *
     */
//    public function getCurrencyAttribute(): Currency
//    {
//        return new Currency( $this->attributes['currency']);
//    }


    /**
     * Set the requisition's total_amount.
     *
     * @internal param string $value
     * @param Money $money
     */
//    public function setTotalAmountAttribute(Money $money)
//    {
//        $this->attributes['total_amount'] = $money->getAmount();
//        $this->setCurrencyAttribute($money->getCurrency());
//        if (!$money->getCurrency()->equals(new Currency(baseCurrencyCode()))) {
//            //todo add get or create and get to be persist
//            //todo fetch it  first from cache
//            $currencyPair = Session::get(baseCurrencyCode() . '/' . $money->getCurrency()->getCode());
//            if (is_null($currencyPair)) {
//                $currencyExchange = CurrencyExchange::where('counter_code', '=',
//                    $money->getCurrency()->getCode())->first();
//
//                $currencyPair = $currencyExchange->currency_pair;
//            }
//            $this->attributes['currency_pair'] = $currencyPair;
//
//        }
//    }


    /**
     * Set the requisition's currency.
     *
     * @param Currency $currency
     *
     */
//    public function setCurrencyAttribute(Currency $currency)
//    {
//        $this->attributes['currency'] = $currency->getCode();
//    }
}

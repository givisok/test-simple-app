<?php

namespace App\Models;

use App\Contracts\PayableOrder;
use App\Exceptions\OrderSaveStatusException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-write mixed                                                         $card_cvv
 * @property-write mixed                                                         $card_expire_month
 * @property-write mixed                                                         $card_expire_year
 * @property-write mixed                                                         $card_number
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 * @mixin \Eloquent
 * @property int                                                                 $id
 * @property string                                                              $user_name
 * @property string                                                              $user_email
 * @property string                                                              $address
 * @property int                                                                 $payment_status
 * @property string|null                                                         $deleted_at
 * @property \Carbon\Carbon|null                                                 $created_at
 * @property \Carbon\Carbon|null                                                 $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserName($value)
 */
class Order extends Model implements PayableOrder
{
    use SoftDeletes;

    protected $fillable = [
        'user_name',
        'user_email',
        'address',
        'token',
    ];

    protected $token = '';

    /**
     * Get full order price
     *
     * @return float
     */
    public function getPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $totalPrice += $product->pivot->fixed_price * $product->pivot->quantity;
        }

        return $totalPrice;
    }

    /**
     * @param int $status
     * @throws OrderSaveStatusException
     */
    public function setPaymentStatusOrFail(int $status): void
    {
        //Yes we can add check here...
        $this->payment_status = $status;

        if (!$this->save()) {
            throw new OrderSaveStatusException();
        }
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->user_email;
    }

    public function setTokenAttribute($token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get simple order description
     *
     * @return string
     */
    public function getDescription(): string
    {
        if ($this->id) {
            return "Order id:{$this->id}, created at {$this->created_at}";
        }

        return '';
    }

    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function addProduct(Product $product, int $quantity)
    {
        $this->products()->attach($product,
            ['order_id' => $this->id, 'quantity' => $quantity, 'fixed_price' => $product->price]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Product', 'notices')->withPivot(['quantity', 'fixed_price']);
    }
}

<?php
namespace YHShanto\ShebaCart;


use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_datas';
    protected $guarded = ['id'];
    protected $casts = [
        'options' => 'array',
        'config' => 'array',
    ];
    protected $hidden = ['cart_type', 'product_type', 'product_id', 'user_type', 'user_id', 'created_at', 'updated_at'];
    protected $with = ['product'];

    public function user()

    {

        return $this->morphTo();

    }

    public function product()

    {

        return $this->morphTo();

    }

    /**
     * @param $product CanBeACartItem|Model
     */
    public function setProductAttribute($product) {
        $this->attributes['product_type'] = get_class($product);
        $this->attributes['product_id'] = $product->id;
    }
}

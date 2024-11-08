<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_ORDER = [
        'pending' => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'preparing_goods' => 'Đang chuẩn bị hàng',
        'shipping' => 'Đang vận chuyển',
        'delivered' => 'Đã giao hàng',
        'canceled' => 'Đơn hàng đã bị hủy',
        'Refund successful' => 'đã hoàn tiền cho khách hàng',
        'Returned goods successfully' => 'đã nhận được hàng hoàn',
    ];

    const STATUS_ORDER_PENDING = 'pending';
    const STATUS_ORDER_CONFIRMED = 'confirmed';
    const STATUS_ORDER_PREPARING_GOODS = 'preparing_goods';
    const STATUS_ORDER_SHIPPING = 'shipping';
    const STATUS_ORDER_DELIVERED = 'delivered';
    const STATUS_ORDER_CANCELED = 'canceled';
    const STATUS_REFUND_SUCCESSFUL = 'Refund successful';
    const STATUS_RETURNED_GOODS_SUCCESSFUL = 'Returned goods successfully';

    const STATUS_ORDER_COMPLETED = 'completed'; 

    const STATUS_PAYMENT_MOMO = 'momo'; 

    const STATUS_PAYMENT_CASH = 'cash';
    const STATUS_PAYMENT = [
        'momo' => 'ví điện tử',
        'PayPal' => 'ví điện tử',
        'Pay upon receipt' => 'Thanh toán tiền mặt',
    ];
    const STATUS_PAYMENT_PAYPAL = 'PayPal';
    const STATUS_PAYMENT_PAY_UPON_RECEIPT = 'Pay upon receipt';

    protected $fillable =[
        'user_id',
        'address_id',
        'status_order',
        'status_payment',
        'total_price',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function address() {
        return $this->belongsTo(Address::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}

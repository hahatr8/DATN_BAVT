<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ORDER = [
        'pending' => 'Chờ xác nhận',
        'confirmed' => 'Đã xác nhận',
        'shipping' => 'Đang vận chuyển',
        'delivered' => 'Đã giao hàng',
        'completed' => 'Hoàn thành',

        'shop_cancelled' => 'Cửa hàng đã hủy đơn',

        'customer_cancelled' => 'Khách hàng đã hủy đơn',
        'cancellation_refund_completed' => 'Hoàn tiền cho đơn hủy',
        'canceled' => 'Đơn hàng đã bị hủy',

        'return_requested' => 'Khách hàng đã yêu cầu trả hàng',
        'return_approved' => 'Chấp nhận yêu cầu trả hàng',
        'return_rejected' => 'Từ chối yêu cầu trả hàng',
        'return_in_transit' => 'Hàng đã được trả về',
        'refund_successful' => 'Đã hoàn tiền cho khách hàng',
    ];

    const STATUS_ORDER_PENDING = 'pending';
    const STATUS_ORDER_CONFIRMED = 'confirmed';
    const STATUS_ORDER_SHIPPING = 'shipping';
    const STATUS_ORDER_DELIVERED = 'delivered';
    const STATUS_ORDER_COMPLETED = 'completed';


    const STATUS_ORDER_SHOP_CANCELLED = 'shop_cancelled';


    const STATUS_ORDER_CUSTOMER_CANCELLED = 'customer_cancelled';
    const STATUS_CANCELLATION_REFUND_COMPLETED = 'cancellation_refund_completed';
    const STATUS_ORDER_CANCELED = 'canceled';


    const STATUS_RETURN_REQUESTED = 'return_requested';
    const STATUS_RETURN_APPROVED = 'return_approved';
    const STATUS_RETURN_REJECTED = 'return_rejected';
    const STATUS_RETURN_IN_TRANSIT = 'return_in_transit';
    const STATUS_REFUND_SUCCESSFUL = 'refund_successful';


    const STATUS_PAYMENT_MOMO = 'momo';

    const STATUS_PAYMENT_CASH = 'cash';

    const STATUS_PAYMENT = [
        'momo' => 'Momo',
        'cash' => 'Tiền mặt',
    ];

    protected $fillable = [
        'user_id',
        'address_id',
        'status_order',
        'status_payment',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
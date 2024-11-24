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
        'preparing_goods' => 'Đang chuẩn bị hàng',
        'shipping' => 'Đang vận chuyển',
        'delivered' => 'Đã giao hàng',
        'completed' => 'Hoàn thành',

        'customer_cancelled' => 'Khách hàng đã hủy đơn hàng',
        'cancellation_refund_completed' => 'Hoàn tiền cho khách hàng đã hủy đơn',
        'canceled' => 'Đơn hàng đã bị hủy',

        'return_requested' => 'Khách hàng đã yêu cầu trả hàng',
        'return_approved' => 'Chấp nhận yêu cầu trả hàng',
        'return_rejected' => 'Từ chối yêu cầu trả hàng',
        'waiting_for_return' => 'Đang chờ khách hàng gửi trả hàng',
        'return_in_transit' => 'Hàng đang được trả về',
        'returned_goods_received' => 'Đã nhận được hàng hoàn',
        'refund_processing' => 'Đang xử lý hoàn tiền',
        'refund_successful' => 'Đã hoàn tiền cho khách hàng',
        'return_request_cancelled' => 'Yêu cầu trả hàng bị huỷ',
        'return_completed' => 'Đơn hàng đã bị trả về'
    ];


    const STATUS_ORDER_PENDING = 'pending';

    const STATUS_ORDER_CONFIRMED = 'confirmed';

    const STATUS_ORDER_PREPARING_GOODS = 'preparing_goods';

    const STATUS_ORDER_SHIPPING = 'shipping';

    const STATUS_ORDER_DELIVERED = 'delivered';

    const STATUS_ORDER_COMPLETED = 'completed';

    const STATUS_ORDER_CUSTOMER_CANCELLED = 'customer_cancelled';

    const STATUS_ORDER_CANCELED = 'canceled';

    const STATUS_CANCELLATION_REFUND_COMPLETED = 'cancellation_refund_completed';

    const STATUS_RETURN_REQUESTED = 'return_requested';

    const STATUS_RETURN_APPROVED = 'return_approved';

    const STATUS_RETURN_REJECTED = 'return_rejected';

    const STATUS_RETURN_IN_TRANSIT = 'return_in_transit';

    const STATUS_RETURNED_GOODS_RECEIVED = 'returned_goods_received';

    const STATUS_REFUND_PROCESSING = 'refund_processing';

    const STATUS_REFUND_SUCCESSFUL = 'refund_successful';

    const STATUS_WAITING_FOR_RETURN = 'waiting_for_return';

    const STATUS_RETURN_REQUEST_CANCELLED = 'return_request_cancelled';

    const STATUS_RETURN_COMPLETED = 'return_completed';



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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <style>
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cart-table th,
        .cart-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .cart-total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>Giỏ hàng của bạn</h1>

    @if ($cartItems->isEmpty())
        <p>Giỏ hàng của bạn đang trống.</p>
    @else
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandTotal = 0;
                @endphp

                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item->productSize->product->name }}</td>
                        <td>
                            <input type="number" class="quantity" data-id="{{ $item->id }}"
                                value="{{ $item->quantity }}" min="1" style="width: 50px;">
                        </td>
                        <td>{{ number_format($item->productSize->product->price, 0, ',', '.') }} VND</td>
                        <td class="total">
                            {{ number_format($item->productSize->product->price * $item->quantity, 0, ',', '.') }} VND
                        </td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>

                    @php
                        $grandTotal += $item->productSize->product->price * $item->quantity;
                    @endphp
                @endforeach

                <tr>
                    <td colspan="3" class="cart-total">Tổng cộng:</td>
                    <td colspan="2" class="cart-total" id="grandTotal">
                        {{ number_format($grandTotal, 0, ',', '.') }} VND
                    </td>
                </tr>
            </tbody>
        </table>
    @endif

    <form action="{{ route('cart.order') }}" method="POST">
        @csrf
        <button type="submit">Đặt hàng</button>
    </form>

</body>

<!-- Thêm JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Lắng nghe sự kiện thay đổi số lượng
    $(document).on('change', '.quantity', function() {
        var quantity = $(this).val();
        var cartItemId = $(this).data('id');
        var price = $(this).closest('tr').find('td:nth-child(3)').text().replace(' VND', '').replace(',', '');
        var totalCell = $(this).closest('tr').find('.total');

        // Cập nhật tổng tiền cho sản phẩm
        var total = price * quantity;
        totalCell.text(new Intl.NumberFormat('vi-VN').format(total) + ' VND');

        // Gửi AJAX để cập nhật số lượng
        $.ajax({
            url: '/cart/' + cartItemId, // Đảm bảo có route PUT
            method: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: quantity
            },
            success: function(response) {
                // Cập nhật lại tổng giỏ hàng từ response
                $('#grandTotal').text(response.grandTotal); // Cập nhật tổng giỏ hàng mới
            },
            error: function(xhr, status, error) {
                console.error('Lỗi:', error); // Hiển thị lỗi chi tiết
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            }
        });
    });
</script>


</html>

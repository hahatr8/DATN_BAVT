<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
</head>

<body>
    <h1>Danh sách sản phẩm</h1>

    @if ($products->isEmpty())
        <p>Không có sản phẩm nào để hiển thị.</p>
    @else
        <div class="product-list">
            @foreach ($products as $product)
                <div class="product-item">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description }}</p>
                    <p>Giá: {{ number_format($product->price, 0, ',', '.') }} VND</p>

                    <!-- Form thêm sản phẩm vào giỏ hàng -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf

                        <!-- Dropdown chọn size sản phẩm -->
                        <label for="product_size_{{ $product->id }}">Chọn size:</label>
                        <select name="product_size_id" id="product_size_{{ $product->id }}" required>
                            <option value="">-- Chọn size --</option>
                            @if ($product->productSizes && $product->productSizes->isNotEmpty())
                                @foreach ($product->productSizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->variant }} - {{ number_format($size->price, 0, ',', '.') }} VND</option>
                                @endforeach
                            @else
                                <option value="">Size không khả dụng</option>
                            @endif
                        </select>

                        <!-- Nhập số lượng -->
                        <label for="quantity_{{ $product->id }}">Số lượng:</label>
                        <input type="number" name="quantity" id="quantity_{{ $product->id }}" value="1" min="1" required>

                        <button type="submit">Thêm vào giỏ hàng</button>
                    </form>
                </div>
                <hr>
            @endforeach
        </div>
    @endif
</body>

</html>

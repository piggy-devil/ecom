<?php use App\Models\Product; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th colspan="2">Description</th>
            <th>Quantity/Update</th>
            <th>Unit Price</th>
            <th>Category/Product Discount</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_price = 0; ?>
        @foreach($userCartItems as $item)
        <?php
        $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
        ?>
        <tr>
            <td>
                <?php
                $product_image_path = 'images/admin_images/product_images/small/' . $item['product']['product_image'];
                ?>
                @if(!empty($item['product']['product_image']) && file_exists($product_image_path))
                <img width="60" src="{{ url('images/admin_images/product_images/small/'.$item['product']['product_image']) }}" alt="">
                @else
                <img width="60" src="{{ url('images/admin_images/product_images/small/no-image.png') }}" alt="">
                @endif
            </td>
            <td colspan="2">
                {{ $item['product']['product_name'] }} ({{ $item['product']['product_name'] }})<br />
                Color : {{ $item['product']['product_color'] }}<br />
                Size : {{ $item['size'] }}
            </td>
            <td>
                <div class="input-append">
                    <input class="span1" style="max-width:34px" value="{{ $item['quantity'] }}" size="16" type="text">
                    <button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{ $item['id'] }}"><i class="icon-minus"></i></button>
                    <button class="btn btnItemUpdate qtyPlus" type="button" data-cartid="{{ $item['id'] }}"><i class="icon-plus"></i></button>
                    <button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{ $item['id'] }}"><i class="icon-remove icon-white"></i></button>
                </div>
            </td>
            <td>Rs.{{ $attrPrice['product_price'] }}</td>
            <td>Rs.{{ $attrPrice['discount'] }}</td>
            <td>Rs.{{ $attrPrice['final_price'] * $item['quantity'] }}</td>
        </tr>
        <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']); ?>
        @endforeach

        <tr>
            <td colspan="6" style="text-align:right">Sub Total: </td>
            <td> Rs.{{ $total_price }}</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right">Voucher Discount: </td>
            <td> Rs.0.00</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (Rs.{{ $total_price }} - Rs.0 + Rs.0) =</strong></td>
            <td class="label label-important" style="display:block"> <strong> Rs.{{ $total_price }} </strong></td>
        </tr>
    </tbody>
</table>
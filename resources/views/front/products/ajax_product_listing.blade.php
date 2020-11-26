<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach($categoryProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a href="{{ url('product/'.$product['id']) }}">
                    <?php
                    $product_image_path = 'images/admin_images/product_images/small/' . $product['product_image'];
                    ?>
                    @if(!empty($product['product_image']) && file_exists($product_image_path))
                    <img style="width: 150px;" src="{{ url($product_image_path) }}" alt="">
                    @else
                    <img style="width: 150px;" src="{{ url('images/admin_images/product_images/small/no-image.png') }}" alt="">
                    @endif
                </a>
                <div class="caption">
                    <h5>{{ $product['product_name'] }}</h5>
                    <p>
                        {{ $product['brand']['name'] }}
                    </p>
                    <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{ $product['product_price'] }}</a></h4>
                    <p>
                        {{ $product['fabric'] }}
                    </p>
                    <p>
                        {{ $product['sleeve'] }}
                    </p>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <hr class="soft" />
</div>
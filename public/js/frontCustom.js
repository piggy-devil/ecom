$(document).ready(function(){
    // $("#sort").on('change', function(){
    //     this.form.submit();
    // });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#sort").on('change', function(){
        var sort = $(this).val();
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: {sleeve:sleeve, fabric:fabric, sort:sort, url:url},
            success:function(data){
                $('.filter_products').html(data);
            }
        })
    });

    $(".fabric").on('click', function(){
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: {sleeve:sleeve, fabric:fabric, sort:sort, url:url},
            success:function(data){
                $('.filter_products').html(data);
            }
        })
    });

    $(".sleeve").on('click', function(){
        var sleeve = get_filter('sleeve');
        var fabric = get_filter('fabric');
        var sort = $("#sort option:selected").val();
        var url = $("#url").val();
        $.ajax({
            url: url,
            method: "post",
            data: {sleeve:sleeve, fabric:fabric, sort:sort, url:url},
            success:function(data){
                $('.filter_products').html(data);
            }
        })
    });
    
    function get_filter(class_name) {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $("#getPrice").on('change', function(){
        var size = $(this).val();
        if(size == ""){
            alert("Please select Size");
            return false;
        }
        var product_id = $(this).attr("product-id");
        $.ajax({
            url:'/get-product-price',
            data:{size:size, product_id:product_id},
            type:'post',
            success:function(resp){
                $(".getAttrPrice").html("Rs. "+resp);
                if(resp['discount'] > 0){
                    $(".getAttrPrice").html("<del>Rs. "+resp['product_price']+"</del> Rs."+resp['final_price']);
                }else{
                    $(".getAttrPrice").html("Rs. "+resp['product_price']);
                }
            },
            error:function(){
                alert("Error");
            }
        }) 
    });

    // Update Cart Items
    $(document).on('click', '.btnItemUpdate', function(){
        if($(this).hasClass('qtyMinus')){
            // if qtyMinus button gets clicked by User
            var quantity = $(this).prev().val();
            if(quantity <= 1){
                alert("Item quantity must be 1 or greater!");
                return false;
            }else{
                new_qty = parseInt(quantity) - 1;
            }
        }
        if($(this).hasClass('qtyPlus')){
            // if qtyPlus button gets clicked by User
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity) + 1;
        }
        var cartid = $(this).attr('data_cartid');
        $.ajax({
            data:{"cartid":cartid, "qty": new_qty},
            url:'/update-cart-item-qty',
            type:'post',
            success:function(resp){
                $("#AppendCartItems").html(resp.view);
            }, error:function(){
                alert("Error");
            }
        })
    });
});
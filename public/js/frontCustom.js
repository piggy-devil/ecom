$(document).ready(function(){
    // $("#sort").on('change', function(){
    //     this.form.submit();
    // });

    $("#sort").on('change', function(){
        var sort = $(this).val();
        var fabric = get_filter('fabric');
        var sleeve = get_filter('sleeve');
        var url = $("#url").val();
        // alert(sort);
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
});
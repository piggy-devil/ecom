$(document).ready(function() {
    // Check Admin Password is correct or not
    $("#current_pwd").keyup(function(){
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            type:'post',
            url: '/admin/check-current-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp == "false"){
                    $("#chkCurrentPwd").html("<font color=red>Current Password is incorrect</font>");
                }else if(resp=="true"){
                    $("#chkCurrentPwd").html("<font color=green>Current Password is correct</font>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    // Update Sections Status
    $(".updateSectionStatus").click(function() {
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajax({
           type:'post',
           url:'/admin/update-section-status',
           data:{status:status, section_id:section_id},
           success:function(resp){
            if(resp['status']==0){
                $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Inactive</a>"); 
               }else if(resp['status']==1){
                $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>Active</a>"); 
            }
           },error:function(){
               alert('Error');
           }
        });
    });

    // Update Category Status
    $(".updateCategoryStatus").click(function() {
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
           type:'post',
           url:'/admin/update-category-status',
           data:{status:status, category_id:category_id},
           success:function(resp){
            if(resp['status']==0){
                $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Inactive</a>"); 
               }else if(resp['status']==1){
                $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>Active</a>"); 
            }
           },error:function(){
               alert('Error');
           }
        });
    });

    // Append Categories Level
    $("#section_id").change(function(){
        var section_id = $(this).val();
        $.ajax({
            type:'post',
            url:'/admin/append-categories-level',
            data:{section_id:section_id},
            success:function(resp){
                $("#appendCategoriesLevel").html(resp);
            },error:function(){
                alert('Error');
            }
        })
    });
    
    // Update Product Status
    $(".updateProductStatus").click(function() {
        var status = $(this).text();
        var product_id = $(this).attr("product_id");
        $.ajax({
           type:'post',
           url:'/admin/update-product-status',
           data:{status:status, product_id:product_id},
           success:function(resp){
            if(resp['status']==0){
                $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Inactive</a>"); 
               }else if(resp['status']==1){
                $("#product-"+product_id).html("<a class='updateProductStatus' href='javascript:void(0)'>Active</a>"); 
            }
           },error:function(){
               alert('Error');
           }
        });
    });
    
    // Update Attribute Status
    $(".updateAttributeStatus").click(function() {
        var status = $(this).text();
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
           type:'post',
           url:'/admin/update-attribute-status',
           data:{status:status, attribute_id:attribute_id},
           success:function(resp){
            if(resp['status']==0){
                $("#attribute-"+attribute_id).html("Inactive"); 
               }else if(resp['status']==1){
                $("#attribute-"+attribute_id).html("Active"); 
            }
           },error:function(){
               alert('Error');
           }
        });
    });

    // Update Image Status
    $(".updateImageStatus").click(function() {
        var status = $(this).text();
        var image_id = $(this).attr("image_id");
        $.ajax({
           type:'post',
           url:'/admin/update-image-status',
           data:{status:status, image_id:image_id},
           success:function(resp){
            if(resp['status']==0){
                $("#image-"+image_id).html("Inactive"); 
               }else if(resp['status']==1){
                $("#image-"+image_id).html("Active"); 
            }
           },error:function(){
               alert('Error');
           }
        });
    });

    // Update Brand Status
    $(document).on("click", ".updateBrandStatus", function(){
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        $.ajax({
           type:'post',
           url:'/admin/update-brand-status',
           data:{status:status, brand_id:brand_id},
           success:function(resp){
            if(resp['status']==0){
                $("#brand-"+brand_id).html("<i title='Inactive' class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"); 
               }else if(resp['status']==1){
                $("#brand-"+brand_id).html("<i title='Active' class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"); 
            }
           },error:function(){
               alert('Error');
           }
        });
    });

    // Update Banner Status
    $(document).on("click", ".updateBannerStatus", function(){
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        $.ajax({
           type:'post',
           url:'/admin/update-banner-status',
           data:{status:status, banner_id:banner_id},
           success:function(resp){
            if(resp['status']==0){
                $("#banner-"+banner_id).html("<i title='Inactive' class='fas fa-toggle-off' aria-hidden='true' status='Inactive'></i>"); 
               }else if(resp['status']==1){
                $("#banner-"+banner_id).html("<i title='Active' class='fas fa-toggle-on' aria-hidden='true' status='Active'></i>"); 
            }
           },error:function(){
               alert('Error');
           }
        });
    });

    // Confirm Deletion with SweetAlert
    $(".confirmDelete").click(function() {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.isConfirmed) {
                // Swal.fire("Deleted!", "Your file has been deleted.", "success");
                window.location.href="/admin/delete-"+record+"/"+recordid;
            }
        });
        return false;
    });

    // Products Attributes Add/Remove Script
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div style="margin-top:10px;"><input type="text" name="size[]" placeholder="Size" style="width: 100px; value="" required/>&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 100px; value="" required/>&nbsp;<input type="number" name="price[]" placeholder="Price" style="width: 100px; value="" required/>&nbsp;<input type="number" name="stock[]" placeholder="Stock" style="width: 100px; value="" required/><a href="javascript:void(0);" class="remove_button">Delete</a></div>'; //New input field html 
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });

});
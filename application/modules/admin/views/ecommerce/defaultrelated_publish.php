<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="<?= base_url('assets/select2/dist/css/select2.min.css') ?>">
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Update Category Related product</h1>
<hr>
<?php
if (validation_errors()) 
{
 ?>
    <hr>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
 <?php
}
if ($this->session->flashdata('result_publish')) 
{ ?>
    <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
    <hr>     
 <?php
}
?>
<form method="post" id="relatedProduct" enctype="multipart/form-data">
    <div class="form-group">
        <label>Category</label>
        <select class="form-control for-shop" name="main_category" id="Cat_select" required>
            <option value="" disable="" selected>*Select Category*</option>
            <option value="7">Furniture</option>
            <option value="15">Lighting</option>
            <option value="51">Fine Art</option>
        </select>
    </div>
    <div class="form-group for-shop">
        <label>Products</label><br>
        <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Click & Select Only 4 Shop Products*</p></b>
        <select multiple class="form-control" name="selectedProducts[]" id="selectedProductsOLD" required>
            <?php echo getSubCatGroupProductsDropdownNewFine();?>
        </select>
        <?php
        if(isset($errorSelected)){
            echo $errorSelected;
        }
        ?>
    </div> 
    <script src="<?= base_url('assets/select2/dist/js/select2.min.js') ?>" type='text/javascript'></script>
    <script>
        $(document).ready(function(){ 
            var base_url = '<?= base_url(); ?>'
            
            $("#Cat_select").change(function () {
                if ($('#Cat_select').val() != "") {
                    $.ajax({
                        url: base_url + "admin/ecommerce/RelatedProducts/getSubCategory/",
                        type: 'POST',
                        cache: false,
                        data: {
                            'main_category': $('#Cat_select').val()
                        },
                        success: function (data) {
                            if(data){
                                $("#subCat_select").html(data);
                                $("#selectedProducts").html('<option value="">--Select an Option--</option>');
                            }
                        }
                    });
                }
            });

            $("#subCat_select").change(function () {
        
                if ($('#subCat_select').val() != "") 
                {
                    $.ajax({
                        url: base_url + "admin/ecommerce/RelatedProducts/getProductOnCategory",
                        type: 'POST',
                        cache: false,
                        data: {
                            'sub_category': $('#subCat_select').val(),
                            'main_category': $('#Cat_select').val()

                        },
                        success: function(data) 
                        {
                            if(data)
                            {
                                $("#selectedProducts").html(data);
                            }
                        } 
                    });
                }
                
            });   
            $("#selectedProductsOLD").select2();
        });   
    </script>
    <input type="submit" name="submit" id="relatedFormSubmit" class="btn btn-lg btn-default btn-primary" value="Publish">
    <?php if ($this->uri->segment(3) !== null) 
    { ?>
        <a href="<?= base_url('admin/ecommerce/DefaultRelatedProducts') ?>" class="btn btn-lg btn-default">Cancel</a>
     <?php 
    } ?>
</form>

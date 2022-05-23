<link rel="stylesheet" href="<?= base_url('assets/select2/dist/css/select2.min.css') ?>">
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Edit fineart</h1>
<hr>
<?php
$timeNow = time();
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_publish')) {
    ?>
    <hr>
    <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
    <hr>
    <?php
}
?>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : $timeNow ?>" name="folder">
    


        <div class="" >
           
            <div class="form-group"> 
                <label>Title</label>
                <input type="text" name="title" value="<?php echo $fineart['title'];?>" class="form-control">
            </div>
            <?php if ($designers) { ?>
        <div class="form-group for-shop" id="designer_option">
            <label>Select Artist</label><br />
            <select class="selectpicker" name="designer_id">
                <?php foreach ($designers as $design) { ?>
                    <option <?= isset($fineart['designer_id']) && $fineart['designer_id'] == $design['id'] ? 'selected' : '' ?> value="<?= $design['id'] ?>"><?= $design['title'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
            <div class="form-group"> 
                <label>Art Type</label>
                <input type="text" name="type" value="<?php echo $fineart['type'];?>" class="form-control">
            </div>
            <div class="form-group"> 
                <label>Art Size</label>
                <input type="text" name="size" value="<?php echo $fineart['size'];?>" class="form-control">
            </div>
             
            <div class="form-group"> 
                <label>Art Customer Info</label>
                <input type="text" name="stock_status" value="<?php echo $fineart['stock_status'];?>" class="form-control">
            </div>
             <!--<div class="form-group"> 
                <label>Artist Info</label>
                <textarea name="artist_information"  class="form-control" rows="10"><?php echo $fineart['artist_information'];?></textarea>
                <script>
                    CKEDITOR.replace('artist_information');
                    CKEDITOR.config.entities = false;
                </script>
            </div>-->

           
            
           
        </div>
        
    <div class="form-group bordered-group">
        <?php
        if (isset($fineart['image']) && $fineart['image'] != null) {
            $image = 'attachments/fineart_images/' . htmlspecialchars($fineart['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Fineart image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($fineart['image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= htmlspecialchars($fineart['image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Cover Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    
     <div class="form-group bordered-group">
        <?php
        if (isset($fineart['artist_image']) && $fineart['artist_image'] != null) {
            $image = 'attachments/fineart_images/artists/' . htmlspecialchars($fineart['artist_image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Fineart image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_artist_image" value="<?= htmlspecialchars($fineart['artist_image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="artist_image" value="<?= htmlspecialchars($fineart['artist_image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Artist Image</label>
        <input type="file" id="userfile1" name="userfile1">
    </div>


<!-- Related second option start -->

<input type="hidden" name="main_category" value='51'/>
<input type="hidden" name="sub_category" value='51'/>
<div class="form-group for-customerRelated" id="relatedProductSection">
<label><h5>LINK PRODUCTS FOR CUSTOMERS ALSO VIEW SECTION</h5></label><br>
<?php  if ($RelatedCustomerProducts) { ?>
    <div class="report-repeater">
        <div data-repeater-list="relatedProductArr">
            <?php foreach($RelatedCustomerProducts as $data) { ?>
            <div class="repeater-row"  data-repeater-item>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group for-shop">
                            <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Click & Select Only 1 Shop Products*</p></b>
                            <select class="form-control selectedProductsOLD" name="selectedProductsnew" id="selectedProductsOLD" placeholder="Choose Related Product">
                                   <?php echo getAllProductsDropdown($data);?>
                            </select>
                            <?php
                            if(isset($errorSelected)){
                                echo $errorSelected;
                            }
                            ?>
                        </div> 
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Enter Position of Product*</p></b>
                            <input class="form-control" name="Related_position" value="<?php echo $data['position']; ?>" id="Related_position" placeholder="Position">
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                <button type="button" name="delete" id="dltCustomerRelatedProduct" class="btn btn-danger">Delete All Related Products</button>
            </div> 
        </div>  
    </div>
    <?php } else {?>
    <div class="report-repeater">
        <div data-repeater-list="relatedProductArr">
            <div class="repeater-row"  data-repeater-item>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group for-shop">
                            <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Click & Select Only 1 Shop Products*</p></b>
                            <select class="form-control selectedProductsOLD" name="selectedProductsnew" id="selectedProductsOLD" placeholder="Choose Related Product">
                                
                                <?php echo getAllProductsDropdown();?>
                            </select>
                            <?php
                            if(isset($errorSelected)){
                                echo $errorSelected;
                            }
                            ?>
                        </div> 
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Enter Position of Product*</p></b>
                            <input class="form-control" name="Related_position" id="Related_position" placeholder="Position">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">

                            <button data-repeater-delete type="button" id="dlt_related_btn" class="btn btn-danger" style="margin-top: 20px;" >Delete</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <button data-repeater-create type="button" id="add_related_btn" class="btn btn-success" >Add Related Product</button>
    </div>
    <p id="warningRelatedProduct"></p>                         
    <?php } ?>
</div>


<!-- Related second option end -->
    
     <div class="form-group"> 
        <label>Position</label>
        <input type="text" name="position" value="<?php echo $fineart['position'];?>" class="form-control">
    </div>
      
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish1">Update</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/finearts') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>

<?php $Pid = $this->uri->segment(5); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="<?= base_url('assets/select2/dist/js/select2.min.js') ?>" type='text/javascript'></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://dev.hangarbot.com/resource/js/jquery.repeater.js"></script>
    <script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>
<script>

    var base_url = '<?= base_url(); ?>';
        function getSubCategories(){
            $.ajax({
                url: base_url + "admin/ecommerce/Fineart/getSubCategory",
                type: 'POST',
                cache: false,
                data: {
                    'main_category': 7,
                    'sub_category' : 51
                },
                success: function (data) {

                    if(data){
                        $("#subCat_select").html(data);       
                    }
                }
            });
        }

        $(".selectedProductsOLD").select2();

</script>
<script>

    $(document).ready(function(){
    var productId = <?= $Pid; ?>;
    if(productId > 0){
    //load subcategories 
        getSubCategories();
    }
    });

    if($('.report-repeater').length)
        {
            var  reportRepeater = $('.report-repeater').repeater({
                defaultValues: {
                    'textarea-input': 'foo',
                    'text-input': 'bar',
                },
                show: function () {
                    $(this).slideDown();
                  $('#relatedProductSection .select2-container').remove();
                    $('select').select2({
                       width: '100%',
                        placeholder: "Choose Related Product",
                        allowClear: true
                    });
                },
                hide: function (deleteElement) {
                    if(confirm('Are you sure you want to delete this?')) {
                        $(this).slideUp(deleteElement);
                    }
                }

            });
        }

        $(document).on('click', '#dltCustomerRelatedProduct', function(){  
                if (confirm('Are You Sure?')){   
                    $.ajax({
                        url: `<?php echo base_url();?>admin/ecommerce/Fineart/deleteCustomerRelatedProduct/`,
                        type: 'post',
                        data: {
                            'product_id' : <?= $Pid ?>
                        },
                        success: function(data) {
                            console.log(data);
                        if(data==false){
                            window.location.reload();

                            $("#relatedProductSection").css("display: none;");
                            $("#relatedProductSection").hide();
                            
                        }
                        else{
                            alert('Delete Unsuccessfull');
                            }
                        }            
                    });
                }
            }); 

            

         // Roll over Images Reapeter

         var i=1;  
            $('#add_related_btn').click(function(){  
                i++;    
                console.log(i);             
                if(i == 4 ) { 
                    $('#warningRelatedProduct').html('<div class ="alert-relatedProduct" style="display: inline-flex; margin-top: 10px;"><p style="color: #d9534f;border-color: #d43f3a;text-transform: uppercase;margin-left: 5px;">Notification:</p><span style="margin-left: 5px;">You have Only add 4 Related products</span></div><br>');             
                    $('#add_related_btn').hide();
                }        
            }); 
            $('#dlt_related_btn').click(function(){     
                  $('#add_related_btn').show();      
            }); 
        
        // End
        
</script>

<style>
    .select2-container--default .select2-selection--single {
        padding-top: 3px !important;
        height: 34px !important;
    }
    #brandOption .select2-container{
        display: none;
    }
    #metCategory .select2-container{
        display: none;
    }
    #designer_option .select2-container{
        display: none;
    }
    
    </style>

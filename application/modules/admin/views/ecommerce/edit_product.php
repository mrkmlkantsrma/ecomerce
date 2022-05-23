
1<style>
    .deleteOuter {display: flex;gap:10px;}  
    .deleteOuter .jqDeleteImage i {color: #fff;font-size: 12px;}
    .jqDeleteImage {position: absolute;right: -3px;top: -6px;background: #000;font-size: 21px;border-radius: 50%;width: 16px;height: 16px;display: flex;align-items: center;justify-content: center;}
    .jqImageContainer {position: relative;}
    .delete-record {margin-bottom: 15px;}
    .device_row { margin-bottom: 15px; }
</style>
<link rel="stylesheet" href="<?= base_url('assets/select2/dist/css/select2.min.css') ?>"><script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Add product</h1>
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
    if ($this->session->flashdata('message'))
    {
        ?>
        <hr>
            <div class="alert alert-danger"><?= $this->session->flashdata('message') ?></div>
        <hr>     
        <?php
    }
?>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : $timeNow ?>" name="folder">
    <div class="form-group available-translations">
        <b>Languages</b>
        <?php foreach ($languages as $language) { ?>
            <button type="button" data-locale-change="<?= $language->abbr ?>" class="btn btn-default locale-change text-uppercase <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>">
                <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">
                <?= $language->abbr ?>
            </button>
        <?php } ?>
    </div>
    <div class="form-group"> 
        <label>Product Name</label>
        <input type="text" name="title" value="<?php echo set_value('title');?>" class="form-control">
    </div>
    
    
        <div class="form-group"> 
        <label>Product Info</label>
        <textarea name="designer_information"  class="form-control" rows="10"></textarea>
        <script>
            CKEDITOR.replace('designer_information');
            CKEDITOR.config.entities = false;
        </script>
    </div>
    <div class="form-group for-shop">
                <label>Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['price']) ? $trans_load[$language->abbr]['price'] : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>Old Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="old_price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['old_price']) ? $trans_load[$language->abbr]['old_price'] : '' ?>" class="form-control">
            </div>

    <?php
    $i = 0;
    foreach ($languages as $language) {
        ?>
        <div class="locale-container locale-container-<?= $language->abbr ?>" <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'style="display:block;"' : '' ?>>
            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
            <div class="form-group"> 
                <label>Title (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="title[]" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="description<?= $i ?>">Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <textarea name="description[]" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
                <script>
                    CKEDITOR.replace('description<?= $i ?>');
                    CKEDITOR.config.entities = false;
                </script>
            </div>
            <div class="form-group for-shop">
                <label>Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['price']) ? $trans_load[$language->abbr]['price'] : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>Old Price (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                <input type="text" name="old_price[]" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['old_price']) ? $trans_load[$language->abbr]['old_price'] : '' ?>" class="form-control">
            </div>
        </div>
        <?php
        $i++;
    }
    ?>

<div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/shop_images/' . htmlspecialchars($_POST['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current Thumbnail image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($_POST['image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= htmlspecialchars($_POST['image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Product Thumbnail Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>

    <?php if(!empty($productImages)){ ?>
    <div class="table-responsive">  
        <table class="table table-bordered"> 
            <tr>
                <td class="deleteOuter">
                    <?php if( isset( $productImages)  ){
                        foreach( $productImages as $img ){  ?>
                        <div class="jqImageContainer">
                            <img src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $img->image_name ?>" width="100" />
                            <a class="jqDeleteImage" href="javascript:void(0)" data-imageId="<?php echo $img->id?>" data-galleryType="Furniture"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    <?php }
                    } ?>
                </td>
                <td>
                    <a href="javascript:void(0);" class="btn btn-success more-info" data-toggle="modal" data-target="#modalPreviewMoreInfo" style="margin-top:10%;">Re-Order Images <i class="fa fa-info-circle" aria-hidden="true"></i></a>
                </td>
            </tr>  
        </table>  
    </div>

    <!-- Modal for Re Arrange images in orders -->
    <div class="modal fade" id="modalPreviewMoreInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Re-Order Images</h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table more-info-purchase">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <div style="word-break: break-all;">
                                            <div>
                                            <?php if(isset($productImages))
                                                { ?>
                                                    <ul id="sortable">
                                                        <?php foreach($productImages as $img) 
                                                        {  ?>
                                                            <div class="arrange-images">
                                                                <img class="reorderImg" data-row_id="<?php echo $img->id?>" data-gallery_type ="Lighting" src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $img->image_name ?>" width="150"/>
                                                            </div>                                                            
                                                            <?php 
                                                        } ?>
                                                    </ul>
                                                    <?php 
                                                } ?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <hr>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="arrangedImg" class="btn btn-success" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>   

    <div class="form-group">
        <label> Add Roll Over Images </label>
        <div class="table-responsive">
            <table class="table table-bordered" id="dynamic_field_img">
                <tr>  
                    <td> Image 1 <input type="file" name="gallery_image[]"  class="form-control name_list" /></td>  
                    <td><button type="button" name="add" id="add_image" class="btn btn-success">Add More Image</button></td>  
                </tr>  
            </table>
            <p id="warningRollerMsg"></p>                         
        </div>              
    </div> 

    <div class="form-group for-shop">
            <label>Quantity</label>
            <input type="text" placeholder="number" name="quantity" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" class="form-control" id="quantity">
        </div>
        <!-- <div class="form-group for-shop">
            <label>Position/order</label>
            <input type="text" placeholder="Position number" name="position" value="<?//= isset($_POST['position']) ? htmlspecialchars($_POST['position']) : '' ?>" class="form-control">
        </div> -->
        <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">Publish</button>
        <!-- btn-lg btn-default btn-publish -->
        <?php if ($this->uri->segment(3) !== null) { ?>
            <a href="<?= base_url('admin/furniture_products') ?>" class="btn btn-lg btn-default">Cancel</a>
        <?php } ?>
    </form>

    <!-- Modal Upload More Images -->
    <div class="modal fade" id="modalMoreImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload more images</h4>
                </div>
                <div class="modal-body">
                    <form id="uploadImagesForm">
                        <input type="hidden" value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : $timeNow ?>" name="folder">
                        <label for="others">Select images</label>
                        <input type="file" name="others[]" id="others" multiple />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default finish-upload">
                        <span class="finish-text">Finish</span>
                        <img src="<?= base_url('assets/imgs/load.gif') ?>" class="loadUploadOthers" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/select2/dist/js/select2.min.js') ?>" type='text/javascript'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://dev.hangarbot.com/resource/js/jquery.repeater.js"></script>
    <script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>

    <script>

    $(document).ready(function(){
   
            // Roll Images Drag Feature
                $( function() {
                    $( "#sortable" ).sortable();
                } );            
            // End
            
            // Roll Images Reordering

                $(document).on('click', '#arrangedImg', function(){  
                    
                    var rowID = [];

                    $('.reorderImg').each(function(){
                        rowID.push( $(this).attr('data-row_id') );
                    })

                    $.ajax({
                        url: `<?php echo base_url();?>ajax/reArrangeGalleryImage`,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            row_id : rowID,
                            gallery_type : "Furniture"
                        },
                        success: function(response) {
                            jsonResposne = JSON.parse(response);                
                        }            
                    });
                });

            // End 
            
            var i=1;  
            $('#add_image').click(function(){  
                i++;                 
                if(i >= 7) { 
                    $('#warningRollerMsg').html('<div class ="alert-rollover" style="display: inline-flex; margin-top: 10px;"><p style="color: #d9534f;border-color: #d43f3a;text-transform: uppercase;margin-left: 5px;">Notification:</p><span style="margin-left: 5px;">You have selected all Roll Over Images</span></div>');             
                }else{
                    $('#dynamic_field_img').append('<tr id="row1'+i+'"><td> Image '+i+' <input type="file" name="gallery_image[]"  class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove_img">X</button></td></tr>');             
                }         
            }); 

            // End
            
            $(document).on('click', '.btn_remove_img', function(){  
                var button_id = $(this).attr("id");   
                $('#row1'+button_id+'').remove();  
            }); 

            $(document).on('click', '.jqDeleteImage', function(){  
                var imageId = $(this).attr("data-imageId");   
                var obj = $(this);
                $.ajax({
                    url: `<?php echo base_url();?>ajax/deleteProductGalleryImage`,
                    type: 'post',
                    data: {
                        imageId:imageId,
                        galleryType: 'Furniture'
                    },
                    success: function(response) {
                        jsonResposne = JSON.parse(response);
                        if( jsonResposne.status === true ){
                            obj.parent().remove();
                        }
                    }            
                });
            });  

            $(document).on('click', '.deleteCat', function(){  
                if (confirm('Are You Sure?')){
                    var productId = $(this).attr("productId");   
                    var mCatId    = $(this).attr("mCatId"); 
                    $.ajax({
                        url: `<?php echo base_url();?>admin/ecommerce/Furniture_Publish/deleteMCat/`,
                        type: 'post',
                        data: {
                            productId:productId,
                            mCatId:mCatId
                        },
                        success: function(data) {
                        if(data==false){
                            window.location.reload();
                        }
                        else{
                            alert('Delete Unsuccessfull');
                        }
                        }            
                    });
                }
            });  

            $(document).on('click', '#dltRelatedProduct', function(){  
                if (confirm('Are You Sure?')){   
                    $.ajax({
                        url: `<?php echo base_url();?>admin/ecommerce/Furniture_Publish/deleteRelatedProduct/`,
                        type: 'post',
                        data: {
                            'product_id' : <?= $id ?>
                        },
                        success: function(data) {
                            console.log(data);
                        if(data==false){
                            alert('Delete successfully');

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
                        placeholder: "Choose Option",
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
                        url: `<?php echo base_url();?>admin/ecommerce/Furniture_Publish/deleteCustomerRelatedProduct/`,
                        type: 'post',
                        data: {
                            'product_id' : <?= $id ?>
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


        <div class="" >
           
            <div class="form-group"> 
                <label>Product Name</label>
                <input type="text" name="title" value="<?php echo set_value('title');?>" class="form-control">
            </div>
           
            
             <div class="form-group"> 
                <label>Product Info</label>
                <textarea name="designer_information"  class="form-control" rows="10"></textarea>
                <script>
                    CKEDITOR.replace('designer_information');
                    CKEDITOR.config.entities = false;
                </script>
            </div>

           
            
           
        </div>
        
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/designer_images/' . htmlspecialchars($_POST['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Product image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($_POST['image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= htmlspecialchars($_POST['image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Product Main Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    
     <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image1']) && $_POST['image1'] != null) {
            $image1 = 'attachments/designer_images/' . htmlspecialchars($_POST['image1']);
            if (!file_exists($image)) {
                $image1 = 'attachments/no-image.png';
            }
            ?>
            <p>Product image:</p>
            <div>
                <img src="<?= base_url($image1) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image1" value="<?= htmlspecialchars($_POST['image1']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image1" value="<?= htmlspecialchars($_POST['image1']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Product Image</label>
        <input type="file" id="userfile1" name="userfile1">
    </div>
    
    
    
     <div class="form-group"> 
                <label>Position</label>
                 <input type="text" name="position" value="<?php echo set_value('position');?>" class="form-control">

            </div>
    
    
    
    
       
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish1">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>

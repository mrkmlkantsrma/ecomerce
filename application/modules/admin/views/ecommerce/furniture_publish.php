<style>
    .deleteOuter {display: flex;gap:10px;}  
    .deleteOuter .jqDeleteImage i {color: #fff;font-size: 12px;}
    .jqDeleteImage {position: absolute;right: -3px;top: -6px;background: #000;font-size: 21px;border-radius: 50%;width: 16px;height: 16px;display: flex;align-items: center;justify-content: center;}
    .jqImageContainer {position: relative;}
    .delete-record {margin-bottom: 15px;}
    .device_row { margin-bottom: 15px; }
</style>
<link rel="stylesheet" href="<?= base_url('assets/select2/dist/css/select2.min.css') ?>">
<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Publish furniture product</h1>
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
    <input type="hidden" name="Product_type" value='FURNITURE'/>

    <div class="form-group available-translations">
        <b>Languages</b>
        <?php foreach ($languages as $language) { ?>
            <button type="button" data-locale-change="<?= $language->abbr ?>" class="btn btn-default locale-change text-uppercase <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'active' : '' ?>">
                <img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">
                <?= $language->abbr ?>
            </button>
        <?php } ?>
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
            <?php if ($designers) { ?>
        <div class="form-group for-shop" id="designer_option">
            <label>Select Designer</label><br />
            <select class="selectpicker" name="designer_id">
                <?php foreach ($designers as $design) { ?>
                    <option <?= isset($_POST['designer_id']) && $_POST['designer_id'] == $design['id'] ? 'selected' : '' ?> value="<?= $design['id'] ?>"><?= $design['title'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
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


<!-- MULTIPLE SHOP CATEGORIES SELECT -->
<?php 
// $Pid = $this->uri->segment(3);
// if($Pid = $id)
// {  
    ?>

<div class="form-group for-customerRelated" id="multiCategoriesSection">
    <label><h5>SELECT MULTIPLE SHOP CATEGORIES FOR THIS PRODUCT</h5></label><br>
    <?php  if ($MultiSelectedCategories) 
        { ?>
            <div class="report-repeater">
                <div data-repeater-list="multiCategoriesArr">
                    <?php foreach($MultiSelectedCategories as $data) {?>
                    <div class="repeater-row"  data-repeater-item>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group for-shop">
                                    <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Click & Select Category For This Product*</p></b>
                                    <select class="form-control selectedcategoriesNEW" name="selectedcategoriesNEW" id="selectedcategoriesNEW" placeholder="Choose Category">
                                        <?php echo getAllFurnitureSelectedCategories($data);?>
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
                                <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Enter Position of Product On This Category*</p></b>
                                    <input class="form-control" name="Category_position" value="<?php echo $data['position']; ?>" id="Category_position" placeholder="Position">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <button data-repeater-delete type="button" id="dlt_MultiCat_btn" class="btn btn-danger" style="margin-top: 20px;" >Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>  
                <button data-repeater-create type="button" id="add_MultiCat_btn" class="btn btn-success" >Add Category To Product</button>
            </div>
            <?php 
        } 
        else 
        { ?>
            <div class="report-repeater">
                <div data-repeater-list="multiCategoriesArr">
                    <div class="repeater-row"  data-repeater-item>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group for-shop">
                                    <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Click & Select Category For This Product*</p></b>
                                    <select class="form-control selectedcategoriesNEW" name="selectedcategoriesNEW" id="selectedcategoriesNEW" placeholder="Choose Category">
                                    <option value="" > Choose Category </option>
                                        <?php echo getAllFurnitureSelectedCategories();?>
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
                                <b style="color: black;font-size: 9px;"><p class="text-info">NOTE : Enter Position of Product On This Category*</p></b>
                                    <input class="form-control" name="Category_position" id="Category_position" placeholder="Position">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">

                                    <button data-repeater-delete type="button" id="dlt_MultiCat_btn" class="btn btn-danger" style="margin-top: 20px;" >Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <button data-repeater-create type="button" id="add_MultiCat_btn" class="btn btn-success" >Add Category To Product</button>
            </div>
            <?php 
        } ?>                      
</div>
<?php //} ?>

<!-- MULTIPLE SHOP CATEGORIES END -->

<!-- Related Products option start  -->

<?php 
// $Pid = $this->uri->segment(3);

// if($Pid = $id)
// { ?>
    <!-- <input type="hidden" name="main_category" value='7'/>
    <input type="hidden" name="Product_type" value='FURNITURE'/>
    <div class="form-group for-shop">
        <label>Shop Categories</label>
        <select class="form-control" name="sub_category" id="subCat_select" required>

            <option value="" id = "cat" disable="" selected>*select Sub category name*</option>
        </select>
    </div> 

<?php// }else{ ?>

    <div class="form-group for-shop">
        <label>Shop Categories</label>
        <select class="form-control show-tick show-menu-arrow" name="sub_category" id="shopCat_select" required>
            <?php //foreach( $furCat as $catlight ){ ?> 
                <option value="<?php //echo $catlight->for_id; ?>"><?php //echo $catlight->Name; ?></option>
            <?php //} ?>
        </select>
    </div> -->

<?php //} ?>

<!-- Related second option start -->
<?php 
// $Pid = $this->uri->segment(3);
// if($Pid = $id)
// {  ?>

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
    <?php } ?>
    <p id="warningRelatedProduct"></p>                         
</div>
<?php // } ?>

<!-- Related second option end -->

<!-- Brands option start  -->

<?php if ($showBrands == 1) { ?>
    <div class="form-group for-brands" id="brandOption">
        <div class="row">
            <div class="col-sm-4">
                <label>Brand</label><br />
                <select class="selectpicker" name="brand_id">
                    <?php foreach ($brands as $brand) { ?>
                        <option <?= isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-4">
                <label>Brand Position/order</label>
                <input type="text" placeholder="Brand Position number" name="Brand_position" value="<?= isset($_POST['brand_position']) ? htmlspecialchars($_POST['brand_position']) : '' ?>" class="form-control">
            </div>
        </div>
    </div>
<?php } ?>
        <!-- <input type="hidden" name="m_cat_id" value="" /> -->
        <div class="form-group for-shop">
            <label>Your Selected Materials</label><br />
            <table class="table">
                <tbody>
                    <?php 
                    $s=1; 
                    foreach ($mat_cat as $mts) 
                    { 
                        $mt_id=$mts['m_cat_id'];
                        $m_id=$mts['id'];
                        $product_id=$mts['product_id'];
                        $CI =& get_instance();
                        $md= $CI->load->model('furnitureProducts_model');
                        $brans_id   = $CI->furnitureProducts_model->getgridcat($mt_id);
                        ?>
                        <tr>
                            <td>
                                <p><?= $brans_id['title'] ?></p>    
                            </td>
                            <td>
                                <a productId="<?php echo $product_id;?>" mCatId="<?php echo $mt_id;?>" class="deleteCat btn btn-md btn-success delete_button m-l-md optionsbtn">Delete</a>
                            </td>
                        </tr>
                        <?php  
                    } ?>
                </tbody>
            </table>
        </div>
        <div class="form-group for-Mcategory" id="metCategory">
            <label>Select Material Categories</label><br />
            <select class="selectpicker" name="m_cat_id[]" multiple="multiple">
                <?php foreach ($materials as $material) { ?>
                    <option <?= isset($material['m_cat_id']) && $_POST['m_cat_id'] == $material['id'] ? 'selected' : '' ?> value="<?= $material['id'] ?>"><?= $material['title'] ?></option>
                <?php } ?>
            </select>
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
    <!-- virtualProductsHelp -->
    <div class="modal fade" id="virtualProductsHelp" tabindex="-1" role="dialog" aria-labelledby="virtualProductsHelp">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">What are virtual products?</h4>
                </div>
                <div class="modal-body">
                    Sometimes we want to sell products that are for electronic use such as books. In the box below, you can enter links to products that can be downloaded after you confirm the order as "Processed" through the "Orders" tab, an email will be sent to the customer entered with the entire text entered in the "virtual products" field.
                    We have left only the possibility to add links in this field because sometimes it is necessary that the electronic stuff you provide for downloading will be uploaded to other servers. If you want, you can add your files to "file manager" and take the links to them to add to the "virtual products"
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Update Package Modal-->
    <div class="modal fade" id="UpdateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Material Selection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Select More Materials</label>
                        <?php  
                        foreach ($mat_cat as $row) 
                        { 
                            $mt_id=$row['m_cat_id'];
                            $CI =& get_instance();
                            $md1= $CI->load->model('furnitureProducts_model');
                            $nts_id1=$CI->furnitureProducts_model->getgridcat($mt_id); 
                            ?>
                            <div class="col-sm-12">
                                <input type="checkbox" name="package_edit" value="<?php echo $nts_id1['id'];?>"> <?php echo $nts_id1['title'];?>
                            </div>
                            <?php 
                        } ?>
                    </div>            
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="edit_id" required>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm">Update</button>
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
    
        $(document).ready(function () {   
        $("#shopmulti_category").select2();
        $(".selectedcategoriesNEW").select2();
    });    


    var base_url = '<?= base_url(); ?>';
        function getSubCategories(){
            $.ajax({
                url: base_url + "admin/ecommerce/Furniture_Publish/getSubCategory",
                type: 'POST',
                cache: false,
                data: {
                    'main_category': 7,
                    'sub_category' : '<?php echo $catIdRelatedProduct['shop_categorie']; ?>'
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
    var productId = <?= $id; ?>;
    if(productId > 0){
    //load subcategories 
        getSubCategories();
    }
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
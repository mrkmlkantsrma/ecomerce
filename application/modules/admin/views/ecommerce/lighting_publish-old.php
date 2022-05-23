<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Publish lighting product</h1>
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
        <div class="form-group for-shop">
            <label>Select Designer</label><br />
            <select class="selectpicker" name="designer_id">
                <?php foreach ($designers as $design) { ?>
                    <option <?= isset($_POST['designer_id']) && $_POST['designer_id'] == $design['id'] ? 'selected' : '' ?> value="<?= $design['id'] ?>"><?= $design['title'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
            

            <?php /*?><div class="form-group">
                <a href="javascript:void(0);" class="btn btn-default showSliderDescrption" data-descr="<?= $i ?>">Show Slider Description <span class="glyphicon glyphicon-circle-arrow-down"></span></a>
            </div>
            <div class="theSliderDescrption" id="theSliderDescrption-<?= $i ?>" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'style="display:block;"' : '' ?>>
                <div class="form-group">
                    <label for="basic_description<?= $i ?>">Slider Description (<?= $language->name ?><img src="<?= base_url('attachments/lang_flags/' . $language->flag) ?>" alt="">)</label>
                    <textarea name="basic_description[]" id="basic_description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['basic_description']) ? $trans_load[$language->abbr]['basic_description'] : '' ?></textarea>
                    <script>
                        CKEDITOR.replace('basic_description<?= $i ?>');
                        CKEDITOR.config.entities = false;
                    </script>
                </div>
            </div><?php */?>
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
    
    <div class="table-responsive">  
	<table class="table table-bordered"> 
		<tr>  
			<?php if (isset($_POST['rollover_image1']) && $_POST['rollover_image1'] != null) {?>
                <td><img src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $_POST['rollover_image1'];?>"  width="100px" height="100px"/> </td> 
        
            <?php  }?> 
            <?php if (isset($_POST['rollover_image2']) && $_POST['rollover_image2'] != null) {?>
                <td><img src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $_POST['rollover_image2'];?>"  width="100px" height="100px"/> </td> 
        
            <?php  }?>
            <?php if (isset($_POST['rollover_image3']) && $_POST['rollover_image3'] != null) {?>
                <td><img src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $_POST['rollover_image3'];?>"  width="100px" height="100px"/> </td> 
        
            <?php  }?>
			<?php if (isset($_POST['rollover_image4']) && $_POST['rollover_image4'] != null) {?>
                <td><img src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $_POST['rollover_image4'];?>"  width="100px" height="100px"/> </td> 
        
            <?php  }?>
            <?php if (isset($_POST['rollover_image5']) && $_POST['rollover_image5'] != null) {?>
                <td><img src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $_POST['rollover_image5'];?>"  width="100px" height="100px"/> </td> 
        
            <?php  }?>
            <?php if (isset($_POST['rollover_image6']) && $_POST['rollover_image6'] != null) {?>
                <td><img src="<?php echo base_url();?>attachments/shop_images/rollovers/<?php echo $_POST['rollover_image6'];?>"  width="100px" height="100px"/> </td> 
        
            <?php  }?>
             <?php if (isset($_POST['rollover_image1']) && $_POST['rollover_image1'] != null) {?>
			<input type="hidden" name="old_rollover_image1" value="<?= htmlspecialchars($_POST['rollover_image1']) ?>">
            <?php } else {?>
            <input type="hidden" name="old_rollover_image1" value="">
            <?php } ?>
            <?php if (isset($_GET['to_lang'])) { ?>
            	<input type="hidden" name="rollover1" value="<?= htmlspecialchars($_POST['rollover_image1']) ?>">
         	<?php }?>
            <?php if (isset($_POST['rollover_image2']) && $_POST['rollover_image2'] != null) {?>
			<input type="hidden" name="old_rollover_image2" value="<?= htmlspecialchars($_POST['rollover_image2']) ?>">
            <?php } else {?>
            <input type="hidden" name="old_rollover_image2" value="">
            <?php } ?>
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="rollover2" value="<?= htmlspecialchars($_POST['rollover_image2']) ?>">
            <?php } ?>
            <?php if (isset($_POST['rollover_image3']) && $_POST['rollover_image3'] != null) {?>
			<input type="hidden" name="old_rollover_image3" value="<?= htmlspecialchars($_POST['rollover_image3']) ?>">
            <?php } else {?>
            <input type="hidden" name="old_rollover_image3" value="">
            <?php } ?>
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="rollover3" value="<?= htmlspecialchars($_POST['rollover_image3']) ?>">
            <?php } ?>
            <?php if (isset($_POST['rollover_image4']) && $_POST['rollover_image4'] != null) {?>
			<input type="hidden" name="old_rollover_image4" value="<?= htmlspecialchars($_POST['rollover_image4']) ?>">
            <?php } else {?>
            <input type="hidden" name="old_rollover_image4" value="">
            <?php } ?>
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="rollover4" value="<?= htmlspecialchars($_POST['rollover_image4']) ?>">
            <?php } ?>
            <?php if (isset($_POST['rollover_image5']) && $_POST['rollover_image5'] != null) {?>
			<input type="hidden" name="old_rollover_image5" value="<?= htmlspecialchars($_POST['rollover_image5']) ?>">
            <?php } else {?>
            <input type="hidden" name="old_rollover_image5" value="">
            <?php } ?>
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="rollover5" value="<?= htmlspecialchars($_POST['rollover_image5']) ?>">
            <?php } ?>
            <?php if (isset($_POST['rollover_image6']) && $_POST['rollover_image6'] != null) {?>
			<input type="hidden" name="old_rollover_image6" value="<?= htmlspecialchars($_POST['rollover_image6']) ?>">
            <?php } else {?>
            <input type="hidden" name="old_rollover_image6" value="">
            <?php } ?>
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="rollover6" value="<?= htmlspecialchars($_POST['rollover_image6']) ?>">
            <?php } ?>
		</tr>  
	</table>  
</div>    
                     
             
       
     <div class="form-group">  
                    <label> Add Roll Over Images </label>
                          <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field_img">  
                                    <tr>  
                                         <td> Image 1 <input type="file" name="rollover_image1"  class="form-control name_list" /></td>  
                        
                                         <td><button type="button" name="add" id="add_image" class="btn btn-success">Add More Image</button></td>  
                                    </tr>  
                               </table>  
                               
                          </div>    
                     
                </div>      
   
    <div class="form-group for-shop">
        <label>Shop Categories</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="shop_categorie">
            <?php foreach ($shop_categories as $key_cat => $shop_categorie) { ?>
                <option <?= isset($_POST['shop_categorie']) && $_POST['shop_categorie'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
                    <?php
                    foreach ($shop_categorie['info'] as $nameAbbr) {
                        if ($nameAbbr['abbr'] == $this->config->item('language_abbr')) {
                            echo $nameAbbr['name'];
                        }
                    }
                    ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <?php if ($showBrands == 1) { ?>
        <div class="form-group for-shop">
            <label>Brand</label><br />
            <select class="selectpicker" name="brand_id">
                <?php foreach ($brands as $brand) { ?>
                    <option <?= isset($_POST['brand_id']) && $_POST['brand_id'] == $brand['id'] ? 'selected' : '' ?> value="<?= $brand['id'] ?>"><?= $brand['name'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>

     
     <div class="form-group">  
                    <label><input type="checkbox" name="design_option" value="1" checked="checked" /> Add Design Options </label>
                          <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field"> 
                              <p><i><strong>Note:</strong> To add or update Design Options you first need to delete all current selections</i></p>

                               <?php if ($designs) { foreach ($designs as $des) { 
							   if($des['design']!=""){
							   ?>
                               <tr>  		<input type="hidden" name="design[]" value="" />
                          					<input type="hidden" name="price_design[]" value="" />
                                         <td><input readonly="readonly" type="text" name="design1[]" placeholder="Enter Design Option" class="form-control name_list" value="<?php echo $des['design'];?>" /></td>  
                                         <td><input readonly="readonly" type="text" name="price_design1[]" placeholder="Enter Price" class="form-control name_list" value="<?php echo $des['price'];?>"  /></td>  
                                    </tr>  
                                 <?php } }?>
                                 <a href="<?php echo base_url();?>admin/ecommerce/lighting_publish/design_delete/<?php echo $id;?>" class="btn btn-danger btn-sm delete-record" onclick="Are you sure you want to delete?" >Delete All Design Options</a>

                                 <?php }else{ ?>   
                                 <input type="hidden" name="update" value="" />
                                    <tr>  
                                         <td><input  type="text" name="design[]" placeholder="Enter Design Option" class="form-control name_list" /></td>  
                                         <td><input type="text" name="price_design[]" placeholder="Enter Price" class="form-control name_list" /></td>  
                                         <td><button type="button" name="add" id="add" class="btn btn-success">Add More Design</button></td>  
                                    </tr>  
                                    <?php } ?>
                               </table>  
                               
                          </div>  
                     
                </div>  
                
                 <div class="form-group">  
                    <label>Add Color Options? </label>
                    <?php if ($colors){?>
                    <input type="radio" name="color_option" id="color_options" value="1" checked="checked" />  Yes
                   <div class="table-responsive" id="colors">  
                    <?php } else {?>
                    
                    <input type="radio" name="color_option" id="color_option" value="1" />  Yes <input type="radio" name="color_option" id="color_option" value="0" checked="checked"/> No
                    <div class="table-responsive" id="colors" style="display:none;">  
                     <?php } ?>     
                          
                               <table class="table table-bordered" id="dynamic_field1"> 
                              <p><i><strong>Note:</strong> To add update or Color Options you first need to delete all current selections</i></p>
 
                                <?php if ($colors) { foreach ($colors as $col) { 
								
								if($col['color']!=""){?>
                                <input type="hidden" name="color[]" value="" />
                          					<input type="hidden" name="price_color[]" value="" />
                                    <tr>  
                                         <td><input readonly="readonly" type="text" name="color1[]" placeholder="Enter Color Option" class="form-control name_list" value="<?php echo $col['color'];?>" /></td>  
                                         <td><input readonly="readonly" type="text" name="price_color1[]" placeholder="Enter Price" class="form-control name_list" value="<?php echo $col['price'];?>" /></td>  
                                    </tr>  
                                    <?php } } ?>
                                     <a href="<?php echo base_url();?>admin/ecommerce/lighting_publish/color_delete/<?php echo $id;?>" class="btn btn-danger btn-sm delete-record" onclick="Are you sure you want to delete?" >Delete All Color Options</a>
             
                                    <?php } else {?>
                                    <tr>  
                                         <td><input type="text" name="color[]" placeholder="Enter Color Option" class="form-control name_list" /></td>  
                                         <td><input type="text" name="price_color[]" placeholder="Enter Price" class="form-control name_list" /></td>  
                                         <td><button type="button" name="add" id="add_color" class="btn btn-success">Add More Color</button></td>  
                                    </tr> 
                                    <?php } ?>
                               </table>  
                               
                          </div>  
                     
                </div>  
    
    
    <div class="form-group for-shop">
        <label>Quantity</label>
        <input type="text" placeholder="number" name="quantity" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" class="form-control" id="quantity">
    </div>
    
        
    <?php /*?><div class="form-group for-shop">
        <label>In Slider</label>
        <select class="selectpicker" name="in_slider">
            <option value="1" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= isset($_POST['in_slider']) && $_POST['in_slider'] == 0 || !isset($_POST['in_slider']) ? 'selected' : '' ?>>No</option>
        </select>
    </div><?php */?>
    <div class="form-group for-shop">
        <label>Position/order</label>
        <input type="text" placeholder="Position number" name="position" value="<?= isset($_POST['position']) ? htmlspecialchars($_POST['position']) : '' ?>" class="form-control">
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/products') ?>" class="btn btn-lg btn-default">Cancel</a>
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
<script>
$(document).ready(function(){  
$('#color_option').change(function() {
    if (this.value == '1') {
       $('#colors').css("display","block");  
    }
    else {
        $('#colors').css("display","none");    
    }
});
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="design[]" placeholder="Enter your Design Options" class="form-control name_list" /></td><td><input type="text" name="price_design[]" placeholder="Enter Price" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      }); 
	  $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 
	  
	  var i=1;  
      $('#add_color').click(function(){  
           i++;  
           $('#dynamic_field1').append('<tr id="row1'+i+'"><td><input type="text" name="color[]" placeholder="Enter your Color Options" class="form-control name_list" /></td><td><input type="text" name="price_color[]" placeholder="Enter Price" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">X</button></td></tr>');  
      }); 
	  $(document).on('click', '.btn_remove1', function(){  
           var button_id = $(this).attr("id");   
           $('#row1'+button_id+'').remove();  
      });  
	  
	   var i=1;  
      $('#add_image').click(function(){  
           i++;  
           $('#dynamic_field_img').append('<tr id="row1'+i+'"><td> Image '+i+' <input type="file" name="rollover_image'+i+'"  class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove_img">X</button></td></tr>');  
      }); 
	  $(document).on('click', '.btn_remove_img', function(){  
           var button_id = $(this).attr("id");   
           $('#row1'+button_id+'').remove();  
      });  
}); 
 
	  </script>
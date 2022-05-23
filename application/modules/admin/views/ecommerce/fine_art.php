<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> ADD FINE ART PRODUCT</h1>
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
                <input type="text" name="title" value="<?php echo set_value('title');?>" class="form-control">
            </div>
            <?php if ($designers) { ?>
        <div class="form-group for-shop">
            <label>Select Designer</label><br />
            <select class="selectpicker" name="designer_id">
                <?php foreach ($designers as $design) { ?>
                    <option value="<?= $design['id'] ?>"><?= $design['title'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
            
             <div class="form-group"> 
                <label>Art Type</label>
                <input type="text" name="type" value="<?php echo set_value('type');?>" class="form-control">
            </div>
            <div class="form-group"> 
                <label>Art Size</label>
                <input type="text" name="size" value="<?php echo set_value('size');?>" class="form-control">
            </div>
            <div class="form-group"> 
                <label>Art Customer Info</label>
                <input type="text" name="stock_status" value="<?php echo set_value('stock_status');?>" class="form-control">
            </div>
             <!--<div class="form-group"> 
                <label>Artist Info</label>
                <textarea name="artist_information"  class="form-control" rows="10"></textarea>
                <script>
                    CKEDITOR.replace('artist_information');
                    CKEDITOR.config.entities = false;
                </script>
            </div>-->

           
            
           
        </div>
        
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/fineart_images/' . htmlspecialchars($_POST['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Fineart image:</p>
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
        <label for="userfile">Cover Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    
     <div class="form-group bordered-group">
        <?php
        if (isset($_POST['artist_image']) && $_POST['artist_image'] != null) {
            $image = 'attachments/fineart_images/artists' . htmlspecialchars($_POST['artist_image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Fineart image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_artist_image" value="<?= htmlspecialchars($_POST['artist_image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="artist_image" value="<?= htmlspecialchars($_POST['artist_image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Artist Image</label>
        <input type="file" id="userfile1" name="userfile1">
    </div>
    
     <div class="form-group"> 
                <label>Position</label>
                 <input type="text" name="position" value="<?php echo set_value('position');?>" class="form-control">

            </div>
    
    
    
    
       
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish1">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/finearts') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>

<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Edit designer</h1>
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
                <input type="text" name="title" value="<?php echo $designer['title'];?>" class="form-control">
            </div>
           
            
             <div class="form-group"> 
                <label>Designer Info</label>
                <textarea name="designer_information"  class="form-control" rows="10"><?php echo $designer['designer_information'];?></textarea>
                <script>
                    CKEDITOR.replace('designer_information');
                    CKEDITOR.config.entities = false;
                </script>
            </div>

           
            
           
        </div>
        
    <div class="form-group bordered-group">
        <?php
        if (isset($designer['image']) && $designer['image'] != null) {
            $image = 'attachments/designer_images/' . htmlspecialchars($designer['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current Designer image:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($designer['image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= htmlspecialchars($designer['image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Main Designer Image</label>
        <input type="file" id="userfile" name="userfile">
    </div>
    
    <div class="form-group bordered-group">
        <?php
        if (isset($designer['image1']) && $designer['image1'] != null) {
            $image1 = 'attachments/designer_images/' . htmlspecialchars($designer['image1']);
            if (!file_exists($image1)) {
                $image1 = 'attachments/no-image.png';
            }
            ?>
            <p>Current Designer Product image:</p>
            <div>
                <img src="<?= base_url($image1) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image1" value="<?= htmlspecialchars($designer['image1']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image1" value="<?= htmlspecialchars($designer['image1']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">Designer Products Image</label>
        <input type="file" id="userfile1" name="userfile1">
    </div>
    
     
    
     <div class="form-group"> 
                <label>Position</label>
                 <input type="text" name="position" value="<?php echo $designer['position'];?>" class="form-control">

            </div>
    
    
    
    
       
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish1">Update</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/designers') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>

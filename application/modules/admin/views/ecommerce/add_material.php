<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/shop-cart-add-icon.png') ?>" class="header-img" style="margin-top:-3px;"> Add design</h1>
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
    


        <div class="locale-container" >
            <input type="hidden" name="translations[]" value="">
            <div class="form-group"> 
                <label>Title & Description</label>
                <input type="text" name="title" value="<?php echo set_value('title');?>" class="form-control">
            </div>

           
            
           
        </div>
        
    <div class="form-group bordered-group">
        <?php
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/material_images/' . htmlspecialchars($_POST['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>Current image:</p>
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
    
    
    
    <?php if ($mtc == 1) { ?>
        <div class="form-group for-shop">
            <label>Category</label>
            <select class="selectpicker" name="m_cat_id">
                <?php foreach ($mtc as $mtc) { ?>
                    <option <?= isset($_POST['m_cat_id']) && $_POST['m_cat_id'] == $mtc['id'] ? 'selected' : '' ?> value="<?= $mtc['id'] ?>"><?= $mtc['title'] ?></option>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
       
    <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">Publish</button>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <a href="<?= base_url('admin/materials') ?>" class="btn btn-lg btn-default">Cancel</a>
    <?php } ?>
</form>

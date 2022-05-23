<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1><img src="<?= base_url('assets/imgs/blogger.png') ?>" class="header-img" style="margin-top:-2px;"> Publish Testimonial</h1>
<hr>
<div class="row">
    <div class="col-sm-8 col-md-7">
        <?php if (validation_errors()) { ?>
            <hr>
            <div class="alert alert-danger"><?= validation_errors() ?></div>
            <hr>
        <?php }
        ?>
        <?php if ($this->session->flashdata('result_publish')) { ?>
            <hr>
            <div class="alert alert-danger"><?= $this->session->flashdata('result_publish'); ?></div>
            <hr>
        <?php }
        ?>
        <form method="POST" enctype="multipart/form-data">
            
                <div class="form-group"> 
                    <label>Title </label>
                    <input type="text" name="name" value="<?php echo $test['name'];?>" class="form-control">
                </div>
                <div class="form-group"> 
                    <label>Location </label>
                    <input type="text" name="location" value="<?php echo $test['location'];?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="description">Excerpt </label>
                    <textarea name="excerpt" id="excerpt" rows="50" class="form-control"><?php echo $test['excerpt'];?></textarea>
                    <script>
                        CKEDITOR.replace('excerpt');
                        CKEDITOR.config.entities = false;
                    </script>
                </div>
              
                <div class="form-group">
                    <label for="description">Description </label>
                    <textarea name="description" id="description" rows="50" class="form-control"><?php echo $test['description'];?></textarea>
                    <script>
                        CKEDITOR.replace('description');
                        CKEDITOR.config.entities = false;
                    </script>
                </div>
               
            
            <div class="form-group">
                <?php if (isset($test['image'])) { ?>
                    <input type="hidden" name="old_image" value="<?= htmlspecialchars($test['image']) ?>">
                    <div><img class="img-responsive" src="<?= base_url('attachments/test_images/' . $test['image']) ?>"></div>
                    <label for="userfile">Choose another image:</label>
                <?php } else { ?>
                    <label for="userfile">Upload image:</label>
                <?php } ?>
                <input type="file" id="userfile" name="userfile">
            </div>
            <button type="submit" name="submit" class="btn btn-default">Publish</button>
            <?php if ($id > 0) { ?>
                <a href="<?= base_url('admin/testimonials') ?>" class="btn btn-info">Cancel</a>
            <?php } ?>
        </form>
    </div>
</div>  
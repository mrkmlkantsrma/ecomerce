<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
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
<form action="" method="POST" enctype="multipart/form-data">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel">Edit brand</h4>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label for="name">Brand name</label>

                        <input type="text" name="name" class="form-control" id="name" value="<?php echo $brand['name'];?>">

                    </div>
                    <div class="form-group bordered-group">
                    <?php
					if (isset($brand['image1']) && $brand['image1'] != null) {
						$image = 'attachments/brand_images/' . htmlspecialchars($brand['image1']);
						if (!file_exists($image)) {
							$image = 'attachments/no-image.png';
						}
						?>
						<p>Current Brand image:</p>
						<div>
							<img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
						</div>
						<input type="hidden" name="old_image1" value="<?= htmlspecialchars($brand['image1']) ?>">
						<?php if (isset($_GET['to_lang'])) { ?>
							<input type="hidden" name="image1" value="<?= htmlspecialchars($brand['image1']) ?>">
							<?php
						}
					}
        		?>
                            <label for="userfile">Change Brand Image</label>
                            <input type="file" id="userfile" name="userfile">
                        </div>
                        
                        <div class="form-group bordered-group">
                        <?php
					if (isset($brand['image2']) && $brand['image2'] != null) {
						$image1 = 'attachments/brand_images/' . htmlspecialchars($brand['image2']);
						if (!file_exists($image)) {
							$image1 = 'attachments/no-image.png';
						}
						?>
						<p>Current Brand image:</p>
						<div>
							<img src="<?= base_url($image1) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
						</div>
						<input type="hidden" name="old_image2" value="<?= htmlspecialchars($brand['image2']) ?>">
						<?php if (isset($_GET['to_lang'])) { ?>
							<input type="hidden" name="image2" value="<?= htmlspecialchars($brand['image2']) ?>">
							<?php
						}
					}
        		?>
                            <label for="userfile">Change Brand Dropdown Image</label>
                            <input type="file" id="userfile1" name="userfile1">
                        </div>
                        
 					<div class="form-group">

                        <label for="name">Brand Type</label><br />
                        <select name="type" id="type" class="selectpicker">
                            <option value="">Select Brand Type</option>
                            <option value="F" <?= isset($brand['type']) && $brand['type'] == 'F' ? 'selected' : '' ?>>Furniture</option>
                            <option value="L" <?= isset($brand['type']) && $brand['type'] == 'L' ? 'selected' : '' ?>>Lighting</option>
                        </select>


                    </div>
                     <div class="form-group">

                        <label for="name">Position/order</label>

                        <input type="text" name="position" class="form-control" id="position" value="<?php echo $brand['position'];?>">

                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-primary">Update</button>

                </div>

            </form>
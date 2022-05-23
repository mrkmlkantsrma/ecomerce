<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<?php
$timeNow = time();
if (validation_errors()) 
{ ?>
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
<form action="" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Edit Category</h4>
	</div>
	<div class="modal-body">                   
		<div class="form-group bordered-group">
		<?php
		if (isset($cat['image']) && $cat['image'] != null) 
		{
			echo $image = 'attachments/shop_images/' . htmlspecialchars($cat['image']);
			if (!file_exists($image)) 
			{
				$image = 'attachments/no-image.png';
			}
			?>
			<p>Current Category image:</p>
			<div>
				<img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
			</div>
			<input type="hidden" name="old_image" value="<?= htmlspecialchars($cat['image']) ?>">
			<?php if (isset($_GET['to_lang'])) 
			{ ?>
				<input type="hidden" name="image" value="<?= htmlspecialchars($cat['image']) ?>">
				<?php
			}
		}
		?>
		<label for="userfile">Change Category Image</label>
		<input type="file" id="userfile" name="userfile">
	</div>                    
	<div class="form-group bordered-group">
		<?php
		if (isset($cat['image1']) && $cat['image1'] != null) 
		{
			$image1 = 'attachments/shop_images/' . htmlspecialchars($cat['image1']);
			if (!file_exists($image)) {
				$image1 = 'attachments/no-image.png';
			}
			?>
			<p>Current Dropdown image:</p>
			<div>
				<img src="<?= base_url($image1) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
			</div>
			<input type="hidden" name="old_image1" value="<?= htmlspecialchars($cat['image1']) ?>">
			<?php if (isset($_GET['to_lang'])) { ?>
				<input type="hidden" name="image1" value="<?= htmlspecialchars($cat['image1']) ?>">
				<?php
			}
		}
		?>
		<label for="userfile">Change Menu Dropdown Image</label>
		<input type="file" id="userfile1" name="userfile1">
		</div>
	<div class="form-group bordered-group">
		<label for="show_on_menu">Show On Menu :</label><br>
		  <input type="radio" id="Yes" name="show_on_menu" value="Yes" <?php echo (($cat['show_on_menu']==Yes)?"checked":"") ?>>
		  <label for="Yes">Yes</label>
		  <input type="radio" id="No" name="show_on_menu" value="No" <?php echo (($cat['show_on_menu']==No)?"checked":"") ?>>
		  <label for="No">No</label>
	</div>	
	<div class="modal-footer">
		<a href="<?= base_url('admin/shopcategories') ?>" class="cncl-btn">Cancel</a>
		<button type="submit" name="submit" class="btn btn-primary">Update</button>
	</div>
</form>
<style>
    a.cncl-btn {
    color: #333;
    background-color: #fff;
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    font-size: 14px;
    vertical-align: middle;
    border-radius: 4px;
}
a.cncl-btn:hover {
    text-decoration: none;
}
</style>
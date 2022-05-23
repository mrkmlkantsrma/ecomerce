<h1><img src="<?= base_url('assets/imgs/brands.jpg') ?>" class="header-img" style="margin-top:-3px;"> Brands</h1>

<hr>

<div class="row">

    <div class="col-sm-12 col-md-12">

        <a href="javascript:void(0);" data-toggle="modal" data-target="#addPage" class="btn btn-default" style="margin-bottom:10px;">Add brand</a>

        <?php if (!empty($brands)) {

            ?>
			
            <table class="table table-bordered ">
           	 <thead>
             	<th>Brand Name</th>
                <th>Image</th>
                <th>Dropdown Image</th>
                <th>Position</th>
                 <th>Action</th>
             </thead>
			<tbody>
                <?php

                foreach ($brands as $brand) {
					
						if ($brand['image1']) {
						$image = 'attachments/brand_images/' . htmlspecialchars($brand['image1']);
						}else {
							$image = 'attachments/no-image.png';
						
						}
						if ($brand['image2']) {
						$image1 = 'attachments/brand_images/' . htmlspecialchars($brand['image2']);
						}else {
							$image1 = 'attachments/no-image.png';
						}
						
						?>
                   

                    <tr>

                       <td> <?= $brand['name'] ?></td>
                       <td> <img src="<?= base_url($image) ?>" style="height:100px" /></td>
                       <td> <img src="<?= base_url($image1) ?>" style="height:100px" /></td>
                       <td> <?= $brand['position'] ?></td>
                       

					    <td>
                        <a href="<?php echo base_url('admin/brands/edit/');?><?= $brand['id'] ?>" class=""><i class="fa fa-pencil"></i></a>
                        <a href="?delete=<?= $brand['id'] ?>" class="pull-right confirm-delete">X</a>
                        </td>

                    </tr>

                <?php }

                ?>
</tbody>
            </table>
           

        <?php } else {

        ?>

		<div class="alert alert-info">No brands added!</div>

		<?php } ?>

    </div>

</div>

<div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <form action="" method="POST" enctype="multipart/form-data">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel">Add new brand</h4>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label for="name">Brand name</label>

                        <input type="text" name="name" class="form-control" id="name">

                    </div>
                    <div class="form-group bordered-group">
                            <label for="userfile">Brand Image</label>
                            <input type="file" id="userfile" name="userfile">
                        </div>
                        
                        <div class="form-group bordered-group">
                            <label for="userfile">Brand Dropdown Image</label>
                            <input type="file" id="userfile1" name="userfile1">
                        </div>
                        
 					<div class="form-group">

                        <label for="name">Brand Type</label><br />
                        <select name="type" id="type" class="selectpicker">
                            <option value="">Select Brand Type</option>
                            <option value="F">Furniture</option>
                            <option value="L">Lighting</option>
                        </select>


                    </div>
                     <div class="form-group">

                        <label for="name">Position/order</label>

                        <input type="text" name="position" class="form-control" id="position">

                    </div>
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-primary">Add</button>

                </div>

            </form>

        </div>

    </div>

</div>
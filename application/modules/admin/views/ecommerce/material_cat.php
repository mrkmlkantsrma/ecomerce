<h1><img src="<?= base_url('assets/imgs/brands.jpg') ?>" class="header-img" style="margin-top:-3px;"> Material Categories</h1>

<hr>

<div class="row">

    <div class="col-sm-6 col-md-4">

        <a href="javascript:void(0);" data-toggle="modal" data-target="#addmtc" class="btn btn-default" style="margin-bottom:10px;">Add Matrail Category</a>

        <?php if (!empty($mat_cat)) {

            ?>

            <ul class="list-group list-none">

                <?php

                foreach ($mat_cat as $mtc) {

                    ?>

                    <li class="list-group-item">

                        <?= $mtc['title'] ?>

						<a href="?delete=<?= $mtc['id'] ?>" class="pull-right confirm-delete">X</a>

                    </li>

                <?php }

                ?>

            </ul>

        <?php } else {

        ?>

		<div class="alert alert-info">No Material Category added!</div>

		<?php } ?>

    </div>

</div>

<div class="modal fade" id="addmtc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <form action="" method="POST">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel">Add new Category</h4>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label for="name">Material Categroy Title</label>

                        <input type="text" name="title" class="form-control" id="title">

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
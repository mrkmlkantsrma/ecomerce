<h1><img src="<?= base_url('assets/imgs/blogger.png') ?>" class="header-img" style="margin-top:-2px;"> testimonials Posts</h1>

<hr>
    <a href="<?= base_url('admin/testpublish') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add Testimonial</a>

<?php if ($this->session->flashdata('result_publish')) { ?>
    <hr>
    <div class="alert alert-info"><?= $this->session->flashdata('result_publish') ?></div>
    <?php
}
?>
<div class="row">
    <div class="col-sm-6">
        <form method="GET">
            <div class="input-group">
                <input type="text" class="form-control" name="search" value="<?= @$_GET['search'] ?>" placeholder="Find here">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                </span>
            </div>
            <?php if (isset($_GET['search'])) { ?>
                <a href="<?= base_url('admin/testimonials') ?>">Clear search</a>
            <?php } ?>
        </form>
    </div>
</div>
<hr>
<?php
if (!empty($testimonials)) {
    ?>
    <h1><? //= !isset($_GET['search']) ? $page == 0 ? '' : 'Page: ' . floor($page / 20 + 1) : '' ?></h1>
    <div class="row">
        <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($testimonials as $row) {
                                $u_path = 'attachments/test_images/';
                                if ($row['image'] != null && file_exists($u_path . $row['image'])) {
                                    $image = base_url($u_path . $row['image']);
                                } else {
                                    $image = base_url('attachments/no-image.png');
                                }
                                ?>

                                <tr>
                                    <td>
                                        <img src="<?= $image ?>" alt="No Image" class="img-thumbnail" style="height:100px;">
                                    </td>
                                    <td>
                                        <?= $row['name']; ?>
                                    </td>
                                    <td>
                                        <?= $row['location']; ?>
                                    </td>
                                    
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/blog/testPublish/edit/' . $row['id']) ?>" class="btn btn-info">Edit</a>
                                            <a href="<?= base_url('admin/testimonials?delete=' . $row['id']) ?>"  class="btn btn-danger confirm-delete">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
    </div>
<?php } else { ?>
    <div class="alert alert-danger" role="alert">No Posts</div>
<?php } ?>
<? //= $links_pagination ?>

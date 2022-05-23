<div id="products">
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
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
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> Designers</h1>
    <hr>
    <a href="<?= base_url('admin/designer') ?>" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> Add new designer</a>

    <div class="row">
        <div class="col-xs-12">
            
            <hr>
            <?php
            if ($designers) {
				//print_r($materials);
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Designer Name</th>
                                
                                 <th>Position</th>
                           
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($designers as $row) {
                                $u_path = 'attachments/designer_images/';
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
                                        <?= $row['title']; ?>
                                    </td>
                                   
                                     <td>
                                    
                                        <?= $row['position']; ?>
                                    </td>
                                   
                                    
                                   
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/ecommerce/designer/edit/' . $row['id']) ?>" class="btn btn-info">Edit</a>
                                            <a href="<?= base_url('admin/designers?delete=' . $row['id']) ?>"  class="btn btn-danger confirm-delete">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <? //= $links_pagination ?>
            </div>
            <?php
        } else {
            ?>
            <div class ="alert alert-info">No Designer found!</div>
        <?php } ?>
    </div>
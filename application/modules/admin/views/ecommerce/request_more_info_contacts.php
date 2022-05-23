<div id="products">
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"> More Info Entries</h1>
    <hr>
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <div class="row">
        <div class="col-xs-12">
            
            <?php
            if ($Moreinfo) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Contact Method</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($Moreinfo as $row) {?>
                                <tr>
                                    <td>
                                     <?= $row['first_name']; ?>
                                    </td>
                                    <td>
                                        <?= $row['last_name']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['company']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['email']; ?>
                                    </td>
                                     <td>                                    
                                        <?= $row['method']; ?>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/ecommerce/entries/view/' . $row['id']) ?>" class="btn btn-info">View</a>
                                            <a href="<?= base_url('admin/entries/requestMoreContacts?delete=' . $row['id']) ?>"  class="btn btn-danger confirm-delete">Delete</a>
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
            <?php
        } else {
            ?>
            <div class ="alert alert-info">No More Info Requests found!</div>
        <?php } ?>
    </div>
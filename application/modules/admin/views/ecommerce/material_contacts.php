<div id="products">
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;">Material requests Entries</h1>
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
            if ($materialInfo) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Street Address</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Zip</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($materialInfo as $row) 
                            { ?>
                                <tr>
                                    <td>
                                     <?= $row['first_name']; ?>
                                    </td>
                                    <td>
                                        <?= $row['last_name']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['email_address']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['phone']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['street_address']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['city']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['state']; ?>
                                    </td>
                                    <td>                                    
                                        <?= $row['zip_code']; ?>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/ecommerce/entries/viewMaterial/' . $row['id']) ?>" class="btn btn-info">View</a>
                                            <a href="<?= base_url('admin/entries/materialContacts?delete=' . $row['id']) ?>"  class="btn btn-danger confirm-delete">Delete</a>
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
            <div class ="alert alert-info">No item found!</div>
        <?php } ?>
    </div>
<style>
    img#grid_imgs {width: 50px;height: 50px;z-index: 00!important;position: relative!important;margin: 2px;}
</style>
<div id="products"> 
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"><?= $material['first_name']; ?>'s detail</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <!-- <div class="well hidden-xs"> 
                <div class="row"></div>
            </div> -->
            <!-- <hr>             -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>First Name</th>
                            <td><?= $material['first_name']; ?></td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td><?= $material['last_name']; ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= $material['email_address']; ?></td>                               
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= $material['phone']; ?></td>
                        </tr>
                        <tr>
                            <th>Street Address</th>
                            <td><?= $material['street_address']; ?></td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td><?= $material['city']; ?></td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td><?= $material['state']; ?></td>
                        </tr>
                        <tr>
                            <th>Zip</th>
                            <td><?= $material['zip_code']; ?></td>
                        </tr>                 
                    </table>
                </div>
                <div class="col-md-6">
                    <h3><i class="fa fa-files-o" aria-hidden="true"></i> Product Details</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Product ID</th>
                                <td>            
                                    <?= $orders->for_id; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Product Name</th>
                                <td>            
                                    <?= $orders->title; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Desinger Name</th>
                                <td>            
                                    <?= $orders->designer_name; ?>
                                </td>
                            </tr>
                            <tr>    
                                <th>Product Price</th>
                                <td>            
                                    <?= $orders->price; ?>
                                </td>
                            </tr>
                            <tr>    
                                <th>Product Old Price</th>
                                <td>            
                                    <?php if(!empty($orders->old_price)) { echo $orders->old_price; } else{ echo '-'; } ?>
                                </td>
                            </tr>                 
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3><i class="fa fa-files-o" aria-hidden="true"></i> Sample Material</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <?php 
                            $CI =& get_instance();
                            $md= $CI->load->model('Entries_model');
                            $md= $CI->load->model('Public_model');
                            $grids = str_replace('_', ' ', $material['grid_id']);
                            $g_id = explode(' ', $grids); 
                            foreach ($g_id as $value) 
                            { 
                                $material = $CI->Public_model->getmaterialgrid($value); 
                                ?>  
                                <tr>
                                    <th><?php echo $material['material_design_category_title'];?>-<?php echo $material['title'];?></th>
                                    <td>
                                        <img alt="colorbox" src="<?= base_url();?>attachments/material_images/<?php echo $material['image'];?>" width="50" height="50" style="height:auto; margin: 0 auto; display:block;" border="0">
                                    </td>
                                </tr> 
                                <?php 
                            } 
                            ?>                  
                        </table>
                    </div>
                </div>
            </div>
        </div>
     
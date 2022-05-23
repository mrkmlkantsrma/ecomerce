<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;">Furniture Orders <?= isset($_GET['settings']) ? ' / Settings' : '' ?></h1>
   
</div>
<hr>

<?php
if (!isset($_GET['settings'])) {
    if (!empty($orders)) {
        ?>
       <!-- <div style="margin-bottom:10px;">
            <select class="selectpicker changeOrder">
                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id' ? 'selected' : '' ?> value="id">Order by new</option>
                <option <?= (isset($_GET['order_by']) && $_GET['order_by'] == 'processed') || !isset($_GET['order_by']) ? 'selected' : '' ?> value="processed">Order by not processed</option>
            </select>
        </div>-->
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($orders as $tr) {
                        if ($tr['status'] == 1) {
                            $class = 'bg-danger';
                            $type = 'No processed';
                        }
                        if ($tr['status'] == 2) {
                            $class = 'bg-success';
                            $type = 'Processed';
                        }
                        if ($tr['status'] == 0) {
                            $class = 'bg-warning';
                            $type = 'Rejected';
                        }
                        ?>
                        <tr>
                            <td class="relative" id="order_id-id-<?= $tr['id'] ?>">
                                # <?= $tr['id'] ?>
                                
                            </td>
                            <td><?= $tr['created_at']; ?></td>
                            <td>
                                <i class="fa fa-user" aria-hidden="true"></i> 
                                <?= $tr['first_name'] . ' ' . $tr['last_name'] ?>
                            </td>
                            <td><i class="fa fa-phone" aria-hidden="true"></i> <?= $tr['phone'] ?></td>
                            <td class="<?= $class ?> text-center" data-action-id="<?= $tr['id'] ?>">
                                <div class="status" style="padding:5px; font-size:16px;">
                                    -- <b><?= $type ?></b> --
                                </div>
                                <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['id'] ?>, 2)" class="btn btn-success btn-xs">Processed</a></div>
                                <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['id'] ?>, 1)" class="btn btn-danger btn-xs">No processed</a></div>
                                <div style="margin-bottom:4px;"><a href="javascript:void(0);" onclick="changeOrdersOrderStatus(<?= $tr['id'] ?>, 0)" class="btn btn-warning btn-xs">Rejected</a></div>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-default more-info" data-toggle="modal" data-target="#modalPreviewMoreInfo" style="margin-top:10%;" data-more-info="<?= $tr['id'] ?>">
                                    More Info 
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td class="hidden" id="order-id-<?= $tr['id'] ?>">
                                <div class="table-responsive">
                                    <table class="table more-info-purchase">
                                        <tbody>
                                            <tr>
                                                <td><b>Email</b></td>
                                                <td><a href="mailto:<?= $tr['email_address'] ?>"><?= $tr['email_address'] ?></a></td>
                                            </tr>
                                            <tr>
                                                <td><b>City</b></td>
                                                <td><?= $tr['city'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Address</b></td>
                                                <td><?= $tr['street_address'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Postcode</b></td>
                                                <td><?= $tr['zip_code'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Notes</b></td>
                                                <td><? //= $tr['notes'] ?></td>
                                            </tr>
                                            
                                            <?php /*?><tr>
                                                <td><b>Payment Type</b></td>
                                                <td><?= $tr['payment_type'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Discount</b></td>
                                                <td><?= $tr['discount_type'] == 'float' ? '-' . $tr['discount_amount'] : '-' . $tr['discount_amount'] . '%' ?></td>
                                            </tr>
                                            <?php if ($tr['payment_type'] == 'PayPal') { ?>
                                                <tr>
                                                    <td><b>PayPal Status</b></td>
                                                    <td><?= $tr['paypal_status'] ?></td>
                                                </tr>
                                            <?php } ?><?php */?>
                                            <tr>
                                                <td colspan="2"><b>Products Information</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <?php
													$CI =& get_instance();
												//$md= $CI->load->model('Orders_model');
			
                                                     $arr_products = $tr['grid_id'];
													 $p_id = $tr['p_id'];
													  $new_grid= explode("_",$arr_products);
													  $pro_id=$CI->Orders_model->getProduct($p_id); 
														$pro_info=$CI->Orders_model->getProduct_info($p_id);
													  $cat_id = $pro_id['shop_categorie']; 
													  $brand_id = $pro_id['brand_id'];
													  $designer_id = $pro_id['designer_id']; 
													  $cats=$CI->Orders_model->getCats($cat_id); 
													  $designer=$CI->Orders_model->getDesigner($designer_id); 
													  $brand=$CI->Orders_model->getBrand($brand_id); 
														
														?>
														 <div style="word-break: break-all;">
                                                            <div style="width:50%; float:left;">
                                                            <a data-toggle="tooltip" data-placement="top" title="Click to preview" target="_blank" href="#">
                                                                
                                                                <div style=" background-color: #f1f1f1; border-radius: 2px; padding: 2px 5px;">
                                                                    <b>Title:</b> <?= $pro_info['title'] ?> / 
                                                                    <b>Price: <?= $pro_info['price']; ?></b>
                                                                </div>
                                                            </a>
                                                            <div class="">
                                                                <b>Category:</b>
                                                                <a href=""><?= $cats['name']; ?></a>
                                                            </div>
                                                            <div class="">
                                                                <b>Designer:</b>
                                                                <a href=""><?= $designer['title']; ?></a>
                                                            </div>
                                                            <div class="">
                                                                <b>Brand:</b>
                                                                <a href=""><?= $brand['name']; ?></a>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        </div>
                                                        <div style="width:50%; float:left;">
                                                                <img src="<?= base_url('attachments/shop_images/' . $pro_id['image']) ?>" alt="Product" style="width:350px; margin-right:10px;" class="img-responsive">
                                                            </div>
                                                        <hr>
                                                        
                                                        <?php
														
										
                                                   foreach ($new_grid as $product) {
													   	$mat_id=$CI->Orders_model->getmatcat($product); 
														
													   //echo $product;
                                                     /*    $total_amount = 0;
                                                        $total_amount += str_replace(' ', '', str_replace(',', '.',$product['product_info']['price']));
                                                      */  ?>
                                                        <div style="word-break: break-all; width:70px; float:left;">
                                                            <div>
                                                                <img src="<?= base_url('attachments/material_images/' . $mat_id['image']); ?>" alt="Product" style="width:60px; " class="img-responsive">
                                                            </div>
                                                            <a data-toggle="tooltip" data-placement="top" title="Click to preview" target="_blank" href="<? //= base_url($product['product_info']['url']) ?>">
                                                                <? //= base_url($product['product_info']['url']) ?>
                                                                <div style=" background-color: #f1f1f1;">
                                                                    <b><?= $mat_id['title']; ?></b>
                                                                </div>
                                                            </a>
                                                            
          
                                                        </div>
                                                       
                                                    <?php }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <? //= $links_pagination ?>
    <?php } else { ?>
        <div class="alert alert-info">No orders in the moment!</div>
    <?php }
    ?>        
    <hr>
    <?php
}
if (isset($_GET['settings'])) {
    ?>
    <h3>Cash On Delivery</h3>
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">Change visibility of this purchase option</div>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('cashondelivery_visibility')) { ?>
                        <div class="alert alert-info"><?= $this->session->flashdata('cashondelivery_visibility') ?></div>
                    <?php } ?>
                    <form method="POST" action="">
                        <input type="hidden" name="cashondelivery_visibility" value="<?= $cashondelivery_visibility ?>">
                        <input <?= $cashondelivery_visibility == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="cashondelivery_visibility" class="toggle-changer" type="checkbox">
                        <button class="btn btn-default" value="" type="submit">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <h3>Paypal Account Settings</h3>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Paypal sandbox mode (use for paypal account tests)</div>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('paypal_sandbox')) { ?>
                        <div class="alert alert-info"><?= $this->session->flashdata('paypal_sandbox') ?></div>
                    <?php } ?>
                    <form method="POST" action="">
                        <input type="hidden" name="paypal_sandbox" value="<?= $paypal_sandbox ?>">
                        <input <?= $paypal_sandbox == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="paypal_sandbox" class="toggle-changer" type="checkbox">
                        <button class="btn btn-default" value="" type="submit">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Paypal business email</div>
                <div class="panel-body">
                    <?php if ($this->session->flashdata('paypal_email')) { ?>
                        <div class="alert alert-info"><?= $this->session->flashdata('paypal_email') ?></div>
                    <?php } ?>
                    <form method="POST" action="">
                        <div class="input-group">
                            <input class="form-control" placeholder="Leave empty for no paypal available method" name="paypal_email" value="<?= $paypal_email ?>" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn-default" value="" type="submit">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <hr>
    <h3>Bank Account Settings</h3>
    <div class="row">
        <div class="col-sm-6">
            <?php if ($this->session->flashdata('bank_account')) { ?>
                <div class="alert alert-info"><?= $this->session->flashdata('bank_account') ?></div>
            <?php } ?>
            <form method="POST" action="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2"><b>Pay to - Recipient name/ltd</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="text" name="name" value="<?= $bank_account != null ? $bank_account['name'] : '' ?>" class="form-control" placeholder="Example: BoxingTeam Ltd."></td>
                            </tr>
                            <tr>
                                <td><b>IBAN</b></td>
                                <td><b>BIC</b></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" value="<?= $bank_account != null ? $bank_account['iban'] : '' ?>" name="iban" placeholder="Example: BG11FIBB329291923912301230"></td>
                                <td><input type="text" class="form-control" value="<?= $bank_account != null ? $bank_account['bic'] : '' ?>" name="bic" placeholder="Example: FIBBGSF"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Bank</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="text" value="<?= $bank_account != null ? $bank_account['bank'] : '' ?>" name="bank" class="form-control" placeholder="Example: First Investment Bank"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="form-control" value="Save Bank Account Settings">
            </form>
        </div>
    </div>
<?php } ?>
<!-- Modal for more info buttons in orders -->
<div class="modal fade" id="modalPreviewMoreInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Preview <b id="client-name"></b></h4>
            </div>
            <div class="modal-body" id="preview-info-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>

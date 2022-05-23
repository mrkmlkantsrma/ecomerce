<style>
    table.order-details ,  table.order-details  td {width:100%;border: 1px solid white;  }
    table.order-details  td.order-heading { width: 28%;padding: 10px;}
    table.order-details  td { padding: 0 13px; }
    td#transactionID { text-decoration: underline; }
</style>
<div id="order">
    <?php
        if ($this->session->flashdata('result_delete')) { ?>
            <hr>
            <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
            <hr>
            <?php
        }
        if ($this->session->flashdata('result_publish')) { ?>
            <hr>
            <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
            <hr>
            <?php

        } 
    ?>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-3px;"> Order Details</h1>
    <hr>
    <div class="row">
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Order details</div>
                            <div class="panel-body">
                                <div class="order-detail">
                                    <div class="row">
                                        <div class="col-md-4">    
                                            <table class="order-details">
                                                <th class="text-center"><h5 style="color: black; text-transform: uppercase;font-size:13px;">Order details</h5></th>
                                                <tr>
                                                    <td class= "order-heading">Order ID</td>
                                                    <td>#<?= $singleOrder['order_id'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">Referrer</td>
                                                    <td><?= $singleOrder['referrer'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">payment_type</td>
                                                    <td><?= $singleOrder['payment_type'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">Paypal Status</td>
                                                    <td><?= $singleOrder['paypal_status'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">Transaction ID</td>
                                                    <td id="transactionID"><?= $singleOrder['transactionID'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">Discount Code</td>
                                                    <td><?php if($singleOrder['discount_code']){ echo $singleOrder['discount_code']; }else{  echo 'No Discount Code';  } ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">Name</td>
                                                    <td><?= $singleOrder['first_name'] ?> <?= $singleOrder['last_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">Email</td>
                                                    <td><?= $singleOrder['email'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class= "order-heading">Order Date</td>
                                                    <td><?= date('d-m-Y H:i:s', $singleOrder['date']); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-4">    
                                        <table class="order-details">
                                            <th class="text-center"><h5 style="color: black; text-transform: uppercase;">Billing Details</h5></th>
                                            <tr>
                                                <td class= "order-heading">Address</td>
                                                <td><?= $singleOrder['billing_address'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class= "order-heading">City</td>
                                                <td> <?= $singleOrder['billing_city'] ?> </td>
                                            </tr>
                                            <tr>
                                                <td class= "order-heading">State</td>
                                                <td><?= $singleOrder['billing_state'] ?> </td>
                                            </tr>
                                            <tr>
                                                <td class= "order-heading">Postcode</td>
                                                <td><?= $singleOrder['billing_post_code'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class= "order-heading">Phone</td>
                                                <td><?= $singleOrder['billing_phone'] ?></td>
                                            </tr>
                                        </table>
                                    </div>  
                                     <div class="col-md-4">    
                                        <table class="order-details">
                                            <th class="text-center"><h5 style="color: black; text-transform: uppercase;font-size:13px;">Shipping Details</h5></th>
                                            <tr>
                                                <td class= "order-heading">Address</td>
                                                <td><?= $singleOrder['shipping_address'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class= "order-heading">City</td>
                                                <td> <?= $singleOrder['shipping_city'] ?> </td>
                                            </tr>
                                             <tr>
                                                <td class= "order-heading">State</td>
                                                <td><?= $singleOrder['shipping_state'] ?> </td>
                                            </tr>
                                             <tr>
                                                <td class= "order-heading">Postcode</td>
                                                <td><?= $singleOrder['shipping_post_code'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class= "order-heading">Phone</td>
                                                <td><?= $singleOrder['shipping_phone'] ?></td>
                                            </tr>                                                       
                                        </table>
                                    </div>     
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="well hidden-xs" style="background:none;"> 
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-striped">
                            <h3 style="text-align:center">Ordered Products</h3>
                            <thead>
                                <tr>
                                    <th  style="text-align:center">Product</th>                    
                                    <th  style="text-align:center">Product ID</th>
                                    <th  style="text-align:center">Quantity</th>
                                    <th  style="text-align:center">Regular Price</th>
                                    <th  style="text-align:center">Total Price</th>
                                    <!-- <th  style="text-align:center">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($orders as $order) { ?>
                                    <tr>
                                        <td  style="text-align:center"><?= $order['product_name']; ?></td>
                                        <td  style="text-align:center"><?= $order['product_id']; ?></td>
                                        <td  style="text-align:center"><?= $order['qty']; ?></td>
                                        <td  style="text-align:center"><?= $order['regular_price']; ?></td>
                                        <td  style="text-align:center"><?= $order['total_price']; ?></td>
                                        <!-- <td  style="text-align:center"><a href="<?= base_url('admin/ecommerce/orders/singleOrder_View?delete=' . $order['item_id']) ?>"  class="btn btn-danger confirm-delete">Delete</a></td> -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
</div>                  
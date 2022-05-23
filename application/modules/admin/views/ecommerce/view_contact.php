<div id="products">
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"><?= $contact['first_name']; ?>'s detail</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <!-- <div class="well hidden-xs"> 
                <div class="row"> 
                </div>
            </div>
            <hr> -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                            <tr>
                                <th>First Name</th>
                                <td><?= $contact['first_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td><?= $contact['last_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td><?= $contact['company']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                 <td><a href="mailto:<?= $contact['phone']; ?>"><?= $contact['email']; ?></a></td>
                               
                            </tr>
                            <tr>
                                <th>Phone</th>
                                   <td><a href="tel:<?= $contact['phone']; ?>"><?= $contact['phone']; ?></a></td>
                            </tr>
                            <tr>
                                <th>Contact Method</th>
                                  <td><?= $contact['method']; ?></td>
                            </tr>
                            <tr>
                                <th>Message</th>
                                  <td> <?= $contact['message']; ?></td>
                            </tr>
                            <?php if($contact['entry_type'] != 'trade_info') { ?>
                                <?php if($contact['entry_type'] != 'contact' && $contact['entry_type'] != 'price_quote' ){ ?>
                                <tr>
                                <th>Product Name</th>
                                    <td> <?php  echo $product->title; ?></td>
                                </tr>  
                                <?php } ?>
                            <?php } ?>
                                                
                        <tbody> 
                        </tbody>

                        
                    </table>
                    <?php if($contact['entry_type'] != 'trade_info') { ?>
                        <?php if($contact['entry_type'] != 'contact' && $contact['entry_type'] != 'price_quote' ){ ?>
                            <div class="col-sm-8 productinfobtn text-center">
                            <?php if($catName == "view_fineart"){ ?>
                                <a href="<?= base_url('fine_art/' .$productUrl); ?>" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #fff; text-decoration: none; background-color: #39b4c4; border-top: 15px solid #39b4c4; border-bottom: 15px solid #39b4c4; border-left: 25px solid #39b4c4; border-right: 25px solid #39b4c4; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">Product&rarr;</a>
                          <?php }else{ ?>
                            <a href="<?= base_url('home/' . $productUrl ); ?>" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #fff; text-decoration: none; background-color: #39b4c4; border-top: 15px solid #39b4c4; border-bottom: 15px solid #39b4c4; border-left: 25px solid #39b4c4; border-right: 25px solid #39b4c4; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">Product&rarr;</a>

                            <?php } ?>
                                
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
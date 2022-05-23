<div id="products"> 
    <h1><img src="<?= base_url('assets/imgs/products-img.png') ?>" class="header-img" style="margin-top:-2px;"><?= $trade['first_name']; ?>'s detail</h1>
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
                                <td><?= $trade['first_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td><?= $trade['last_name']; ?></td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td><?= $trade['company']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= $trade['email']; ?></td>                               
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?= $trade['phone']; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?= $trade['address']; ?></td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td><?= $trade['city']; ?></td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td><?= $trade['state']; ?></td>
                            </tr>
                            <tr>
                                <th>Zip</th>
                                <td><?= $trade['zip']; ?></td>
                            </tr> 
                            <tr>
                                <th>Website</th>
                                <td><?= $trade['website']; ?></td>
                            </tr> 
                            <tr>
                                <th>com_buiness_focus</th>
                                <td><?= $trade['com_buiness_focus']; ?></td>
                            </tr> 
                            <tr>
                                <th>hear_about</th>
                                <td><?= $trade['hear_about']; ?></td>
                            </tr>                
                        <tbody>                             
                        </tbody>
                    </table>
                </div>
                
            </div>
            
        
    </div>
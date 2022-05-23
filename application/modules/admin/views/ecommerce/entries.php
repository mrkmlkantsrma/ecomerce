<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<div>
    <h1><img src="<?= base_url('assets/imgs/orders.png') ?>" class="header-img" style="margin-top:-2px;"> CONTACT ENTRIES <?= isset($_GET['settings']) ? ' / Settings' : '' ?></h1>
</div>
<hr>
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <a href="<?php echo base_url('admin/entries/contacts');?>" class="btn btn-primary btn-lg" style="font-size:30px;"><i class="fa fa-list-alt" aria-hidden="true"></i> Contact Entries</a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <a href="<?php echo base_url('admin/entries/info');?>" class="btn btn-success btn-lg" style="font-size:30px;"><i class="fa fa-list" aria-hidden="true"></i> Request Info Entries</a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <a href="<?php echo base_url('admin/entries/moreInfo');?>" class="btn btn-success btn-lg" style="font-size:30px;"><i class="fa fa-list" aria-hidden="true"></i> More Info Entries</a>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>

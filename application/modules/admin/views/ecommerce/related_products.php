<h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-3px;">CUSTOMERS ALSO VIEWED FOR SUB CATEGORIES</h1>
<hr>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <a href="<?= base_url('admin/ecommerce/RelatedProducts/addRelatedPro') ?>" class="btn btn-primary" style="margin-bottom:10px;">Add Sub Category Related Product</a>
        <?php if (!empty($proCategory)) 
        { ?>			
            <table class="table table-bordered ">
           	    <thead>
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Products Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php  
                    foreach($proCategory as $data) 
                    { ?>
                        <tr>   
                            <td> <?php echo getCatSubCatTitleById($data['category_id']);?></td>
                            <td> <?php echo getCatSubCatTitleById($data['sub_category_id']);?></td>

                            <td>
                                <?php 
                                    $whereData = ['category_id' => $data['category_id'],
                                    'sub_category_id' => $data['sub_category_id'],];
                                    echo getRelatedProducts($whereData); ?>
                            </td>
                             <td>
                                <a href="<?php echo base_url('admin/ecommerce/RelatedProducts/edit/');?><?= $data['sub_category_id'] ?>" class="btn btn-info">Edit</a>
                                <a href="?delete=<?= $data['sub_category_id'] ?>" class="btn btn-danger confirm-delete">Delete</a>
                            </td>
                        </tr>
                        <?php 
                    } ?>
                </tbody>
            </table>
            <?php 
        } 
        else 
        {
            ?>
            <div class="alert alert-info">No Sub Category Related Product added!</div>
            <?php 
        } ?>
    </div>
</div>

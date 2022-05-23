<h1><img src="<?= base_url('assets/imgs/categories.jpg') ?>" class="header-img" style="margin-top:-3px;"> CUSTOMERS ALSO VIEWED FOR CATEGORIES</h1>
<hr>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <a href="<?= base_url('admin/ecommerce/DefaultRelatedProducts/addDefaultRelatedPro') ?>" class="btn btn-primary" style="margin-bottom:10px;">Update Category Related Product</a>
     <?php if (!empty($proCategory)) 
        { ?>			
            <table class="table table-bordered ">
            <thead>
                    <th>Category Name</th>
                    <th>Products Name</th>
                </thead>
                <tbody>
                    <?php  
                    foreach($proCategory as $data) 
                    { ?>
                        <tr>   
                            <td> <?php echo getCatSubCatTitleById($data['category_id']);?></td>
                            <td>
                                <?php 
                                    $whereData = ['category_id' => $data['category_id']];
                                    echo getRelatedProducts($whereData); ?>
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
            <div class="alert alert-info">No Category Related Product added!</div>
            <?php 
        } ?>
    </div>
</div>
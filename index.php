<?php

require 'helpers/dbConnection.php';
require 'helpers/functions.php';
 require 'helpers/checkLogin.php';
#####################################################################################################################
require 'layouts/header.php';
require 'layouts/nav.php';
require 'layouts/sidNav.php';


$sql = "SELECT products.*, categories.cat_name,user_details.name FROM products INNER JOIN categories ON products.cat_id = categories.id INNER JOIN user_details  ON products.user_id = user_details.id 
order by products.id desc limit 10 ";
$op  = DoQuery($sql);


?>

        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Primary Card</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Warning Card</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Success Card</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Danger Card</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area mr-1"></i>
                                Area Chart Example
                            </div>
                            <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Bar Chart Example
                            </div>
                            <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                       Last 10 Inserted Products
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Bar code</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Expire Date</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Added by</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Bar code</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Expire Date</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Added by</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                            # Fetch Data & display . . . 
                            while ($data = mysqli_fetch_assoc($op)) {
                            ?>

                                <tr>
                                    <td><?php echo $data['id'] ?></td>
                                    <td><?php echo $data['p_name'] ?></td>
                                    <td><?php echo $data['barcode'] ?></td>
                                    <td><?php echo $data['qunty'] ?></td>
                                    <td><?php echo $data['price'] ?></td>
                                    <td><?php echo $data['expire_date'] ?></td>
                                    <td> <img src="Products/uploads/<?php echo $data['image'] ?>" width="80px" height="80px"></td>
                                    <td><?php echo $data['cat_name'] ?></td>
                                    <td><?php echo $data['name'] ?></td>
                                    
                                </tr>
                            <?php } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>


<?php 
  require 'layouts/footer.php';
?>


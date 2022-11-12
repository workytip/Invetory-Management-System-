<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

#####################################################################################################################
$sql = "SELECT products.*, categories.cat_name,user_details.name FROM products INNER JOIN categories ON products.cat_id = categories.id INNER JOIN user_details  ON products.user_id = user_details.id
";
$op  = DoQuery($sql);

################################################################################################################
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Products</h1>
        <ol class="breadcrumb mb-4">
            <?php
            Message('Products/Display');
            ?>
        </ol>


        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
               Products DataTable 
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
                                <th>Edit</th>
                                <th>Remove</th>
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
                                <th>Edit</th>
                                <th>Remove</th>
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
                                    <td> <img src="uploads/<?php echo $data['image'] ?>" width="80px" height="80px"></td>
                                    <td><?php echo $data['cat_name'] ?></td>
                                    <td><?php echo $data['name'] ?></td>
                                    <td> <a href='edit.php?id=<?php echo $data['id'];  ?>' class='btn btn-info m-r-1em'>Edit</a> </td>
                                    <td> <a href='delete.php?id=<?php echo $data['id'] ?>' class='btn btn-danger m-r-1em'>Delete</a> </td>

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
require '../layouts/footer.php';
?>
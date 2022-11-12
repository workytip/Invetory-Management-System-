<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkAdmin.php';

#####################################################################################################################
$sql = "SELECT  purchases_invoices.*, vendors.v_name,user_details.name,products.p_name FROM purchases_invoices INNER JOIN vendors ON purchases_invoices.vendor_id = vendors.id INNER JOIN user_details  ON purchases_invoices.user_id = user_details.id INNER JOIN products ON purchases_invoices.product_id=products.id;
";
$op  = DoQuery($sql);

################################################################################################################
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Purchase Invoices</h1>
        <ol class="breadcrumb mb-4">
            <?php
            Message('Purchases Invoices/Display');
            ?>
        </ol>


        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
               Invoices DataTable 
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Created At</th>
                                <th>Vendor Name</th>
                                <th>Payment Status</th>
                                <th>Added by</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                  <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Created At</th>
                                <th>Vendor Name</th>
                                <th>Payment Status</th>
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
                                    <td><?php echo $data['qunty'] ?></td>
                                    <td><?php echo $data['total_price'] ?></td>
                                    <td><?php echo date('Y-m-d H:i:s',$data['created_at'])  ?></td>
                                    <td><?php echo $data['v_name'] ?></td>
                                    <td><?php echo $data['payment_status'] ?></td>
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
<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkAdmin.php';

#####################################################################################################################
$sql = "SELECT products.p_name ,stock.* FROM products INNER JOIN stock ON products.id = stock.product_id";
$op  = DoQuery($sql);

################################################################################################################
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Stock</h1>
        <ol class="breadcrumb mb-4">
            <?php
            Message('stock/Display');
            ?>
        </ol>
<form method='GET' action='<?=url('Stock/Purch_report.php') ?>'>
        <div class="row">
            <div class="col">
                <label for="exampleInputName" class=" ">Date From :</label>
                <input type="date" required id="exampleInputName" class="form-control " aria-describedby="" name="D_from">
            </div>
            <div class="col">
                <label for="exampleInputName" class=" ">Date to :</label>
                <input type="date" name="D_to" class="form-control">
            </div>
            <div class="col">
            <button type='submit'  class="btn btn-success form-control">Get Purchase Report</button>

            </div>
        </div>
</form>

<form method='GET' action='<?=url('Stock/Sales_report.php') ?>'>
        <div class="row">
            <div class="col">
                <label for="exampleInputName" class=" ">Date From :</label>
                <input type="date" required id="exampleInputName" class="form-control " aria-describedby="" name="D_from">
            </div>
            <div class="col">
                <label for="exampleInputName" class=" ">Date to :</label>
                <input type="date" name="D_to" class="form-control">
            </div>
            <div class="col">
            <button type='submit'  class="btn btn-success form-control">Get Sales Report</button>

            </div>
        </div>
</form>




        <br><br>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Stock DataTable
            </div>

            <div class="card-body">
                <div class="form-group">
                    <!-- <label for="exampleInputName">Date From</label>
        <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" name="D_from" >
      </div>


      <label for="exampleInputName">Date to</label>
        <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" name="D_to" >
      </div> -->



                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Edit</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
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
                                        <td> <a href='edit.php?id=<?php echo $data['id'];  ?>' class='btn btn-info m-r-1em '>Edit</a> </td>
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
<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkAdmin.php';

################################################################################################################
# Fetch Raw Data . . . 
$id = $_GET['id'];
$sql = "select * from stock where id = $id ";
$op  = DoQuery($sql);
$Stockdata = mysqli_fetch_assoc($op);

$sql5 = "select * from products";
$producObj  = DoQuery($sql5);

################################################################################################################


// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $qunty =(int) Clean($_POST['qunty']);
    $product_id =(int) Clean($_POST['product_id']);

    # Validate Input . . . 
    $errors = [];

    if (!Validate($product_id, 'required')) {
        $errors['product_id'] = "Field Required";
      } 

      if (!Validate($qunty, 'required')) {
        $errors['quantity'] = "Field Required";
      }elseif (!Validate($qunty, 'int')) {
        $errors['quantity'] = "Invalid Input should be number";
      }

    # Check if there are any errors . . .
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        // code . . . 

        $sql = "UPDATE stock SET product_id = $product_id ,qunty=$qunty WHERE id = $id";
        $op  = DoQuery($sql);

        if ($op) {
            $message = ['success' => 'Category Updated Successfully'];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
             exit(); // stop the script

        } else {
            $message = ['error' => 'Error Updating Category  , Try Again '];
            $_SESSION['Message'] = $message;
        }
    }
}



################################################################################################################


require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard / Stock</h1>
        <ol class="breadcrumb mb-4">

            <?php
            Message('Stock/Edit');
            ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $Stockdata['id']; ?>" method="post" enctype="multipart/form-data">


        <div class="form-group"  >
        <label for="exampleInputPassword">Choose Product</label>
        <select class="form-control" required name="product_id" >

        <?php 
         $sql5 = "select * from products";
         $producObj  = DoQuery($sql5);
       
            while ($data7= mysqli_fetch_assoc($producObj)) {?> 
         
         <option value="<?php echo $data7['id'];?>" <?php if ($data7['id'] == $Stockdata['product_id']) {
                                                                        echo 'selected';
                                                                    }  ?>> <?php echo $data7['p_name'];   ?></option>
          <?php } ?>
        </select>
      </div>



            <div class="form-group">
                <label for="exampleInputName">Quantity</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="qunty" value="<?php echo $Stockdata['qunty']; ?>" placeholder="Enter Title">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


</main>


<?php
require '../layouts/footer.php';
?>
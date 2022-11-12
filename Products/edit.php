<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################################################################
// select roles . . . 
$sql = "select * from categories";
$CatObj  = DoQuery($sql);

$sql2 = "select * from user_details";
$userObj  = DoQuery($sql2);

$sql3 = "select * from vendors";
$VenObj =DoQuery($sql3);
################################################################################################################

################################################################################################################
# Fetch Raw Data . . . 
$id = $_GET['id'];
$sql5 = "select * from products where id = $id ";
$op  = DoQuery($sql5);
$AccountData = mysqli_fetch_assoc($op);
################################################################################################################


// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name       = Clean($_POST['name']);
    $barcode      = Clean($_POST['barcode']);
    $price    = Clean($_POST['price']);
    $qunty   = Clean($_POST['qunty']);
    $expire_date   = Clean($_POST['expire_date']);
    $cat_id   = Clean($_POST['cat_id']);
    $user_id   = Clean($_POST['user_id']);
    $ven_id   = Clean($_POST['ven_id']);


    # Validate Input . . . 
    $errors = [];

    if (!Validate($name, 'required')) {
        $errors['Name'] = "Field Required";
    } elseif (!Validate($name, 'min', 3)) {
        $errors['Name'] = "Length Must be >= 3 chars";
    }

    if (!Validate($p_name, 'required')) {
        $errors['name'] = "Field Required";
      }  
    
      if (!Validate($price, 'required')) {
        $errors['price'] = "Field Required";
      }  
    
    
      if (!Validate($qunty, 'required')) {
        $errors['quantity'] = "Field Required";
      }  
    
    
      if (!Validate($expire_date, 'required')) {
        $errors['expire_date'] = "Field Required";
      }  
    
      if (!Validate($user_id, 'required')) {
        $errors['user_id'] = "Field Required";
      }  
      if (!Validate($cat_id, 'required')) {
        $errors['category_id'] = "Field Required";
      }  
      if (!Validate($ven_id, 'required')) {
        $errors['vendor_id'] = "Field Required";
      }  


    


    if (Validate($_FILES['image']['name'], 'required')) {

        if (!Validate($_FILES['image']['type'], 'image')) {
            $errors['Image'] = "Invalid Extension";
        }
    }



    # Check if there are any errors . . .
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        // code . . . 


        if (Validate($_FILES['image']['name'], 'required')) {
            # Upload File . . . 
            $imageName = Upload($_FILES);
        } else {
            $imageName = $AccountData['image'];
        }



        $sql = "UPDATE products  SET p_name= '$name' ,vendor_id=$ven_id, barcode =$barcode , price = $price ,qunty=$qunty,expire_date='$expire_date',cat_id=$cat_id,user_id=$user_id, image = '$imageName' WHERE id = $id";
        $op  = DoQuery($sql);

        if ($op) {
            $message = ['success' => 'Product Editing Successfully'];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
            exit(); // stop the script

        } else {
            $message = ['error' => 'Error Editint Product  , Try Again '];
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
        <h1 class="mt-4">Dashboard / Products</h1>
        <ol class="breadcrumb mb-4">

            <?php
            Message('Products/Edit');
            ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $AccountData['id']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" placeholder="Enter Name" value="<?php echo $AccountData['p_name']; ?>">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Bar Code</label>
                <input type="number" class="form-control" required name="barcode" placeholder="Enter Bar Code Serial Number" value="<?php echo $AccountData['barcode']; ?>">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Price</label>
                <input type="number" class="form-control" required id="exampleInputPassword1" name="price" placeholder="Enter Price" value="<?php echo $AccountData['price']; ?>">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Quantity</label>
                <input type="number" class="form-control" required id="exampleInputName" aria-describedby="" name="qunty" placeholder="Enter the Quantity" value="<?php echo $AccountData['qunty']; ?>">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Expire date</label>
                <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" name="expire_date" placeholder="Enter Name" value="<?php echo $AccountData['expire_date']; ?>">
            </div>


            <div class="form-group">
                <label for="exampleInputPassword">Category</label>
                <select class="form-control" required name="cat_id">

                    <?php
                    while ($data = mysqli_fetch_assoc($CatObj)) {
                    ?>

                        <option value="<?php echo $data['id']; ?>" <?php if ($data['id'] == $AccountData['cat_id']) {
                                                                        echo 'selected';
                                                                    }  ?>><?php echo $data['cat_name']; ?></option>

                    <?php }  ?>

                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Vendor</label>
                <select class="form-control" required name="ven_id">

                    <?php
                    while ($data3 = mysqli_fetch_assoc($VenObj)) {
                    ?>

                        <option value="<?php echo $data3['id']; ?>" <?php if ($data3['id'] == $AccountData['vendor_id']) {
                                                                        echo 'selected';
                                                                    }  ?>><?php echo $data3['v_name']; ?></option>

                    <?php }  ?>

                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Added by</label>
                <select class="form-control" required name="user_id">

                    <?php
                    while ($data2 = mysqli_fetch_assoc($userObj)) {
                    ?>

                        <option value="<?php echo $data2['id']; ?>" <?php if ($data2['id'] == $AccountData['user_id']) {
                                                                        echo 'selected';
                                                                    }  ?>><?php echo $data2['name']; ?></option>

                    <?php }  ?>

                </select>
            </div>



            <div class="form-group">
                <label for="exampleInputPassword">Image</label>
                <input type="file" name="image">
            </div>
            <p>
                <img src="uploads/<?php echo $AccountData['image']; ?>" alt="" height="250px" width="250px">
            </p>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


</main>


<?php
require '../layouts/footer.php';
?>
<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################################################################
// select roles . . . 
$sql = "select * from user_details";
$usersObj  = DoQuery($sql);

$sql2 = "select * from categories";
$catsObj  = DoQuery($sql2);

$sql3 = "select * from vendors";
$VendorObj = DoQuery($sql3);
################################################################################################################
// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $p_name         = Clean($_POST['p_name']);
  $barcode        = Clean($_POST['barcode']);
  $price          = Clean($_POST['price']);
  $qunty         = Clean($_POST['qunty']);
  $expire_date   = Clean($_POST['expire_date']);
  $user_id       = Clean($_POST['user_id']);
  $cat_id        = Clean($_POST['cat_id']);
  $ven_id        = Clean($_POST['vendor_id']);

  # Validate Input . . . 
  $errors = [];

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


  if (!Validate($barcode, 'required')) {
    $errors['barcode'] = "Field Required";
  } elseif (!Validate($barcode, 'min', 15)) {
    $errors['barcode'] = "Serial should be at least 15 digits";
  }


  if (!Validate($_FILES['image']['name'], 'required')) {
    $errors['Image'] = "Field Required";
  } elseif (!Validate($_FILES['image']['type'], 'image')) {
    $errors['Image'] = "Invalid Extension";
  }



  # Check if there are any errors . . .
  if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;
  } else {
    // code . . . 


    # Upload File . . . 
    $imageName = Upload($_FILES);

    if ($imageName == false) {

      $message = ["Error" => "Error Uploading File"];
    } else {




      $sql = "INSERT INTO products (p_name,barcode,price,image,qunty,expire_date,user_id,cat_id,vendor_id) VALUES ('$p_name','$barcode',$price,'$imageName',$qunty,'$expire_date',$user_id,$cat_id,$ven_id)";
      $op  = DoQuery($sql);

      if ($op) {
        $message = ['success' => 'Product Added Successfully'];
      } else {
        $message = ['error' => 'Error Adding Product'];
      }
    }


    $_SESSION['Message'] = $message;
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
      Message('Products/Create');
      ?>

    </ol>



    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

      <div class="form-group">
        <label for="exampleInputName">Product Name</label>
        <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="p_name" placeholder="Enter Product Name">
      </div>


      <div class="form-group">
        <label for="exampleInputEmail">Bar Code</label>
        <input type="text"  class="form-control" required name="barcode" placeholder="Enter Bar Code Serial Number">
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Price</label>
        <input type="number" class="form-control" required id="exampleInputPassword1" name="price" placeholder="Enter Price">
      </div>

      <div class="form-group">
        <label for="exampleInputName">Quantity</label>
        <input type="number" class="form-control" required id="exampleInputName" aria-describedby="" name="qunty" placeholder="Enter the Quantity">
      </div>

      <div class="form-group">
        <label for="exampleInputName">Expire date</label>
        <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" name="expire_date" placeholder="Enter Name">
      </div>



      <div class="form-group">
        <label for="exampleInputPassword">User name</label>
        <select class="form-control" required name="user_id">

          <?php
          while ($data = mysqli_fetch_assoc($usersObj)) {
          ?>

            <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>

          <?php }  ?>

        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Vendor Name</label>
        <select class="form-control" required name="vendor_id">

          <?php
          while ($datav = mysqli_fetch_assoc($VendorObj)) {
          ?>

            <option value="<?php echo $datav['id']; ?>"><?php echo $datav['v_name']; ?></option>

          <?php }  ?>

        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Category</label>
        <select class="form-control" required name="cat_id">

          <?php
          while ($data = mysqli_fetch_assoc($catsObj)) {
          ?>

            <option value="<?php echo $data['id']; ?>"><?php echo $data['cat_name']; ?></option>

          <?php }  ?>

        </select>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Image</label>
        <input type="file" name="image">
      </div>



      <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</main>


<?php
require '../layouts/footer.php';
?>
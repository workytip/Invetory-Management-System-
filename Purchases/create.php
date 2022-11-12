<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkAdmin.php';

################################################################################################################


$sql3 = "select * from vendors";
$vendorObj  = DoQuery($sql3);

#################################################################


if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $created_at = time();
  $user_id = (int)$_SESSION['user']['id'];

  $vendor_id       = (int)Clean($_POST['vendor_id']);
  $payment         = Clean($_POST['payment']);
  $product_id        = (int)Clean($_POST['product_id']);
  $qunty         =(int)Clean($_POST['qunty']);
  $total_price=$_SESSION['mytotal'];


  # Validate Input . . . 
  $errors = [];

  if (!Validate($vendor_id, 'required')) {
    $errors['vendor_id'] = "Field Required";
  } 
  
  
  if (!Validate($payment, 'required')) {
    $errors['payment'] = "Field Required";
  } 

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
  } else{
    // code . . . 


    $sql5 = "INSERT INTO purchases_invoices (vendor_id,product_id,qunty,payment_status,total_price,created_at,user_id)VALUES ($vendor_id,$product_id,$qunty,'$payment',$total_price,$created_at,$user_id)";
    $op5  = DoQuery($sql5);

    if ($op5) {
      $message = ['success' => 'Purchase invoice Added Successfully'];
    } else {
      $message = ['error' => '  Purchase invoice has not been added yet'];
    }

    }


    $_SESSION['Message'] = $message;
  }



require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
  <div class="container-fluid">
    <h1 class="mt-4">Dashboard / Purchases</h1>
    <ol class="breadcrumb mb-4">
      <?php
      Message('Purchase/Create');
      ?>
    </ol>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" id='product_form'>

      <div class="form-group">
        <label for="exampleInputPassword">Choose the Vendor</label>
        <select class="form-control" required name="vendor_id" onchange="getvendorproducts(this.value)">

          <?php
          while ($data4 = mysqli_fetch_assoc($vendorObj)) {
          ?>

            <option value="<?php echo $data4['id']; ?>"><?php echo $data4['v_name'];   ?></option>

          <?php }  ?>

        </select>
      </div>



      <div class="form-group"  >
        <label for="exampleInputPassword">Choose Product</label>
        <select class="form-control" required name="product_id" onchange="showPrice(this.value)" id="ventext">
        <!-- <option>choose vendor first</option> -->
         

        </select>
      </div>

      
      <div class="form-group">
        <label for="exampleInputName">Quantity</label>
        <input type="number" onchange="GetTotals(this.value)"  class="form-control" required id="quntyid" name="qunty" placeholder="Enter the Quantity">
      </div>

      <div class="form-group"  id="txtHint">

        <label for="exampleInputName">Product Price is :</label>
        <!-- AJAX REQUEST HERE -->
      </div>

      <div class="form-group" id="mytext">
        <label for="exampleInputName">Total</label>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Payment Status:</label>
        <select class="form-control" required name="payment">

          <option value="Cash">Cash</option>
          <option value="Visa">Visa</option>

        </select>
      </div>


    <button type="submit" name="insert" class="btn btn-primary">Submit</button>
    </form>



</main>

<script>

function getvendorproducts(str) {
    if (str == "") {
      document.getElementById("ventext").innerHTML = "";
      return;
    } else {
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("ventext").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "ajaxprpoduct.php?vendor=" + str, true);
      xmlhttp.send();
    }
  }


  function showPrice(str) {
    if (str == "") {
      document.getElementById("txtHint").innerHTML = "";
      return;
    } else {
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "ajaxprice.php?q=" + str, true);
      xmlhttp.send();
    }
  }


  function GetTotals(str) {
    if (str == "") {
      document.getElementById("mytext").innerHTML = "";
      return;
    } else {
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("mytext").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "ajaxptotal.php?qunty=" + str, true);
      xmlhttp.send();
    }
  }

  
</script>

<?php
require '../layouts/footer.php';

?>
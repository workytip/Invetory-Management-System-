<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkAdmin.php';

################################################################################################################


$sql2 = "select * from vendors";
$vendorObj  = DoQuery($sql2);


$id = $_GET['id'];
// $_SESSION['editId']=$id;

$sql3 = "select * from purchases_invoices where id = $id ";
$op1  = DoQuery($sql3);
$InvoiceData = mysqli_fetch_assoc($op1);
#################################################################

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $created_at = time();
  $user_id = (int)$_SESSION['user']['id'];
  $vendor_id =(int) Clean($_POST['vendor_id']);
  $product_id=(int)Clean($_POST['product_id']);
  $qunty=(int)Clean($_POST['qunty']);
  //   $total=$_SESSION['mytotal'];
  $payment =Clean($_POST['payment']);
  $total =(int)Clean($_POST['total']);



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

  if (!Validate($total, 'required')) {
    $errors['total'] = "Field Required";
  }elseif (!Validate($total, 'int')) {
    $errors['total'] = "Invalid Input should be number";
  }


  # Check if there are any errors . . .
  if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;
  } else{
    // code . . . 


    $sql4 = "UPDATE purchases_invoices  SET vendor_id= $vendor_id , product_id =$product_id , qunty = $qunty ,total_price=$total,payment_status='$payment',created_at=$created_at,user_id=$user_id WHERE id = $id";
        $op2  = DoQuery($sql4);

        if ($op2) {
            $message = ['success' => 'Invoice Editing Successfully'];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
            exit(); // stop the script

        } else {
            $message = ['error' => 'Error Editint Invoice  , Try Again '];
            $_SESSION['Message'] = $message;
        }
    }

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
      Message('Purchase/Edit');
      ?>
    </ol>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']). '?id=' . $InvoiceData['id']; ?>" method="post" >

      <div class="form-group">
        <label for="exampleInputPassword">Choose the Vendor</label>
        <select class="form-control" required name="vendor_id" >

          <?php
          while ($data4 = mysqli_fetch_assoc($vendorObj)) {
          ?>

            <option value="<?php echo $data4['id'];$_SESSION['vendor_id']=$data4['id'];$v= $_SESSION['vendor_id'];?>" <?php if ($data4['id'] == $InvoiceData['vendor_id']) {
                                                                        echo 'selected';
                                                                    }  ?>> <?php echo $data4['v_name'];   ?></option>
          <?php } 

         
         
          ?>

        </select>
      </div>



      <div class="form-group"  >
        <label for="exampleInputPassword">Choose Product</label>
        <select class="form-control" required name="product_id" >

        <?php 
         $sql5 = "select * from products where vendor_id=$v";
         $producObj  = DoQuery($sql5);
       
            while ($data7= mysqli_fetch_assoc($producObj)) {?> 
         
         <option value="<?php echo $data7['id'];?>" <?php if ($data7['id'] == $InvoiceData['product_id']) {
                                                                        echo 'selected';
                                                                    }  ?>> <?php echo $data7['p_name'];   ?></option>
          <?php } ?>
        </select>
      </div>

      
      <div class="form-group">
        <label for="exampleInputName">Quantity</label>
        <input type="number" onchange="GetTotals(this.value)"  class="form-control" required id="quntyid" name="qunty" placeholder="Enter the Quantity" value="<?php echo $InvoiceData['qunty']; ?>">
      </div>

      <div class="form-group"  id="txtHint">

        <label for="exampleInputName">Product Price is :</label>
        <!-- AJAX REQUEST HERE -->
      </div>

      <div class="form-group" >
        <label for="exampleInputName">Total</label>
        <input type="text" class="form-control" required name="total"   value="<?php echo $InvoiceData['total_price']?>">

      </div>

      <div class="form-group">
        <label for="exampleInputPassword">Payment Status:</label>
        <select class="form-control" required name="payment">

          <option value="Cash" <?php if ($InvoiceData['payment_status']=='Cash')echo 'selected';?> >Cash</option>
          <option value="Visa" <?php if ($InvoiceData['payment_status']=='Visa')echo 'selected';?>>Visa</option>

        </select>
      </div>


    <button type="submit" name="insert" class="btn btn-primary">Submit</button>
    </form>



</main>

<script>

// function getvendorproducts(str) {
//     if (str == "") {
//       document.getElementById("ventext").innerHTML = "";
//       return;
//     } else {
//       if (window.XMLHttpRequest) {
//         // code for IE7+, Firefox, Chrome, Opera, Safari
//         xmlhttp = new XMLHttpRequest();
//       } else {
//         // code for IE6, IE5
//         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//       }
//       xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//           document.getElementById("ventext").innerHTML = this.responseText;
//         }
//       };
//       xmlhttp.open("GET", "ajaxprpoduct.php?vendor=" + str, true);
//       xmlhttp.send();
//     }
//   }


//   function showPrice(str) {
//     if (str == "") {
//       document.getElementById("txtHint").innerHTML = "";
//       return;
//     } else {
//       if (window.XMLHttpRequest) {
//         // code for IE7+, Firefox, Chrome, Opera, Safari
//         xmlhttp = new XMLHttpRequest();
//       } else {
//         // code for IE6, IE5
//         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//       }
//       xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//           document.getElementById("txtHint").innerHTML = this.responseText;
//         }
//       };
//       xmlhttp.open("GET", "ajaxprice.php?q=" + str, true);
//       xmlhttp.send();
//     }
//   }


//   function GetTotals(str) {
//     if (str == "") {
//       document.getElementById("mytext").innerHTML = "";
//       return;
//     } else {
//       if (window.XMLHttpRequest) {
//         // code for IE7+, Firefox, Chrome, Opera, Safari
//         xmlhttp = new XMLHttpRequest();
//       } else {
//         // code for IE6, IE5
//         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//       }
//       xmlhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//           document.getElementById("mytext").innerHTML = this.responseText;
//         }
//       };
//       xmlhttp.open("GET", "ajaxptotal.php?qunty=" + str, true);
//       xmlhttp.send();
//     }
//   }

  
</script>

<?php
require '../layouts/footer.php';

?>
<?php
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkAdmin.php';

################################################################################################################
  // Logic . . .

  $sql2 = "select * from products";
  $producObj  = DoQuery($sql2);

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $product_id = Clean($_POST['product_id']);
    // $qunty =(int) Clean($_POST['qunty']);
    $qunty=$_SESSION['mytotal'];

    // $sql3 = "select qunty from products where product_id=$product_id";
    // $quantyObj  = DoQuery($sql3);
    // $dataqunty = mysqli_fetch_assoc($quantyObj);
    // $total_qunty=$dataqunty['qunty']+$qunty;
    # Validate Input . . . 
    $errors = [];

    if (!Validate($product_id, 'required')) {
      $errors['product_id'] = "Field Required";
    } 
    
    // if(!Validate($title,'required')){
    //     $errors['title'] = "Field Required";
    // }elseif(!Validate($title,'min',3)){
    //     $errors['title'] = "Length Must be >= 3 chars";
    // }



    # Check if there are any errors . . .
    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{
        // code . . . 

        $sql = "INSERT INTO stock (product_id,qunty) VALUES ($product_id,$qunty)";
        $op  = DoQuery($sql);
        $editproduct = "UPDATE products SET qunty =$qunty WHERE id = $product_id";
        $myop  = DoQuery($editproduct);
        
          if($op && $myop){
            $message = ['success' => 'Stock Product Added Successfully'];
          }else{
            $message = ['error' => 'Error Adding Stock Product'];
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
        <h1 class="mt-4">Dashboard / Stock</h1>
        <ol class="breadcrumb mb-4">
           
          <?php 
              Message('Stock/Create');
          ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >


        <div class="form-group"  >
        <label for="exampleInputPassword">Choose Product</label>
        <select class="form-control" required name="product_id" onchange="showPrice(this.value)">         
        <?php
          while ($data5 = mysqli_fetch_assoc($producObj)) {
          ?>

            <option value="<?php echo $data5['id']; ?>"><?php echo $data5['p_name'];   ?></option>

          <?php }  ?>

        </select>
      </div>

     
      <div class="form-group">
        <label for="exampleInputName">Add Quantity</label>
        <input type="number" onchange="GetTotals(this.value)"  class="form-control" required id="quntyid" name="qunty" placeholder="Enter the Quantity">
      </div>

      <div class="form-group"  id="txtHint">

        <label for="exampleInputName">Quantity already exists :</label>
        <!-- AJAX REQUEST HERE -->
      </div>

      <div class="form-group" id="mytext">
        <label for="exampleInputName">Total Quntity for stock :</label>
      </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


</main>

<script>$
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
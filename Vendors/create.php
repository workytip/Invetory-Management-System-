<?php
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
################################################################################################################
  // Logic . . .

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $name = Clean($_POST['name']);
    $contact = Clean($_POST['contact']);


    # Validate Input . . . 
    $errors = [];
    
    if(!Validate($name,'required')){
        $errors['name'] = "Field Required";
    }elseif(!Validate($name,'min',3)){
        $errors['name'] = "Length Must be >= 3 chars";
    }

    if(!Validate($contact,'required')){
      $errors['contact'] = "Field Required";
    }

    # Check if there are any errors . . .
    if(count($errors) > 0){
        $_SESSION['Message'] = $errors;
    }else{
        // code . . . 

        $sql = "INSERT INTO vendors (v_name,contact_info) VALUES ('$name','$contact')";
        $op  = DoQuery($sql);
        
          if($op){
            $message = ['success' => 'Vendor Added Successfully'];
          }else{
            $message = ['error' => 'Error Adding Vendor'];
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
        <h1 class="mt-4">Dashboard / Vendors</h1>
        <ol class="breadcrumb mb-4">
           
          <?php 
              Message('Vendors/Create');
          ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" >

            <div class="form-group">
                <label for="exampleInputName">Vendor Name : </label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" placeholder="Enter new client here">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Contact info : </label>
                <input type="email" class="form-control" required id="exampleInputName" aria-describedby="" name="contact" placeholder="Enter contact info">
            </div>


            <button type="submit" class="btn btn-info">Submit</button>
        </form>


</main>


<?php
require '../layouts/footer.php';
?>
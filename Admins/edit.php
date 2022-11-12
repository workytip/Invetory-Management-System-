<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';

// Allow user to Edit His Profile Only
if($_SESSION['user']['id']!=$_GET['id']){
 require '../helpers/checkAdmin.php';

}

################################################################################################################
// select roles . . . 
$sql = "select * from user_roles";
$rolesObj  = DoQuery($sql);
################################################################################################################

################################################################################################################
# Fetch Raw Data . . . 
$id = $_GET['id'];
$sql = "select * from user_details where id = $id ";
$op  = DoQuery($sql);
$AccountData = mysqli_fetch_assoc($op);
################################################################################################################


// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name       = Clean($_POST['name']);
    $email      = Clean($_POST['email']);
    //   $password   = Clean($_POST['password']);
    $role_id    = Clean($_POST['role_id']);
    $phone   = Clean($_POST['phone']);
    $created_at   = Clean($_POST['created_at']);
    $gender   = Clean($_POST['gender']);

    # Validate Input . . . 
    $errors = [];

    if (!Validate($name, 'required')) {
        $errors['Name'] = "Field Required";
    } elseif (!Validate($name, 'min', 3)) {
        $errors['Name'] = "Length Must be >= 3 chars";
    }


    if (!Validate($email, 'required')) {
        $errors['Email'] = "Field Required";
    } elseif (!Validate($email, 'email')) {
        $errors['Email'] = "Invalid Email";
    }

    if (!Validate($phone, 'required')) {
        $errors['phone'] = "Field Required";
      } elseif (!Validate($$phone, 'min', 7)) {
        $errors['phone'] = "Length Must be >= 7 digits";
      }

      if (!Validate($created_at, 'required')) {
        $errors['created_at'] = "Field Required";
      }  

      if (!Validate($gender, 'required')) {
        $errors['gender'] = "Field Required";
      }  

    if (!Validate($role_id, 'required')) {
        $errors['Role'] = "Field Required";
    } elseif (!Validate($role_id, 'int')) {
        $errors['Role'] = "Invalid Role";
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



        $sql = "UPDATE user_details  SET name = '$name' , email ='$email' , role_id = $role_id ,phone='$phone',created_at='$created_at',gender='$gender', image = '$imageName' WHERE id = $id";
        $op  = DoQuery($sql);

        if ($op) {
            $message = ['success' => 'Account Updated Successfully'];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
            exit(); // stop the script

        } else {
            $message = ['error' => 'Error Updating Account  , Try Again '];
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
        <h1 class="mt-4">Dashboard / Accounts</h1>
        <ol class="breadcrumb mb-4">

            <?php
            Message('Accounts/Edit');
            ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $AccountData['id']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" placeholder="Enter Name" value="<?php echo $AccountData['name']; ?>">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email" value="<?php echo $AccountData['email']; ?>">
            </div>


            <div class="form-group">
                <label for="exampleInputName">Phone</label>
                <input type="tel" class="form-control" required id="exampleInputName" aria-describedby="" name="phone" placeholder="Enter phone number" value="<?php echo $AccountData['phone']; ?>">
            </div>

            <div class="form-group">
                <label for="exampleInputName">Created At</label>
                <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" name="created_at"  value="<?php echo $AccountData['created_at']; ?>">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Gender</label>
                <select class="form-control" required name="gender">
                    <option value='male' <?php if($AccountData['gender']=='male') echo 'selected'?>>Male</option>
                    <option value='female' <?php if($AccountData['gender']=='female') echo 'selected'?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">Roles</label>
                <select class="form-control" required name="role_id">

                    <?php
                    while ($data = mysqli_fetch_assoc($rolesObj)) {
                    ?>

                        <option value="<?php echo $data['id']; ?>" <?php if ($data['id'] == $AccountData['role_id']) {
                                                                        echo 'selected';
                                                                    }  ?>><?php echo $data['role']; ?></option>

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
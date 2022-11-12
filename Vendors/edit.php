<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################################################################
# Fetch Raw Data . . . 
$id = $_GET['id'];
$sql = "select * from vendors where id = $id ";
$op  = DoQuery($sql);
$data = mysqli_fetch_assoc($op);
################################################################################################################


// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = Clean($_POST['name']);
    $contact = Clean($_POST['contact']);

    # Validate Input . . . 
    $errors = [];

    if (!Validate($name, 'required')) {
        $errors['name'] = "Field Required";
    } elseif (!Validate($name, 'min', 3)) {
        $errors['name'] = "Length Must be >= 3 chars";
    }

    if (!Validate($contact, 'required')) {
        $errors['contact'] = "Field Required";
    }


    # Check if there are any errors . . .
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        // code . . . 

        $sql = "UPDATE vendors SET v_name = '$name',contact_info='$contact' WHERE id = $id";
        $op  = DoQuery($sql);

        if ($op) {
            $message = ['success' => 'Vendor Updated Successfully'];
            $_SESSION['Message'] = $message;
            header("Location: index.php");
             exit(); // stop the script

        } else {
            $message = ['error' => 'Error Updating Vendor  , Try Again '];
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
        <h1 class="mt-4">Dashboard / Vendors</h1>
        <ol class="breadcrumb mb-4">

            <?php
            Message('Vendors/Edit');
            ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $data['id']; ?>" method="post" >

            <div class="form-group">
                <label for="exampleInputName">Name </label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" value="<?php echo $data['v_name']; ?>" >
            </div>

            <div class="form-group">
                <label for="exampleInputName">Contact info</label>
                <input type="email" class="form-control" required id="exampleInputName" aria-describedby="" name="contact" value="<?php echo $data['contact_info']; ?>" >
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


</main>


<?php
require '../layouts/footer.php';
?>
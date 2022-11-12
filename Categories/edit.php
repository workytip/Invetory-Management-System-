<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
################################################################################################################
# Fetch Raw Data . . . 
$id = $_GET['id'];
$sql = "select * from categories where id = $id ";
$op  = DoQuery($sql);
$data = mysqli_fetch_assoc($op);
################################################################################################################


// Logic . . .

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $title = Clean($_POST['title']);

    # Validate Input . . . 
    $errors = [];

    if (!Validate($title, 'required')) {
        $errors['title'] = "Field Required";
    } elseif (!Validate($title, 'min', 3)) {
        $errors['title'] = "Length Must be >= 3 chars";
    }



    # Check if there are any errors . . .
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {
        // code . . . 

        $sql = "UPDATE categories SET cat_name = '$title' WHERE id = $id";
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
        <h1 class="mt-4">Dashboard / Categories</h1>
        <ol class="breadcrumb mb-4">

            <?php
            Message('Categories/Edit');
            ?>

        </ol>



        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $data['id']; ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" value="<?php echo $data['cat_name']; ?>" placeholder="Enter Title">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


</main>


<?php
require '../layouts/footer.php';
?>
<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';
require '../helpers/checkAdmin.php';

#####################################################################################################################
$sql = "select user_details.*,user_roles.role from user_details inner join user_roles on user_details.role_id = user_roles.id";
$op  = DoQuery($sql);

################################################################################################################
require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';
?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Accounts</h1>
        <ol class="breadcrumb mb-4">
            <?php
            Message('Accounts/Display');
            ?>
        </ol>


        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Accounts DataTable
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>status</th>
                                <th>gender</th>
                                <th>created at</th>
                                <th>Image</th>
                                <th>Role</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone number</th>
                                <th>status</th>
                                <th>gender</th>
                                <th>created at</th>
                                <th>Image</th>
                                <th>Role</th>
                                <th>Edit</th>
                                <th>Remove</th>
                            </tr>
                        </tfoot>
                        <tbody>

                            <?php
                            # Fetch Data & display . . . 
                            while ($data = mysqli_fetch_assoc($op)) {
                            ?>

                                <tr>
                                    <td><?php echo $data['id'] ?></td>
                                    <td><?php echo $data['name'] ?></td>
                                    <td><?php echo $data['email'] ?></td>
                                    <td><?php echo $data['phone'] ?></td>
                                    <td><?php echo $data['status'] ?></td>
                                    <td><?php echo $data['gender'] ?></td>
                                    <td><?php echo $data['created_at'] ?></td>
                                    <td> <img src="uploads/<?php echo $data['image'] ?>" width="80px" height="80px"></td>
                                    <td><?php echo $data['role'] ?></td>
                                    <td> <a href='edit.php?id=<?php echo $data['id'];  ?>' class='btn btn-info m-r-1em'>Edit</a> </td>
                                    <td> <a href='delete.php?id=<?php echo $data['id'] ?>' class='btn btn-danger m-r-1em'>Delete</a> </td>

                                </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require '../layouts/footer.php';
?>
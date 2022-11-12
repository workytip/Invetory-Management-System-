<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkAdmin.php';

 $id = $_GET['id']; 

 # Fetch Raw Data . . .
$sql = "select image from products where id = $id ";
$op  = DoQuery($sql);
$data = mysqli_fetch_assoc($op);
 
  if(RemoveFile($data['image'])){


 $sql = "delete from products where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Product Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting Product'];
    }
  }else{
    $message = ['error' => 'Error Deleting File Try Again '];
  }

    $_SESSION['Message'] = $message;

    header("Location: index.php");

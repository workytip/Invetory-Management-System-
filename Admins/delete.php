<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';

 $id = $_GET['id']; 

 # Fetch Raw Data . . .
$sql = "select image from user_details where id = $id ";
$op  = DoQuery($sql);
$data = mysqli_fetch_assoc($op);
 
  if(RemoveFile($data['image'])){


 $sql = "delete from user_details where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Account Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting Account'];
    }
  }else{
    $message = ['error' => 'Error Deleting File Try Again '];
  }

    $_SESSION['Message'] = $message;

    header("Location: index.php");

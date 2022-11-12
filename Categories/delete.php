<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkAdmin.php';


 $id = $_GET['id']; 

 $sql = "delete from categories where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Category Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting Category'];
    }

    $_SESSION['Message'] = $message;

    header("Location: index.php");

<?php 
  require '../helpers/dbConnection.php';
  require '../helpers/functions.php';
  require '../helpers/checkAdmin.php';

 $id = $_GET['id']; 

 # Fetch Raw Data . . .

 
  

 $sql = "delete from sales_invoices where id = $id";
    
 $op  = DoQuery($sql);

    if($op){
    $message = ['success' => 'Invoice Deleted Successfully'];
    }else{
    $message = ['error' => 'Error Deleting Invoice'];
    }
  

    $_SESSION['Message'] = $message;

    header("Location: index.php");

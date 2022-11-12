<?php
require '../helpers/dbConnection.php';

require '../helpers/functions.php';



?>

<?php
$v = intval($_GET['vendor']);
$id = $_GET['id'];

$sql5 = "select * from purchases_invoices where id = $id ";
$op  = DoQuery($sql5);
$InvoiceData = mysqli_fetch_assoc($op);

// $con = mysqli_connect('localhost','root', '', 'myimsdb', '3308');
$sql2 = "select * from products where vendor_id=$v";
$producObj  = DoQuery($sql2);
$_SESSION['producObj']=$producObj;



while ($data = mysqli_fetch_assoc($producObj)) {


 echo' <option value="'. $data['id'].'" '.(($data['id']==$InvoiceData['product_id']) ?'selected="selected"':"").'>'. $data['p_name'].'</option>';
  
   }

?>



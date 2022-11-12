<?php
require '../helpers/dbConnection.php';

require '../helpers/functions.php';



?>

<?php
$q = intval($_GET['q']);


// $con = mysqli_connect('localhost','root', '', 'myimsdb', '3308');
$sql = "select price from products where id=$q";

$result = mysqli_query($con,$sql);

$row = mysqli_fetch_array($result);


$_SESSION['c_price']=$row["price"];

echo '<input type="text" class="form-control"  required name="product_price" disabled  value="';echo $row["price"]. '$' ;echo'">';




?>



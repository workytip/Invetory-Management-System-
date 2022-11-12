<?php
require '../helpers/dbConnection.php';

require '../helpers/functions.php';



?>

<?php
$q = intval($_GET['q']);


// $con = mysqli_connect('localhost','root', '', 'myimsdb', '3308');
$sql = "select qunty from products where id=$q";

$result = mysqli_query($con,$sql);

$row = mysqli_fetch_array($result);


 $_SESSION['ex_qunty']=$row["qunty"];

echo '<input type="text" class="form-control"  required name="product_quunty" disabled  value="';echo $row["qunty"] ;echo'">';




?>



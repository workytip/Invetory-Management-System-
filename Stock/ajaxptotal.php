<?php
require '../helpers/dbConnection.php';

require '../helpers/functions.php';



?>

<?php
$qunty = intval($_GET['qunty']);

// function getTotal()
//   {
//     global $row;
//     $mytotal=(int)$_SESSION['qunty']*$row["price"];
//     $_SESSION['mytotal']=$mytotal;
//     return $mytotal;

//   }
//   $mytotals=$_SESSION['mytotal'];
$mytotals= $qunty+$_SESSION['ex_qunty'];
$_SESSION['mytotal']=$mytotals;

echo '<br> Total :';
echo '<input type="text" class="form-control" required name="total_q" disabled  value="';echo $mytotals;echo'">';



?>



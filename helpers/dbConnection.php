<?php
session_start();

$server   = "localhost";
$database = "myimsdb";
$username = "root";
$password = "";


try {
  $con = mysqli_connect($server, $username, $password, $database,'3308');

  if (!$con) {

    throw new Exception('Not Connected ' . mysqli_connect_error());
  }
} catch (Exception $e) {
  echo $e->getMessage();
}

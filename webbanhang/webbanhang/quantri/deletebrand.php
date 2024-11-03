<?php 

$delid = $_GET['id'];
require('../db/conn.php');
$sql_str = "DELETE FROM brands WHERE id = $delid";
mysqli_query($conn,$sql_str);

//trở về trang liệt kê brands
header("location: listbrands.php");
<?php 

$delid = $_GET['id'];
require('../db/conn.php');
$sql_str = "DELETE FROM categories WHERE id = $delid";
mysqli_query($conn,$sql_str);

//trở về trang liệt kê brands
header("location: listcats.php");
<?php 

$delid = $_GET['id'];
require('../db/conn.php');

$sql1 = "SELECT images FROM products WHERE id = $delid";
$rs = mysqli_query($conn,$sql1);
$row = mysqli_fetch_assoc($rs);

//danh sách các ảnh
$imgages_arr = explode("," ,$row['images']);
//xóa ảnh
foreach($imgages_arr as $img){
    unlink($img);
}

$sql_str = "DELETE FROM products WHERE id = $delid";
mysqli_query($conn,$sql_str);

//trở về trang liệt kê brands
header("location: listsanpham.php");
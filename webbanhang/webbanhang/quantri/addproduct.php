<?php 

require('../db/conn.php');
    //lấy dữ liệu từ form
    $name = $_POST['name'];
    //tạo slug tự động theo tên
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $summary = $_POST['summary'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    $disscounted_price = $_POST['disscounted_price'];
    $danhmuc = $_POST['danhmuc'];
    $thuonghieu = $_POST['thuonghieu'];
    //lấy ảnh
    $countfiles = count($_FILES['anhs']['name']);
    $imgs = '';

    for ($i=0;$i<$countfiles;$i++) {
        $filename = $_FILES['anhs']['name'][$i];
        ## Location
        $location = "uploads/".$filename;
        //pathinfo ( string $path [, int $options = PATHINFO_DIRNAME | PATHINFO_BASENAME
        $extension = pathinfo($location, PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        ## File upload allowed extensions
        $valid_extensions = array("jpg", "jpeg","png");
        $response = 0;
        ## Check file extension
        if(in_array (strtolower($extension), $valid_extensions)) {

            //them vao csdl
            ## Upload file
            //$_FILES['file']['tmp_name']: $_FILES['file']['tmp_name']
            if (move_uploaded_file($_FILES['anhs']['tmp_name'][$i], $location)){
                $imgs .= $location .";";
                
            }
        }
    }
    $imgs = substr($imgs,0,-1);//loại bỏ dấu ; ở cuối


    
    $sql_str = "INSERT INTO `products` (`id`, `name`, `slug`, `description`, `summary`, `stock`, `price`,
     `disscounted_price`, `images`, `category_id`, `brand_id`, `status`, `created_at`, `updated_at`) VALUES 
     (NULL, '$name', '$slug', '$description', '$summary', $stock, $price, $disscounted_price, 
     '$imgs', $danhmuc, $thuonghieu, 'Active', NULL, NULL)";
    
    //thuc thi cau lenh
    mysqli_query($conn,$sql_str);
    
    //tro ve trang
    header("location: listsanpham.php");
?>
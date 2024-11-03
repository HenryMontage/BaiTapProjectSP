<?php 
    
    //require('includes/sidebar.php');
    
    //lay id can edit
    $id = $_GET['id'];
    require('../db/conn.php');

    $sql_str = "SELECT 
                products.id as pid, products.name as pname, summary, description, disscounted_price, price, stock,
                images, categories.name as cname,
                brands.name as bname, products.status as pstatus
                FROM products, categories, brands 
                WHERE products.category_id = categories.id and products.brand_id = brands.id and products.id = $id";
    $res = mysqli_query($conn,$sql_str);

    $product = mysqli_fetch_assoc($res);
    if(isset($_POST['btnUpdate'])){
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

        //nếu chọn ảnh mới, thì xóa ảnh cũ
        if(!empty($_FILES['anhs']['name'][0])){
            $arrstr = explode(";",$product['images']);
                foreach($arrstr as $img){
                    unlink($img);
                }
                

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
                $sql_str = "UPDATE `products` SET 
                `name` = '$name', 
                `slug` = '$slug', 
                `description` = '$description', 
                `summary` = '$summary', 
                `stock` = $stock, 
                `price` = $price, 
                `disscounted_price` = $disscounted_price, 
                `images` = '$imgs', 
                `category_id` = $danhmuc, 
                `brand_id` = $thuonghieu 
                WHERE `id` = $id";          
                
        }
        else{
            $sql_str = "UPDATE `products` SET 
            `name` = '$name', 
            `slug` = '$slug', 
            `description` = '$description', 
            `summary` = '$summary', 
            `stock` = $stock, 
            `price` = $price, 
            `disscounted_price` = $disscounted_price, 
            `category_id` = $danhmuc, 
            `brand_id` = $thuonghieu 
            WHERE `id` = $id";          
            
        }

        //thuc thi cau lenh
        mysqli_query($conn,$sql_str); 
                
        //tro ve trang
        header("location: listsanpham.php");
    }
    else{      
        require('includes/header.php');
    
?>

<div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Cập Nhật Sản Phẩm</h1>
                        <hr>
                    </div>
                    <form class="user" method="post" action="#" enctype="multipart/form-data">
                    <div class="form-group">
                        <input style="border-radius: 6px;" type="text" class="form-control form-control-user" 
                            id="name" name="name" aria-describedby="emailHelp" 
                            placeholder="Tên sản phẩm"
                            value="<?php echo $product['pname']; ?>">
                    </div>
                    <div class="form-group">
                        <input class="custom-file-upload" type="file" class="form-control form-control-user" 
                            id="anhs" name="anhs[]" 
                            multiple>
                            Các ảnh hiện tại:
                        <?php 
                            $arrstr = explode(";",$product['images']);
                            foreach($arrstr as $img)
                                echo "<img src= '$img' height='100px'/>";
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-lable">Tóm tắt sản phẩm:</label>
                        <textarea name="summary" id="" class="form-control">
                            <?php echo $product['summary']; ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                    <label for="" class="form-lable">Mô tả sản phẩm:</label>
                        <textarea name="description" id="" class="form-control">
                        <?php echo $product['description']; ?>
                        </textarea>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-sm-0">
                        <input style="border-radius: 6px;" type="text" class="form-control form-control-user" 
                            id="stock" name="stock" aria-describedby="emailHelp" 
                            placeholder="Số lượng" value="<?php echo $product['stock']; ?>">
                        </div>

                        <div class="col-sm-4 mb-sm-0">
                        <input style="border-radius: 6px;" type="text" class="form-control form-control-user" 
                            id="price" name="price" aria-describedby="emailHelp" 
                            placeholder="Giá gốc" value="<?php echo $product['price']; ?>">
                        </div>

                        <div class="col-sm-4 mb-sm-0">
                        <input style="border-radius: 6px;" type="text" class="form-control form-control-user" 
                            id="disscounted_price" name="disscounted_price" aria-describedby="emailHelp" 
                            placeholder="Giá bán" value="<?php echo $product['disscounted_price']; ?>">
                        </div>
                    </div>
          
                    <div class="form-group">
                        <label class="form-label" for="">Danh mục:</label>
                        <select class="form-control" name="danhmuc" id="">
                        <option value="">Chọn danh mục</option>
                        <?php 
                            $sql_str = "SELECT * FROM categories order by name";
                            $result =  mysqli_query($conn,$sql_str);
                            while ($row = mysqli_fetch_assoc($result)){
                        ?>
                            <option value="<?php echo $row['id']; ?>"
                            <?php if($row['name'] == $product['cname']) echo "selected"; ?>
                            ><?php echo $row['name']; ?></option>
                        <?php } ?>  
                        </select>
                    </div>
                    <div class="form-group">
                    <label class="form-label" for="">Thương hiệu:</label>
                        <select class="form-control" name="thuonghieu" id="">
                            <option value="">Chọn thương hiệu</option>
                        <?php 
                            $sql_str = "SELECT * FROM brands order by name";
                            $result =  mysqli_query($conn,$sql_str);
                            while ($row = mysqli_fetch_assoc($result)){
                        ?>
                            <option value="<?php echo $row['id']; ?>"
                            <?php if($row['name'] == $product['bname']) echo "selected"; ?>
                            ><?php echo $row['name']; ?></option>
                        <?php } ?>  
                        </select>
                    </div>
                    <button class="btn btn-primary" name="btnUpdate">Cập nhật</button>

                    </form>
                    <hr>
                   
                </div>
            </div>
        </div>
    </div>
</div>

</div>


<?php 
    require('includes/footer.php');
}
?>


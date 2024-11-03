<?php 
    require('includes/header.php');
    //require('includes/sidebar.php');


    function anhdaidien($arrstr, $height){
        //tách chuỗi các ảnh ngăn cách bởi dấu ; thành mảng, lấy ảnh đầu
        $arrstr = explode(";",$arrstr);
        return "<img src= '$arrstr[0]' height='$height'/>";
    }
?>

<div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Sản Phẩm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>  
                    <th>Thương hiệu</th>   
                    <th>Status</th>
                    <th>Operation</th>                                              
                </tr>
            </thead>
                <tfoot>
                    <tr>
                    <th>Tên sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Danh mục</th>  
                    <th>Thương hiệu</th>   
                    <th>Status</th>
                    <th>Operation</th>                          
                    </tr>                     
                </tfoot>                   
            <tbody>
                <?php 
                    require('../db/conn.php');
                    $sql_str = "SELECT 
                    products.id as pid,
                    products.name as pname, images, categories.name as cname,brands.name as bname, products.status as pstatus
                    FROM products, categories, brands 
                    WHERE products.category_id = categories.id and products.brand_id = brands.id order by products.name";
                    $result =  mysqli_query($conn,$sql_str);
                    while ($row = mysqli_fetch_assoc($result)){
                ?>
       
                <tr>
                    <td><?php echo $row['pname']; ?></td>
                    <td><?php echo anhdaidien($row['images'],"100px"); ?></td>
                    <td><?php echo $row['cname']; ?></td>
                    <td><?php echo $row['bname']; ?></td>
                    <td><?php echo $row['pstatus']; ?></td>
                    <td>
                        <a href="editproducts.php?id=<?php echo $row['pid']; ?>" class="btn btn-warning">Edit</a>
                        <a href="deleteproducts.php?id=<?php echo $row['pid']; ?>" class="btn btn-danger" 
                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Delete</a>
                    </td>
                </tr>  

                <?php
                }
                ?>                 
            </tbody>
            </table>
        </div>
    </div>
    </div>

</div>



<?php 
    require('includes/footer.php');
?>






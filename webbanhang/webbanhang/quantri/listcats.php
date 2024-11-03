<?php 
    require('includes/header.php');
    //require('includes/sidebar.php');
?>

<div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh Mục Sản Phẩm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>  
                    <th>Operation</th>                                                
                </tr>
            </thead>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Operation</th>                     
                    </tr>                     
                </tfoot>                   
            <tbody>
                <?php 
                    require('../db/conn.php');
                    $sql_str = "SELECT * FROM categories order by name";
                    $result =  mysqli_query($conn,$sql_str);
                    while ($row = mysqli_fetch_assoc($result)){
                ?>
       
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['slug']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <a href="editcategories.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="deletecategory.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" 
                        onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?');">Delete</a>
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

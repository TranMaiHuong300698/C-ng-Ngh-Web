<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Danh Sách</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="content.css">
  </head>
  <body>
    <div class="wrapper">
      <?php include "include/header.php" ?>
      <?php include "include/menu.php" ?>

      <?php
        //kết nối vói database
        $connect = mysqli_connect("localhost", "root", "", "thuchanh");
        if(! $connect)  {
          echo "<p> class='required'>Kết nối không thành công!</p>";
         }
        else {
          mysqli_set_charset($connect,'utf8');
         }
      ?>
      <div class="content">
        <table class="table_list" border="1px" width="800px" >
          <tr height="30px">
            <th>Product_ID</th>
            <th>Product_Name</th>
            <th>Brand_ID</th>
            <th>Delete</th>
            <th>Edit</th>
          </tr>
          <?php
            $query = "SELECT * FROM product ";
            $result = mysqli_query($connect,$query)
              or die("Query {$query} \n <br/> MySQL error:".mysqli_error($connect));
            while ($product = mysqli_fetch_array($result,MYSQLI_ASSOC))  {
           ?>
          <tr height="50px">
            <td align="center"> <?php echo $product['product_id']; ?></td>
            <td align="center"> <?php echo $product['product_name'];?></td>
            <td align="center"> <?php echo $product['brand_id'];?></td>
            <td align="center"> <a onclick="return confirm('Bạn có chắc chắn muốn xóa?');" href="delete_product.php?id=<?php echo $product['product_id'];?>">Xóa</a> </td>
            <td align="center"> <a href="edit_product.php?id=<?php echo $product['product_id'];?>"> Sửa </a></td>
          </tr>
          <?php
          }
           ?>
        </table>
      </div>
      <?php include "include/footer.php" ?>
    </div>
  </body>
</html>

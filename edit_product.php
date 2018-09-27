<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="content.css">
    <?php ob_start(); ?>
    <style media="screen">
      .required{
        color: red;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <?php include "include/header.php" ?>
      <?php include "include/menu.php" ?>
      <div class="content">
            <?php
              //kết nối vói database
              $connect = mysqli_connect("localhost", "root", "", "thuchanh");
              if(! $connect)  {
                echo "<p class='required'>Kết nối không thành công!</p>";
              }
              else {
                mysqli_set_charset($connect,'utf8');
               }

              //kiểm tra ID có phải là int hay k?
              if (isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))  {
                $id = $_GET['id'];
              }
              else {
                header('Location : Poroduct_edit_delete.php.php');
                exit();
              }

              if($_SERVER['REQUEST_METHOD']=='POST')  {
                //kiểm tra lỗi khi nhập dữ liệu
                $errors = array();
                if(empty($_POST['product_id'])){
                  $errors[]='product_id';
                }
                else {
                  $product_id = $_POST['product_id'];
                }

                if(empty($_POST['product_name']))  {
                  $errors[] = 'product_name';
                 }
                else {
                  $brand_name[] = 'product_name';
                 }

                if(empty($_POST['brand_id']))  {
                  $errors[] = 'brand_id';
                }
                else {
                  $brand_name[] = 'brand_id';
                }

                $product_id = $_POST['product_id'];
                $product_name = $_POST['product_name'];
                $brand_id = $_POST['brand_id'];
                if(empty($errors)){
                  $query = "UPDATE product
                  SET product_id = '{$product_id}',  product_name='{$product_name}',brand_id = '{$brand_id}'WHERE product_id={$id} ";

                  $result = mysqli_query($connect, $query)
                      or die ("Quyery {$query} \n <br/> Mysqlerrors:" .mysqli_error($connect));

                  if (mysqli_affected_rows($connect)==1){
                    echo "<p style='color:green;'>Sửa thành công!</p>";
                  }
                  else {
                    echo "<p class='required'>Sửa không thành công!</p>";
                  }
                }
                else {
                  $message ="<p class='required'>Hãy nhập đủ thông tin!</p>";
                }
              }
              //đổ dữ liệu vào table
              $query_id = " SELECT product_id,product_name,brand_id FROM product WHERE product_id={$id}";
              $result_id = mysqli_query($connect,$query_id)
                    or die("Query {$query} \n <br/> MySQL error:".mysqli_error($connect));
              if(mysqli_num_rows($result_id)==1)  {
                list($product_id, $product_name,$brand_id)=mysqli_fetch_array($result_id,MYSQLI_NUM);
              }
              else {
                echo $message="<p class='required'>Prod_ID không tồn tại!</p>";
              }
             ?>
             <from name ="frmadd_product" method="POST">
               <?php
                  if (isset($message)) {
                    echo $message;
                  }
                ?>
            <form name="frmadd_product" method="POST">
              <div class="from-group">
                <h3 style='color:black;'>Sửa sản phẩm: <?php if(isset($product_id)){echo $product_id;} ?></h3>
                <label for="">Nhập Product_ID</label> <br>
                <input type="text" name="product_id" value="<?php if(isset($product_id)){echo $product_id;} ?>"class="form-control" placeholder="Product_id"><br>
                <?php
                  if(isset($errors) && in_array('product_id',$errors)){
                    echo "<p class='required'>Bạn chưa nhập Product_ID!</p>";  }
                 ?>
              </div>
              <div class="from-group">
                <label for="">Nhập Product_Name</label> <br>
                <input type="text" name="product_name" value="<?php if(isset($product_name)){echo $product_name;} ?>" class="form-control" placeholder="Product_name"><br>
                <?php
                  if(isset($errors) && in_array('product_name',$errors))  {
                    echo "<p class='required'> Bạn chưa nhập Product_Name!</p>";  }
                 ?>
              </div>
              <div class="from-group">
                <label for="">Nhập Brand_ID</label> <br>
                <input type="text" name="brand_id" value="<?php if(isset($brand_id)){echo $brand_id;} ?>" class="form-control" placeholder="Brand_ID"><br>
                <?php
                  if(isset($errors) && in_array('brand_id',$errors)){
                    echo "<p class='required'> Bạn chưa nhập Brand_ID!</p>";
                  }
                 ?>
              </div>
                <div class="from-group">
                  <input type="submit" name="submit" class="btn btn-primary" value="Sửa sản phẩm">
                </div>
            </form>
          </div>
        </div>
      <?php include "include/footer.php" ?>
    </div>
    <?php ob_flush(); ?>
  </body>
</html>

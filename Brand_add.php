<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="content.css">
    <style media="screen">
      .required{
        color: red;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <?php include "header.php" ?>

      <?php include "menu.php" ?>

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
              if($_SERVER['REQUEST_METHOD']=='POST'){
                //kiểm tra lỗi khi nhập dữ liệu
                $errors = array();
                if(empty($_POST['brand_id'])){
                  $errors[]='brand_id';
                }
                else {
                  $brand_id = $_POST['brand_id'];
                }

                if(empty($_POST['brand_name'])){
                  $errors[] = 'brand_name';
                }
                else {
                  $brand_name[] = 'brand_name';
                }

                $brand_id = $_POST['brand_id'];
                $brand_name = $_POST['brand_name'];

                if(empty($errors))  {
                  $query = "INSERT INTO brand(brand_id,brand_name)
                  VALUES($brand_id,'{$brand_name}')";
                  $result = mysqli_query($connect, $query)
                      or die ("Query {$query} \n <br/>
                      Mysqlerrors:" .mysqli_error($connect));
                  if (mysqli_affected_rows($connect)==1){
                    echo "<p style='color:green;'>Thêm mới thành công!</p>";
                  }
                  else {
                    echo "<p class='required'>Thêm mới không thành công!</p>";
                  }
                }
                else {
                  $message ="<p class='required'>Bạn hãy nhập đầy đủ thông tin!</p>";
                }
              }
             ?>
             <from name ="frmadd_brand" method="POST">
               <?php
                  if (isset($message)) {
                    echo $message;
                  }
                ?>
            <form name="frmadd_brand" method="POST">
              <div class="from-group">
                <h3 style='color:black;'>Thêm mới hãng sản phẩm</h3>
                <label for="">Nhập Brand_ID</label> <br>
                <input type="text" name="brand_id" value="<?php if(isset($_POST['brand_id'])){echo $_POST['brand_id'];} ?>"class="form-control" placeholder="Brand_id"><br>
                <?php
                  if(isset($errors) && in_array('brand_id',$errors))  {
                    echo "<p class='required'>Bạn chưa nhập Brand_ID!</p>";
                  }
                 ?>
              </div>
              <div class="from-group">
                <label for="">Nhập Brand_Name</label> <br>
                <input type="text" name="brand_name" <?php if(isset($_POST['brand_name'])){echo $_POST['brand_name'];} ?>class="form-control" placeholder="Brand_name">

                <?php
                  if(isset($errors) && in_array('brand-name',$errors)){
                    echo "<p class='required'>Bạn chưa nhập Brand_Name!</p>";
                  }
                 ?>
                </div>
                <div class="from-group">
                  <input type="submit" name="submit" class="btn btn-primary" value="Thêm mới">
                </div>
              </div>
            </from>
        </div>
      <?php include "footer.php" ?>
  </body>
</html>

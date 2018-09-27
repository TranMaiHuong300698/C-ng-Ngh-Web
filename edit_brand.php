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
              if(! $connect){
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
                header('Location : Brand_edit_delete.php');
                exit();
              }

              if($_SERVER['REQUEST_METHOD']=='POST')  {
                //kiểm tra lỗi khi nhập dữ liệu
                $errors = array();
                if(empty($_POST['brand_id']))  {
                  $errors[]='brand_id';
                }
                else {
                  $brand_id = $_POST['brand_id'];
                }

                if(empty($_POST['brand_name']))  {
                  $errors[] = 'brand_name';
                }
                else {
                  $brand_name[] = 'brand_name';
                }

                $brand_id = $_POST['brand_id'];
                $brand_name = $_POST['brand_name'];
                if(empty($errors))  {
                  $query = "UPDATE brand
                            SET brand_id = '{$brand_id}',
                                brand_name='{$brand_name}'
                            WHERE
                                brand_id={$id} ";

                  $result = mysqli_query($connect, $query)
                      or die ("Quyery {$query} \n <br/>
                      Mysqlerrors:" .mysqli_error($connect));

                  if (mysqli_affected_rows($connect)==1){
                    echo "<p style='color:green;'>Sửa thành công!</p>";
                  }
                  else {
                    echo "<p class='required'>Sửa không thành công!</p>";
                  }
                }
                else {
                  $message ="<p class='required'>Bạn hãy nhập đầy đủ thông tin!</p>";
                }
              }
              $query_id = " SELECT brand_id,brand_name FROM brand WHERE brand_id={$id}";
              $result_id = mysqli_query($connect,$query_id)
                    or die("Query {$query} \n <br/> MySQL error:".mysqli_error($connect));

                    //kiểm tra ID có tồn tại hay k?
              if(mysqli_num_rows($result_id)==1)  {
                list($brand_id, $brand_name)=mysqli_fetch_array($result_id,MYSQLI_NUM);
              }
              else {
                echo $message="<p class='required'>Brand_ID không tồn tại!</p>";
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
                <h3 style='color:black;'>Sửa sản phẩm: <?php if(isset($brand_id)){echo $brand_id;} ?></h3>
                <label for="">Brand_ID</label> <br>
                <input type="text" name="brand_id" value="<?php if(isset($brand_id)){echo $brand_id;} ?>"class="form-control" placeholder="Brand_id"><br>
                <?php
                  if(isset($errors) && in_array('brand_id',$errors)){
                    echo "<p class='required'>Bạn chưa nhập Brand_ID!</p>";
                  }
                 ?>
              </div>

              <div class="from-group">
                <label for="">Brand_Name</label> <br>
                <input type="text" name="brand_name" value="<?php if(isset($brand_name)){echo $brand_name;} ?>" class="form-control" placeholder="Brand_name">
                <?php
                  if(isset($errors) && in_array('brand-name',$errors)){
                    echo "<p class='required'> Bạn chưa nhập Brand_Name!</p>";
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

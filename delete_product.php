<?php
    $connect = mysqli_connect("localhost", "root", "", "thuchanh");
    if(! $connect){
      echo " Kết nối không thành công!";
    }
    else {
      mysqli_set_charset($connect,'utf8');
    }

    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT,array('min_range'=>1))){
      $id = $_GET['id'];
      $query = "DELETE FROM product WHERE product_id = {$id}";
      $result = mysqli_query($connect,$query)
        or die("Query {$query} \n <br/> MySQL error:".mysqli_error($connect));
      //khi xóa xong sẽ trở vê trang đầu
      header('Location: Product_edit_delete.php');
    }
    else {
      header('Location: Poroduct_edit_delete.php');
    }
?>

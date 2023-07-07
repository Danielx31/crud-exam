<?php
  $conn = new mysqli("localhost", "root", "", "exam");
  
  if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
  }

  $out = array('error' => false);

  $crud = 'read';

  if(isset($_GET['crud'])){
    $crud = $_GET['crud'];
  }


  if($crud == 'read'){
    $sql = "select * from products";
    $query = $conn->query($sql);
    $products = array();
 
    while($row = $query->fetch_array()){
        array_push($products, $row);
    }
 
    $out['products'] = $products;
  }

  if ($crud == 'create') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
  
    $sql = "INSERT INTO products (product_name, product_description, quantity, price, created_at, updated_at, status)
            VALUES ('$product_name', '$product_description', '$quantity', '$price', NOW(), NOW(), '1')";
  
    $query = $conn->query($sql);
  
    if ($query) {
      $out['message'] = "Product Added Successfully";
    } else {
      $out['error'] = true;
      $out['message'] = "Could not add product";
    }
  }

  if($crud == 'update'){
    $id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET 
        product_name = '$product_name',
        product_description = '$product_description',
        quantity = '$quantity',
        price = '$price',
        updated_at = NOW()
        WHERE id = '$id'";

    $query = $conn->query($sql);
    if ($query) {
      $out['message'] = "Product updated Successfully";
    } else {
      $out['error'] = true;
      $out['message'] = "Could not update product";
    }

  }

  if($crud == 'updateDisableStatus'){
    $id = $_POST['id'];

    $sql = "UPDATE products  
        status = '0'
        WHERE id = '$id'";

    $query = $conn->query($sql);
    if ($query) {
      $out['message'] = "Product updated Successfully";
    } else {
      $out['error'] = true;
      $out['message'] = "Could not update product";
    }

  }
  


$conn->close();
 
header("Content-type: application/json");
echo json_encode($out);
die();
?>
<?php 
require 'connect.php';

if (isset($_SESSION['login'])) {
  header('location:index.php');
  exit;
}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  if ($email == "" || $password == "") {
    echo "<script>alert('inputan tidak boleh ada yang kosong')</script>";
  } else {
    $emailCheck = $pdo->prepare("SELECT * FROM petugas WHERE email = :emailVal");
    $emailCheck->bindValue(':emailVal', $email);
    $emailCheck->execute();
    $emailCheck->fetchAll();
    $rowCount = $emailCheck->rowCount();
  
    if ($rowCount >= 1) {
      $user = $pdo->prepare("SELECT * FROM petugas WHERE email = :emailVal AND password = SHA2(:passwordVal, 256)");
      $user->bindValue(':emailVal', $email);
      $user->bindValue(':passwordVal', $password);
      $user->execute();
      $user->fetchAll();
      $rowCount = $user->rowCount();
    
      if ($rowCount >= 1) {
        $_SESSION['login'] = true;
        header('location: index.php');
        exit;
      } else {
        echo "<script>alert('password salah')</script>";
      }
    } else {
      echo "<script>alert('email tidak ditemukan')</script>";
    }
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <form method="post">
    <div>
      <label for="email">email</label>
      <input type="text" name="email">
    </div>
    <div>
      <label for="password">password</label>
      <input type="password" name="password">
    </div>
    <div>
      <input type="submit" name="submit" value="login">
    </div>
  </form>
</body>
</html>
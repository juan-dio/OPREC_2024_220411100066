<?php 
require 'connect.php';
if (!isset($_SESSION['login'])) {
  header('location:login.php');
  exit;
}

if (isset($_POST['submit'])) {
  $from = $_POST['from'];
  $to = $_POST['to'];

}

$rekapan = $pdo->prepare("SELECT * FROM rekapan INNER JOIN barang USING(kode_barang) INNER JOIN petugas USING(kode_petugas)");
$rekapan->execute();
$rekapanAll = $rekapan->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>
</head>
<body>
  <form action="">
    <div>
      <label for="from">Dari tahun</label>
      <input type="text" name="from">
    </div>
    <div>
      <label for="to">Sampai tahun</label>
      <input type="text" name="to">
    </div>
    <div>
      <input type="submit" name="submit" value="cari">
    </div>
  </form>
  <a href="logout.php">logout</a>


  <table border="1">
    <tr>
      <th>No</th>
      <th>Nama Petugas</th>
      <th>Nama Barang</th>
      <th>Tahun</th>
      <th>Total Pendapatan</th>
    </tr>
    <?php $i = 0; foreach($rekapanAll as $rekap): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= $rekap['nama_petugas'] ?></td>
      <td><?= $rekap['nama_barang'] ?></td>
      <td><?= $rekap['tahun'] ?></td>
      <td><?= $rekap['pendapatan'] ?></td>
    </tr>
    <?php endforeach; ?>
  </table>

</body>
</html>
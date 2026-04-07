<?php
include '../config.php';
include '../auth.php';

$data = mysqli_query($koneksi,"SELECT * FROM log_aktivitas ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Log Aktivitas</title>

<style>
body{
  background:linear-gradient(135deg,#1e3c72,#2a5298);
  font-family:sans-serif;
}

.wrapper{display:flex}
.content{flex:1;padding:30px}

.container{
  background:white;
  padding:25px;
  border-radius:10px;
}

table{
  width:100%;
  border-collapse:collapse;
}

th, td{
  padding:10px;
  border-bottom:1px solid #ddd;
  text-align:center;
}

th{
  background:#2a5298;
  color:white;
}
</style>
</head>

<body>

<div class="wrapper">

<?php include 'sidebar.php'; ?>

<div class="content">
  <div class="container">
    <h2>Log Aktivitas Admin</h2>

    <table>
      <tr>
        <th>No</th>
        <th>User</th>
        <th>Aktivitas</th>
        <th>Waktu</th>
      </tr>

      <?php $no=1; while($d=mysqli_fetch_assoc($data)){ ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['user'] ?></td>
        <td><?= $d['aktivitas'] ?></td>
        <td><?= $d['waktu'] ?></td>
      </tr>
      <?php } ?>

    </table>
  </div>
</div>

</div>

</body>
</html>
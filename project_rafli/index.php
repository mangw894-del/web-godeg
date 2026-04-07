<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perpustakaandeg | Perpustakaan Digital</title>

<style>
*{
  box-sizing:border-box;
  font-family:'Segoe UI',Tahoma,sans-serif;
}
body{
  margin:0;
  background:#f4f6f9;
  color:#333;
}

/* NAVBAR */
nav{
  background:#4e73df;
  padding:15px 30px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  color:#fff;
}
nav h1{margin:0;font-size:20px;}
nav a{
  color:#fff;
  text-decoration:none;
  margin-left:15px;
  font-weight:600;
}

/* HERO */
.hero{
  background:linear-gradient(120deg,#4e73df,#1cc88a);
  color:white;
  padding:80px 20px;
}
.hero-content{
  max-width:1100px;
  margin:auto;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:40px;
  align-items:center;
}
.hero h2{font-size:36px;margin-bottom:10px;}
.hero p{font-size:18px;line-height:1.6;}
.btn{
  display:inline-block;
  padding:12px 26px;
  border-radius:10px;
  font-weight:700;
  text-decoration:none;
  margin:5px;
}
.btn-primary{background:#fff;color:#4e73df;}
.btn-secondary{border:2px solid #fff;color:#fff;}

.hero-image{
  text-align:center;
}
.hero-image img{
  width:100%;
  max-width:420px;
  height:420px;
  object-fit:cover;
  object-position:center;
  border-radius:0;     
  box-shadow:none;     
  background:none;    
}

/* RESPONSIVE */
@media(max-width:768px){
  .hero-content{
    grid-template-columns:1fr;
    text-align:center;
  }
  .hero-image img{
    max-width:300px;
    height:300px;
  }
}

/* CONTENT */
.container{
  max-width:1100px;
  margin:auto;
  padding:60px 20px;
}
.section-title{
  text-align:center;
  margin-bottom:40px;
}
.cards{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
  gap:25px;
}
.card{
  background:#fff;
  padding:30px;
  border-radius:14px;
  box-shadow:0 10px 25px rgba(0,0,0,.08);
  text-align:center;
}

/* FOOTER */
footer{
  background:#1f2937;
  color:#ccc;
  padding:30px 20px;
  text-align:center;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav>
  <h1>Perpustakaandeg</h1>
  <div>
    <?php if(isset($_SESSION['login'])): ?>
      <a href="dashboard_member.php">Dashboard</a>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php endif; ?>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <div>
      <h2>Perpustakaan Digital Modern</h2>
      <p>
        Akses ribuan koleksi buku, kelola peminjaman,
        dan temukan ilmu kapan saja, di mana saja.
      </p>
      <a href="login.php" class="btn btn-primary">Login</a>
      <a href="register.php" class="btn btn-secondary">Daftar Gratis</a>
    </div>

    <div class="hero-image">
      <img src="uploads/bukudeg2.png" alt="buku digital">
    </div>
  </div>
</section>

<!-- LAYANAN -->
<div class="container">
  <div class="section-title">
    <h3>Layanan Kami</h3>
    <p>Sistem perpustakaan digital yang cepat, aman, dan mudah digunakan.</p>
  </div>

  <div class="cards">
    <div class="card">
      <h4>Koleksi Lengkap</h4>
      <p>Buku pelajaran, novel, jurnal, dan referensi.</p>
    </div>
    <div class="card">
      <h4>Member Online</h4>
      <p>Pendaftaran cepat dan mudah.</p>
    </div>
    <div class="card">
      <h4>Peminjaman Mudah</h4>
      <p>Proses otomatis dan rapi.</p>
    </div>
    <div class="card">
      <h4>Sistem Aman</h4>
      <p>Login aman dengan hak akses.</p>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <p>© <?php echo date('Y'); ?> Perpustakaandeg | All Rights Reserved</p>
</footer>

</body>
</html>

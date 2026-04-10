<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaandeg | Digital Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4e73df;
            --dark-navy: #1a1c2e;
            --text-gray: #718096;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

        body {
            background: #ffffff;
            color: var(--dark-navy);
            overflow-x: hidden;
        }

        /* NAVBAR ELEGAN */
        nav {
            background: rgba(26, 28, 46, 0.98);
            backdrop-filter: blur(10px);
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        nav h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        nav h1 span { color: var(--primary); }

        nav .nav-links a {
            color: #cbd5e0;
            text-decoration: none;
            margin-left: 25px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        nav .nav-links a:hover { color: #fff; }

        .btn-reg {
            background: var(--primary);
            padding: 8px 20px;
            border-radius: 8px;
            color: white !important;
        }

        /* HERO SECTION - SAMBUNG KE FOTO */
        .hero {
            background: #f8fafc;
            padding: 160px 8% 100px 8%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
        }

        .hero-text h2 {
            font-size: 44px;
            font-weight: 800;
            color: var(--dark-navy);
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .hero-text h2 span { color: var(--primary); }

        .hero-text p {
            font-size: 17px;
            color: var(--text-gray);
            line-height: 1.8;
            margin-bottom: 35px;
        }

        .btn-group { display: flex; gap: 15px; }

        .btn {
            padding: 14px 30px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            font-size: 15px;
        }

        .btn-dark {
            background: var(--dark-navy);
            color: white;
            box-shadow: 0 10px 20px rgba(26, 28, 46, 0.2);
        }

        .btn-dark:hover { transform: translateY(-3px); background: var(--primary); }

        .btn-outline {
            border: 2px solid var(--dark-navy);
            color: var(--dark-navy);
        }

        /* FOTO CHRONO SIGNAL DI SEBELAH KANAN */
        .hero-image {
            display: flex;
            justify-content: flex-end;
        }

        .hero-image img {
            width: 100%;
            max-width: 450px; /* Ukuran pas biar elegan */
            border-radius: 30px; /* Sudut melengkung halus */
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* FEATURE SECTION */
        .features {
            padding: 80px 8%;
            background: #fff;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h3 { font-size: 30px; color: var(--dark-navy); }
        .section-title p { color: var(--text-gray); margin-top: 10px; }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
        }

        .card {
            background: #fff;
            padding: 35px;
            border-radius: 20px;
            border: 1px solid #edf2f7;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            border-color: var(--primary);
        }

        .card .icon { font-size: 30px; margin-bottom: 15px; display: block; }

        /* FOOTER */
        footer {
            background: var(--dark-navy);
            padding: 60px 8% 30px 8%;
            color: #a0aec0;
            text-align: center;
        }

        footer h2 { color: white; margin-bottom: 10px; }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .hero { grid-template-columns: 1fr; text-align: center; padding-top: 140px; }
            .hero-image { justify-content: center; margin-top: 40px; }
            .btn-group { justify-content: center; }
            .hero-text h2 { font-size: 34px; }
        }
    </style>
</head>

<body>

<nav>
    <h1>E-PERPUS<span>DEG</span></h1>
    <div class="nav-links">
        <?php if(isset($_SESSION['login'])): ?>
            <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'admin/dashboard_admin.php' : 'member/dashboard_member.php'; ?>">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php" class="btn-reg">Register</a>
        <?php endif; ?>
    </div>
</nav>

<section class="hero">
    <div class="hero-text">
        <p style="color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 2px; font-size: 13px;">Digital Learning Hub</p>
        <h2>Perpustakaan Digital Sekolah: Pusat Literasi <span>Generasi Modern</span></h2>
        <p>Akses ribuan koleksi buku digital, kelola peminjaman dengan mudah, dan kembangkan wawasan Anda kapan saja, di mana saja melalui sistem terintegrasi.</p>
        
        <div class="btn-group">
            <a href="register.php" class="btn btn-dark">Mulai Membaca</a>
            <a href="#features" class="btn btn-outline">Pelajari Layanan</a>
        </div>
    </div>

    <div class="hero-image">
        <img src="uploads/Chrono Signal_ Time-travel team in action.jpg" alt="Chrono Signal Library">
    </div>
</section>

<section class="features" id="features">
    <div class="section-title">
        <h3>Layanan Pustaka Masa Kini</h3>
        <p>Fitur unggulan untuk mendukung ekosistem belajar digital.</p>
    </div>

    <div class="cards">
        <div class="card">
            <span class="icon">📚</span>
            <h4>Koleksi Lengkap</h4>
            <p>Berbagai macam literatur dan referensi belajar tersedia lengkap.</p>
        </div>
        <div class="card">
            <span class="icon">⚡</span>
            <h4>Proses Cepat</h4>
            <p>Peminjaman dan pengembalian buku diproses secara instan.</p>
        </div>
        <div class="card">
            <span class="icon">🛡️</span>
            <h4>Security</h4>
            <p>Data akun dan riwayat aktivitas Anda terjamin keamanannya.</p>
        </div>
        <div class="card">
            <span class="icon">📱</span>
            <h4>Mobile Ready</h4>
            <p>Akses perpustakaan dengan nyaman melalui perangkat apa saja.</p>
        </div>
    </div>
</section>

<footer>
    <h2>E-PERPUS<span>DEG</span></h2>
    <p>Inovasi literasi untuk sekolah masa depan.</p>
    <div style="margin: 30px 0; border-top: 1px solid rgba(255,255,255,0.05);"></div>
    <p style="font-size: 12px;">© <?php echo date('Y'); ?> Perpustakaandeg Team | School Library Project</p>
</footer>

</body>
</html>
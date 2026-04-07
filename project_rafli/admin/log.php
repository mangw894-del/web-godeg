<?php
function logAktivitas($koneksi, $user, $aktivitas){
    mysqli_query($koneksi, "
        INSERT INTO log_aktivitas (user, aktivitas)
        VALUES ('$user', '$aktivitas')
    ");
}
?>
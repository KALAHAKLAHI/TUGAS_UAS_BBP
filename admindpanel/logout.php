<?php
session_start();
session_unset();
session_destroy();
header('location: login.php');
exit(); // Pastikan untuk menambahkan exit() setelah header('location') untuk memastikan tidak ada kode berikutnya yang dieksekusi.
?>

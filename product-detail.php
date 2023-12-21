<?php
require 'buatjs/conection.php';

// Ganti 'nama' dengan 'name' untuk sesuai dengan parameter yang digunakan di URL
$name = htmlspecialchars($_GET['name']);
$queryProduct = mysqli_query($con, "SELECT * FROM product WHERE name='$name'");
$product = mysqli_fetch_array($queryProduct);

// Perbaikan pada kueri SQL untuk produk terkait
$category_id = $product['category_id'];
$productId = $product['id'];

$queryProductTerkait = mysqli_query($con, "SELECT * FROM product WHERE category_id = '$category_id' AND id <> '$productId' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Ikan Hias | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php require "navbar.php"; ?>

<!-- Detail Produk -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 mb-5">
                <img src="image/<?php echo $product['photo'] ?>" class="w-100" alt="">
            </div>
            <div class="col-lg-6 offset-lg-1">
                <h1><?php echo $product['name'] ?></h1>
                <p><?php echo $product['detail'] ?></p>

                <!-- Menampilkan harga lama yang dicoret jika ada diskon -->
                <?php if (!empty($product['discount_percentage'])) { ?>
                    <p class="text-muted text-harga-coret">Rp <del><?php echo $product['price']; ?></del></p>
                <?php } ?>

                <!-- Menampilkan harga setelah diskon -->
                <p class="text-harga">Rp <?php echo $product['price'] - ($product['price'] * ($product['discount_percentage'] / 100)); ?></p>

                <p class="fs-5">
                    Status Ketersediaan : <strong><?php echo $product['stock_availability'] ?></strong>
                </p>

                <!-- Menampilkan informasi diskon jika ada -->
                <?php if (!empty($product['discount_percentage'])) { ?>
                    <p class="text-diskon">Diskon: <?php echo $product['discount_percentage']; ?>%</p>
                <?php } ?>

                <!-- "Beli" button with WhatsApp link -->
                <a href="https://wa.me/123456789?text=Saya%20ingin%20membeli%20<?php echo $product['name']; ?>" class="btn warna2 text-white mb-2">Beli via WhatsApp</a>
            </div>
        </div>
    </div>
</div>

<!-- Produk Terkait -->
<div class="container-fluid py-5 warna3">
    <div class="container">
        <h2 class="text-center text-white mb-5">Produk Terkait</h2>

        <div class="row">
            <?php while ($data = mysqli_fetch_array($queryProductTerkait)) { ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="product-detail.php?name=<?php echo $data['name']; ?>">
                        <img src="image/<?php echo $data['photo']; ?>" class="img-fluid img-thumbnail product-terkait-image" alt="">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php require "foter.php"; ?>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>

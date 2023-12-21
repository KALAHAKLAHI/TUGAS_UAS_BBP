<?php
require 'buatjs/conection.php';

$queryCategory = mysqli_query($con, "SELECT * FROM category");

// get produk name
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $queryProduct = mysqli_query($con, "SELECT *, (price - (price * (discount_percentage / 100))) AS price_after_discount FROM product WHERE name LIKE '%$keyword%'");
}
// get produk kategori
else if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $queryGetCategoryId = mysqli_query($con, "SELECT id FROM category WHERE name = '$category'");
    $categoryid = mysqli_fetch_array($queryGetCategoryId);
    $queryProduct = mysqli_query($con, "SELECT *, (price - (price * (discount_percentage / 100))) AS price_after_discount FROM product WHERE category_id='$categoryid[id]'");
}
// get produk default
else {
    $queryProduct = mysqli_query($con, "SELECT *, (price - (price * (discount_percentage / 100))) AS price_after_discount FROM product");
}

$countData = mysqli_num_rows($queryProduct);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Apa Saja di Jual | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require "navbar.php" ?>

    <!--banner-->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-warna1 text-start display-4 fw-bold">Produk</h1>
        </div>
    </div>

    <!--body-->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while ($category = mysqli_fetch_array($queryCategory)) { ?>
                        <a href="produk.php?category=<?php echo $category['name']; ?>">
                            <li class="list-group-item"><?php echo $category['name']; ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">

                    <?php
                    if ($countData < 1) {
                    ?>
                        <h4 class="text-center my-5">Produk yang Anda Cari Tidak Tersedia</h4>
                    <?php
                    }
                    ?>

                    <?php while ($product = mysqli_fetch_array($queryProduct)) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="image-box">
                                    <img src="image/<?php echo $product['photo']; ?>" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $product['name']; ?></h4>
                                    <p class="card-text text-truncate"><?php echo $product['detail']; ?></p>

                                    <!-- Menampilkan harga lama yang dicoret jika ada diskon -->
                                    <?php if (!empty($product['discount_percentage'])) { ?>
                                        <p class="card-text text-muted text-harga-coret">Rp <del><?php echo $product['price']; ?></del></p>
                                    <?php } ?>

                                    <!-- Menampilkan harga setelah diskon -->
                                    <p class="card-text text-harga">Rp <?php echo $product['price_after_discount']; ?></p>

                                    <!-- Menampilkan informasi diskon jika ada -->
                                    <?php if (!empty($product['discount_percentage'])) { ?>
                                        <p class="card-text text-diskon">Diskon: <?php echo $product['discount_percentage']; ?>%</p>
                                    <?php } ?>

                                    <a href="product-detail.php?name=<?php echo $product['name']; ?>" class="btn warna2 text-white mb-2">Detail</a>

                                    <!-- "Beli" button with WhatsApp link -->
                                    <a href="https://wa.me/123456789?text=Saya%20ingin%20membeli%20<?php echo $product['name']; ?>" class="btn warna2 text-white mb-2">Beli via WhatsApp</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Closing tags -->
    <?php require "foter.php"; ?>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>

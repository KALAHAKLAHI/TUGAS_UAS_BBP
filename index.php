<?php
require 'buatjs/conection.php';
$queryProduct = mysqli_query($con, "SELECT id, name, price, photo, detail, discount_percentage, (price - (price * (discount_percentage / 100))) AS price_after_discount FROM product LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Apa Saja di Jual | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php require "navbar.php"; ?>

    <!---banner-->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container">
            <h1>Toko Apa Saja di Jual</h1>
            <h3>Kami Menjual Apa Saja yang Ada</h3>
            <div class="col-md-7">
                <form method="get" action="produk.php">
                    <div class="input-group input-group-lg my-3">
                        <input type="text" class="form-control" placeholder="Nama Produk" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn warna2 text-white">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--- highlight-->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk Terlaris</h3>
            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="highlighted-kategori kategori-ikanterbang d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="javascript:void(0);" onclick="handleKeyword('pulau')">Pulau</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="highlighted-kategori kategori-dante d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="javascript:void(0);" onclick="handleKeyword('rumput camp nou')">Rumput Camp Nou</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="highlighted-kategori kategori-ikan d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="javascript:void(0);" onclick="handleKeyword('Siamese Fighting Fish')">Siamese Fighting Fish</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleKeyword(keyword) {
            window.location.href = 'produk.php?keyword=' + encodeURIComponent(keyword);
        }
    </script>

    <!--tentang kami-->
    <div class="container-fluid warna4 py-5">
        <div class="container text-center text-white">
            <h3>Tentang Kami</h3>
            <p class="fs5 mt-3">
                <!-- Your content here -->
            </p>
        </div>
    </div>

    <!-- Produk -->
    <div class="container mt-5">
        <div class="row">
           
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

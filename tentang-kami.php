<?php

class DetailProductPage
{
    public function displayPage()
    {
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Toko Apa Saja di Jual | Detail Produk</title>
                <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" href="fontawesome/css/all.min.css">
                <link rel="stylesheet" href="css/style.css">
            </head>
            <body>';

        require "navbar.php";

        echo '
            <!--banner-->
            <div class="container-fluid banner-2 d-flex align-items-center">
                <div class="container">
                    <h1 class="text-warna1 text-start display-4 fw-bold">Tentang Kami</h1>
                </div>
            </div>

            <div class="container-fluid py-5">
                <div class="container fs-5 text-center">
                    <p></p>
                    <p></p>
                </div>
            </div>';

        require "foter.php";

        echo '
            <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="fontawesome/js/all.min.js"></script>
        </body>
        </html>';
    }
}

// Inisialisasi tampilan halaman
$detailProductPage = new DetailProductPage();
$detailProductPage->displayPage();
?>

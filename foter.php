<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .content-subscribe {
            background-color: black; /* Warna hitam untuk background */
            color: white; /* Warna teks putih untuk kontras */
            padding: 20px;
        }

        .content-subscribe .fab:hover {
            color: blue; /* Warna biru saat ikon dihover */
        }

        .footer {
            background-color: black; /* Warna hitam untuk background footer */
            color: white; /* Warna teks putih untuk kontras */
            padding: 10px 0;
        }
    </style>
    <!-- Tambahan meta tag atau tag lainnya jika diperlukan -->
</head>
<body>

<?php
class SocialMediaLinks {
    private $links;

    public function __construct(array $links) {
        $this->links = $links;
    }

    public function render() {
        echo '<div class="container-fluid py-5 content-subscribe">';
        echo '<div class="container">';
        echo '<h5 class="text-center mb-4">Kunjungi Kami</h5>';
        echo '<div class="row justify-content-center">';
        
        foreach ($this->links as $link) {
            echo '<div class="col-sm-1 d-flex justify-content-center mb-2">';
            echo '<a href="' . $link['url'] . '" target="_blank"><i class="' . $link['icon'] . ' fs-2"></i></a>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

class Footer {
    private $copyright;
    private $createdBy;

    public function __construct($copyright, $createdBy) {
        $this->copyright = $copyright;
        $this->createdBy = $createdBy;
    }

    public function render() {
        echo '<div class="container-fluid py-3 footer">';
        echo '<div class="container d-flex justify-content-between">';
        echo '<label>&copy;' . $this->copyright . '</label>';
        echo '<label>Created by ' . $this->createdBy . '</label>';
        echo '</div>';
        echo '</div>';
    }
}

// Social Media Links Data
$socialMediaLinksData = [
    ['url' => 'http://facebook.com', 'icon' => 'fab fa-facebook'],
    ['url' => 'http://instagram.com', 'icon' => 'fab fa-instagram'],
    ['url' => 'http://twitter.com', 'icon' => 'fab fa-twitter'],
];

// Create Social Media Links Object
$socialMediaLinks = new SocialMediaLinks($socialMediaLinksData);

// Create Footer Object
$footer = new Footer('2023 Toko Apa Saja di Jual', 'TIM 14');

// Render Social Media Links
$socialMediaLinks->render();

// Render Footer
$footer->render();
?>

</body>
</html>

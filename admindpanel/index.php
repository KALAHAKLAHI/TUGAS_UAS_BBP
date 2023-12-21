<?php
class Database
{
    private $con;
    
// Constructor

    public function __construct()
    {
        require __DIR__ . "/../buatjs/conection.php";
        $this->con = $con;
    }

    public function query($sql)
    {
        return mysqli_query($this->con, $sql);
    }

    public function numRows($result)
    {
        return mysqli_num_rows($result);
    }
}

class Home
{
    private $db;
    private $jumlahCategory;
    private $jumlahProduct;

// Constructor

    public function __construct(Database $db)
    {
        require "session.php";
        $this->db = $db;
        $this->jumlahCategory = $this->getCategoryCount();
        $this->jumlahProduct = $this->getProductCount();
    }

//

    public function getCategoryCount()
    {
        $queryCategory = $this->db->query("SELECT * FROM category");
        return $this->db->numRows($queryCategory);
    }

    public function getProductCount()
    {
        $queryProduct = $this->db->query("SELECT * FROM product");
        return $this->db->numRows($queryProduct);
    }

    public function render()
    {
        require "navbar.php";
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Home</title>
            <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
            <style>
              
    .kotak {
        border: solid;
    }

    .summary-kategori {
        background-color: #005f73;
        border-radius: 20px;
    
    }

    .summary-produk{
        background-color: #415a77;
        border-radius: 20px;
    }

    .no-decoration{
        text-decoration: none;
        

    }
    /* Tambahkan margin-bottom untuk menambah jarak di bawah teks */
    h2 {
        margin-bottom: 45px;
    }

    /* Sesuaikan gaya untuk posisi teks "Kategori" dan "4 Kategori" */
    .kategori-text {
        margin-right: 10px; /* Atur margin kanan */
    }

    .kategori-count {
        margin-right: 10px; /* Atur margin kanan */
    }
</style>
            </style>
        </head>
        <body>
            <div class="container mt-4">
                <nav arial-label="breadcrumb">
                             <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                    <i class="fa-solid fa-house-user me-2"></i>Home
                </li>
            </ol>
                </nav>
                <h2>Hallo <?php echo $_SESSION['username']; ?></h2>
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <div class="summary-kategori p-3">    
                                <div class="row">
                                    <div class="col-6">
                                        <i class="fa-solid fa-align-justify fa-7x text-black-40"></i>
                                    </div>
                                    <div class="col-6 text-white">
                                        <h3 class="fs-2">Kategori</h3>
                                        <p class="fs-4"><?php echo $this->jumlahCategory; ?> Kategori</p>
                                        <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <div class="summary-produk p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <i class="fa-solid fa-box fa-7x text-black-40"></i>
                                    </div>
                                    <div class="col-6 text-white">
                                        <h3 class="fs-2">Produk</h3>
                                        <p class="fs-4"><?php echo $this->jumlahProduct; ?> Produk</p>
                                        <p><a href="produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="../fontawesome/css/fontawesome.min.js"></script>
        </body>
        </html>
        <?php
    }
}

// Membuat instance Database dan Home
$database = new Database();
$home = new Home($database);
$home->render();
?>

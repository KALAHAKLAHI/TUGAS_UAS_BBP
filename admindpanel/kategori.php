<?php
require "session.php";
require __DIR__ . "/../buatjs/conection.php";

class CategoryManager {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function getAllCategories() {
        $queryCategory = mysqli_query($this->con, "SELECT * FROM category");
        return mysqli_fetch_all($queryCategory, MYSQLI_ASSOC);
    }

    public function addCategory($categoryName) {
        $categoryName = htmlspecialchars($categoryName);
        $queryExist = mysqli_query($this->con, "SELECT name FROM category WHERE name ='$categoryName'");
        $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);

        if ($jumlahDataKategoriBaru > 0) {
            return "Kategori Sudah Ada";
        } else {
            $querySimpan = mysqli_query($this->con, "INSERT INTO category (name) VALUE('$categoryName')");
            if ($querySimpan) {
                return "Data Kategori Berhasil Tersimpan";
            } else {
                return "Gagal menyimpan kategori";
            }
        }
    }

    public function displayMessage($message, $type = 'primary') {
        $colorClass = 'primary';
        switch ($type) {
            case 'success':
                $colorClass = 'success';
                break;
            case 'warning':
                $colorClass = 'warning';
                break;
            case 'danger':
                $colorClass = 'danger';
                break;
        }

        echo "<div class='alert alert-$colorClass mt-3' role='alert'>$message</div>";
    }

    public function displayCategories($categories) {
        echo "<div class='mt-3'>";
        echo "<h2>List Kategori</h2>";
        echo "<div class='table-responsive mt-5'>";
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>NO.</th>";
        echo "<th>Nama</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        if (empty($categories)) {
            echo "<tr>";
            echo "<td colspan='3' class='text-center'>Data Kategori Tidak Tersedia</td>";
            echo "</tr>";
        } else {
            $jumlah = 1;
            foreach ($categories as $data) {
                echo "<tr>";
                echo "<td>$jumlah</td>";
                echo "<td>{$data['name']}</td>";
                echo "<td><a href='kategori-detail.php?p={$data['id']}' class='btn btn-info'><i class='fas fa-search'></i></a></td>";
                echo "</tr>";
                $jumlah++;
            }
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    }
}

$categoryManager = new CategoryManager($con);

if (isset($_POST['simpan_category'])) {
    $result = $categoryManager->addCategory($_POST['category']);
    switch ($result) {
        case 'Kategori Sudah Ada':
            $categoryManager->displayMessage($result, 'warning');
            break;
        case 'Data Kategori Berhasil Tersimpan':
            $categoryManager->displayMessage($result, 'success');
            break;
        case 'Gagal menyimpan kategori':
            $categoryManager->displayMessage($result, 'danger');
            break;
        default:
            $categoryManager->displayMessage($result);
            break;
    }
}

$categories = $categoryManager->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    .my-6 {
        margin-top: rem;
        margin-bottom: 6rem;
    }

    .mt-3 {
        margin-top: 1rem;
    }

    .mt-5 {
        margin-top: 3rem;
    }

    .text-center {
        text-align: center;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
                        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
                        crossorigin="anonymous" referrerpolicy="no-referrer" />
                    <a href="../admindpanel" class="no-decoration text-muted">
                        <i class="fa-solid fa-house-user me-2"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
                        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
                        crossorigin="anonymous" referrerpolicy="no-referrer" />
                    Kategori
                </li>
            </ol>
        </nav>

        <div class="my-6 col-11 col-md-7">
            <h3>Tambah Kategori</h3>
            <form action="" method="post">
                <div>
                    <label for="category">Kategori</label>
                    <input type="text" id="category" name="category" placeholder="Masukkan Nama Kategori"
                        class="form-control">
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan_category">Simpan</button>
                </div>
            </form>
        </div>

        <div class="mt-3">
            <?php $categoryManager->displayCategories($categories); ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/css/fontawesome.min.css"></script>
</body>
</html>

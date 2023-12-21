<?php
require "session.php";
require __DIR__ . "/../buatjs/conection.php";

// Kelas Product
// Encapsulation
class Product
{
    protected $category_id;
    protected $name;
    protected $price;
    protected $photo;
    protected $detail;
    protected $stock_availability;

    public function __construct($category_id, $name, $price, $photo, $detail, $stock_availability)
    {
        $this->category_id = $category_id;
        $this->name = $name;
        $this->price = $price;
        $this->photo = $photo;
        $this->detail = $detail;
        $this->stock_availability = $stock_availability;
    }

    public function display()
    {
        echo "Nama: " . $this->name . "<br>";
        echo "Kategori: " . $this->category_id . "<br>";
        echo "Harga: " . $this->price . "<br>";
        echo "Ketersediaan Stok: " . $this->stock_availability . "<br>";
    }
}

// Kelas DiscountedProduct yang extends dari Product
// Inheritance
class DiscountedProduct extends Product
{
    protected $discount;

    public function __construct($category_id, $name, $price, $photo, $detail, $stock_availability, $discount)
    {
        parent::__construct($category_id, $name, $price, $photo, $detail, $stock_availability);
        $this->discount = $discount;
    }

    // Override method display dari parent class
    public function display()
    {
        parent::display(); // Panggil display dari parent class
        echo "Diskon: " . $this->discount . "%<br>";
        echo "Harga Setelah Diskon: " . $this->calculateDiscountedPrice() . "<br>";
    }

    // Metode baru untuk menghitung harga setelah diskon
    public function calculateDiscountedPrice()
    {
        $discountedAmount = $this->price * ($this->discount / 100);
        return $this->price - $discountedAmount;
    }
}

$query = mysqli_query($con, "SELECT a.*, b.name AS name_category FROM product a JOIN category b ON a.category_id=b.id");
$jumlahProduct = mysqli_num_rows($query);

$queryCategory = mysqli_query($con, "SELECT * FROM category");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
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
                    Produk
                </li>
            </ol>
        </nav>

        <!--tambah produk-->
        <div class="my-6 col-11 col-md-7">
            <h3>Tambah Produk</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="category">Kategori</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Pilih Satu</option>
                        <?php
                        while ($data = mysqli_fetch_array($queryCategory)) {
                            ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="price">Harga</label>
                    <input type="number" class="form-control" name="price" required>
                </div>
                <div>
                    <label for="photo">Foto</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="stock_availability">Ketersediaan Stok</label>
                    <select name="stock_availability" id="stock_availability" class="form-control">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>
                <div>
                    <label for="discount_percentage">Diskon Persen</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" min="0" max="100"
                        placeholder="Masukkan persentase diskon">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" name="save">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['save'])) {
                $name = htmlspecialchars($_POST['name']);
                $category = htmlspecialchars($_POST['category']);
                $price = htmlspecialchars($_POST['price']);
                $detail = htmlspecialchars($_POST['detail']);
                $stock_availability = htmlspecialchars($_POST['stock_availability']);
                $discount_percentage = isset($_POST['discount_percentage']) ? (int)$_POST['discount_percentage'] : 0;

                $target_dir = "../image/";
                $name_file = basename($_FILES["photo"]["name"]);
                $target_file = $target_dir . $name_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["photo"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if ($name == '' || $category == '' || $price == '') {
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama, Kategori, dan Harga Wajib Diisi
                    </div>
                    <?php
                } else {
                    if (isset($_FILES["photo"]) && $_FILES["photo"]["name"] != "") {
                        if ($image_size > 50000000) {
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File tidak boleh lebih dari 5 MB
                            </div>
                            <?php
                        } else {
                            if ($imageFileType != "jpg" && $imageFileType != 'png' && $imageFileType != 'gif') {
                                ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    File Wajib Bertipe JPG, PNG, atau GIF
                                </div>
                                <?php
                            } else {
                                move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir . $new_name);
                            }
                        }
                    }

                    // Membuat objek DiscountedProduct
                    $discountedProduct = new DiscountedProduct($category, $name, $price, $new_name, $detail, $stock_availability, $discount_percentage);

                    // Memanggil metode display pada objek DiscountedProduct
                    $discountedProduct->display();

                    // Query insert
                    $queryTambah = mysqli_query($con, "INSERT INTO product (category_id, name, price, photo, detail, stock_availability, discount_percentage) 
                        VALUES ('$category', '$name', '$price', '$new_name', '$detail', '$stock_availability', '$discount_percentage')");

                    if ($queryTambah) {
                        ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Produk berhasil tersimpan
                        </div>

                        <meta http-equiv="refresh" content="2; url=produk.php" />
                        <?php

                    } else {
                        echo mysqli_error($con);
                    }
                }
            }
            ?>
        </div>

        <div class="mt-3 mb-4">
            <h2>List Produk</h2>
            <div class="table-responsive mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NO.</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Kesediaan Stok</th>
                            <th>Diskon</th>
                            <th>Harga Akhir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahProduct == 0) {
                            ?>
                            <tr>
                                <td colspan="8" class="text-center">Data Produk Tidak Tersedia</td>
                            </tr>
                            <?php
                        } else {
                            $jumlah = 1;
                            while ($data = mysqli_fetch_array($query)) {
                                ?>
                                <tr>
                                    <td><?php echo $jumlah ?></td>
                                    <td><?php echo $data['name'] ?></td>
                                    <td><?php echo $data['name_category'] ?></td>
                                    <td><?php echo $data['price'] ?></td>
                                    <td><?php echo $data['stock_availability'] ?></td>
                                    <td><?php echo isset($data['discount_percentage']) ? $data['discount_percentage'] . "%" : "N/A"; ?></td>
                                    <td>
                                        <?php
                                        if (isset($data['discount_percentage'])) {
                                            $discountedAmount = $data['price'] * ($data['discount_percentage'] / 100);
                                            $discountedPrice = $data['price'] - $discountedAmount;
                                            echo $discountedPrice;
                                        } else {
                                            echo "N/A";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="product-detail.php?p=<?php echo $data['id']; ?>" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $jumlah++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/css/fontawesome.min.css"></script>
</body>

</html>

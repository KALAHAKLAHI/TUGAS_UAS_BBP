<?php

class Category
{
    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Product
{
    private $id;
    private $category;
    private $name;
    private $price;
    private $photo;
    private $detail;
    private $stockAvailability;
    private $discountPercentage;

    public function __construct($id, Category $category, $name, $price, $photo, $detail, $stockAvailability, $discountPercentage)
    {
        $this->id = $id;
        $this->category = $category;
        $this->name = $name;
        $this->price = $price;
        $this->photo = $photo;
        $this->detail = $detail;
        $this->stockAvailability = $stockAvailability;
        $this->discountPercentage = $discountPercentage;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getDetail()
    {
        return $this->detail;
    }

    public function getStockAvailability()
    {
        return $this->stockAvailability;
    }

    public function getDiscountPercentage()
    {
        return $this->discountPercentage;
    }

    public function calculateDiscountedPrice()
    {
        $discountedAmount = $this->price * ($this->discountPercentage / 100);
        return $this->price - $discountedAmount;
    }
}

class ProductManager
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getAllProducts()
    {
        $queryProduct = mysqli_query($this->con, "SELECT a.*, b.name AS name_category FROM product a JOIN category b ON a.category_id=b.id");
        $products = [];
        while ($productData = mysqli_fetch_array($queryProduct)) {
            $category = new Category($productData['category_id'], $productData['name_category']);
            $product = new Product(
                $productData['id'],
                $category,
                $productData['name'],
                $productData['price'],
                $productData['photo'],
                $productData['detail'],
                $productData['stock_availability'],
                $productData['discount_percentage']
            );
            $products[] = $product;
        }
        return $products;
    }

    public function getProductById($productId)
    {
        $queryProduct = mysqli_query($this->con, "SELECT a.*, b.name AS name_category FROM product a JOIN category b ON a.category_id=b.id WHERE a.id='$productId'");
        if ($productData = mysqli_fetch_array($queryProduct)) {
            $category = new Category($productData['category_id'], $productData['name_category']);
            return new Product(
                $productData['id'],
                $category,
                $productData['name'],
                $productData['price'],
                $productData['photo'],
                $productData['detail'],
                $productData['stock_availability'],
                $productData['discount_percentage']
            );
        }
        return null;
    }

    public function addProduct($name, $categoryId, $price, $photo, $detail, $stockAvailability, $discountPercentage = 0)
    {
        // Implementasi tambahan sesuai kebutuhan untuk menambahkan produk ke database.
        // ...

        // Contoh query untuk ilustrasi:
        $queryTambah = mysqli_query($this->con, "INSERT INTO product (category_id, name, price, photo, detail, stock_availability, discount_percentage) 
            VALUES ('$categoryId', '$name', '$price', '$photo', '$detail', '$stockAvailability', '$discountPercentage')");

        return $queryTambah;
    }
}

// Inisialisasi koneksi database
require "session.php";
require __DIR__ . "/../buatjs/conection.php";
$id = $_GET['p'];

$query = mysqli_query($con, "SELECT a.*, b.name AS name_category FROM product a JOIN category b ON a.category_id=b.id WHERE a.id='$id'");
$data = mysqli_fetch_array($query);

$queryCategory = mysqli_query($con, "SELECT * FROM category WHERE id!='$data[category_id]'");

function generateRandomString($length = 10) {
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
    <title>Produk Detail</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>

<style>
    form div {
        margin-bottom: 10px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2>Detail Produk</h2>
        <div class="col-12 col-md-6 mb-7">
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" value="<?php echo $data['name']; ?>" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="category">Kategori</label>
                    <select id="category" name="category" class="form-control" autocomplete="off" required>
                        <option value="<?php echo $data['category_id']; ?>"><?php echo $data['name_category']; ?></option>
                        <?php
                        while ($dataCategory = mysqli_fetch_array($queryCategory)) {
                            ?>
                            <option value="<?php echo $dataCategory['id']; ?>"><?php echo $dataCategory['name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" value="<?php echo $data['price']; ?>" name="price" required>
                </div>
                <div>
                    <label for="currentPhoto">Foto Produk Saat Ini ---</label>
                    <img src="../image/<?php echo $data['photo']; ?>" alt="" width="300px">
                </div>
                <div>
                    <label for="photo">Foto</label>
                    <input type="file" name="photo" id="photo" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                        <?php echo $data['detail']; ?>
                    </textarea>
                </div>
                <div>
                <div>
    <label for="stock_availability">Ketersediaan Stok</label>
    <select name="stock_availability" id="stock_availability" class="form-control">
        <option value="tersedia" <?php echo ($data['stock_availability'] == "tersedia") ? "selected" : ""; ?>>Tersedia</option>
        <option value="habis" <?php echo ($data['stock_availability'] == "habis") ? "selected" : ""; ?>>Habis</option>
    </select>
</div>
                        <?php
                        if ($data['stock_availability'] == "tersedia") {
                        ?>
                            <option value="habis">Habis</option>
                        <?php
                        } else {
                        ?>
                            <option value="tersedia">Tersedia</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="discount_percentage">Diskon Persen</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" min="0" max="100"
                        placeholder="Masukkan persentase diskon">
                </div>
                <div class="mb-5">
                    <button type="submit" class="btn btn-primary" name="save">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                </div>
            </form>

            <?php
            if (isset($_POST['save'])) {
                $name = htmlspecialchars($_POST['name']);
                $category = htmlspecialchars($_POST['category']);
                $price = htmlspecialchars($_POST['price']);
                $detail = htmlspecialchars($_POST['detail']);
                $stock_availability = htmlspecialchars($_POST['stock_availability']);

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
                    if ($name_file != '') {
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
                                $queryUpdate = mysqli_query($con, "UPDATE product SET photo='$new_name' WHERE id='$id'");
                            }
                        }
                    }

                    $queryUpdate = mysqli_query($con, "UPDATE product SET category_id='$category', name='$name', price ='$price' , detail = '$detail', stock_availability ='$stock_availability' WHERE id=$id");

                    if ($queryUpdate) {
                ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Produk Berhasil Diperbarui
                        </div>

                        <meta http-equiv="refresh" content="1; url=produk.php" />
                    <?php
                    } else {
                        echo mysqli_error($con);
                    }
                }
            }

            if (isset($_POST['hapus'])) {
                $queryHapus = mysqli_query($con, "DELETE FROM product WHERE id='$id'");

                if ($queryHapus) {
                    ?>
                    <div class="alert alert-success mt-3" role="alert">
                        Produk Berhasil Dihapus
                    </div>
                    <meta http-equiv="refresh" content="1; url=produk.php" />
            <?php
                }
            }
            ?>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

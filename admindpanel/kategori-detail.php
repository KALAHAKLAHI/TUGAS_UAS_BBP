<?php
require "session.php";
require __DIR__ . "/../buatjs/conection.php";

class CategoryDetail
{
    private $con;
    private $id;
    private $data;

    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $this->fetchData();
    }

    private function fetchData()
    {
        $query = mysqli_query($this->con, "SELECT * FROM category WHERE id='$this->id'");
        $this->data = mysqli_fetch_array($query);
    }

    public function render()
    {
        require "navbar.php";
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detail Kategori</title>
            <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        </head>
        <body> 
            <div class="container mt-5">
                <h2>Detail Kategori</h2>
                <div class="form-container">
                    <div class="col-12 col-md-6">
                        <form action="" method="post">
                            <div>
                                <label for="category">Kategori</label>
                                <input type="text" name="category" id="category" class="form-control" value="<?php echo $this->data['name']; ?>">
                            </div>

                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary" name="editBtn">Edit</button>
                                <button type="submit" class="btn btn-danger" name="deleteBtn">Delete</button>
                            </div>
                        </form>
                        <?php $this->handleFormSubmission(); ?>
                    </div>
                </div>
            </div>
            <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
    }

    private function handleFormSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['editBtn'])) {
                $this->handleEditForm();
            }

            if (isset($_POST['deleteBtn'])) {
                $this->handleDeleteForm();
            }
        }
    }

    private function handleEditForm()
    {
        $category = htmlspecialchars($_POST['category']);

        if ($this->data['name'] == $category) {
            header("refresh:1; url=kategori.php");
        } else {
            $query = mysqli_query($this->con, "SELECT * FROM category WHERE name='$category'");
            $jumlahData = mysqli_num_rows($query);

            if ($jumlahData > 0) {
                echo '<div class="alert alert-warning mt-3" role="alert">Kategori Sudah Ada</div>';
            } else {
                $querySimpan = mysqli_query($this->con, "UPDATE category SET name='$category' WHERE id='$this->id'");
                if ($querySimpan) {
                    echo '<div class="alert alert-primary mt-3" role="alert">Kategori Berhasil Diupdate</div>';
                    header("refresh:0; url=kategori.php");
                } else {
                    echo mysqli_error($this->con);
                }
            }
        }
    }

    private function handleDeleteForm()
    {
        $queryCheck = mysqli_query($this->con, "SELECT * FROM product WHERE category_id='$this->id'");
        $dataCount = mysqli_num_rows($queryCheck);

        if ($dataCount > 0) {
            echo '<div class="alert alert-warning mt-3" role="alert">Kategori Tidak Bisa Dihapus Karena Sudah Digunakan di Produk</div>';
            die();
        }

        $queryDelete = mysqli_query($this->con, "DELETE FROM category WHERE id='$this->id'");

        if ($queryDelete) {
            echo '<div class="alert alert-primary mt-3" role="alert">Kategori Berhasil Dihapus</div>';
            header("refresh:2; url=kategori.php");
        } else {
            echo mysqli_error($this->con);
        }
    }
}

$id = $_GET['p'] ?? null;

if (!$id) {
    echo "Invalid ID";
    echo "ID: " . $id;
    exit;
}

$categoryDetail = new CategoryDetail($con, $id);
$categoryDetail->render();
?>

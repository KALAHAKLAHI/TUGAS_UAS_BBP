<?php

session_start();
require __DIR__ . "/../buatjs/conection.php";

class UserAuthentication
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function authenticateUser($username, $password)
    {
        $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$username'");
        $countdata = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);

        if ($countdata > 0) {
            if (password_verify($password, $data['password'])) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['login'] = true;
                header('location: ../admindpanel');
                exit();
            } else {
                return "PASSWORD SALAH !";
            }
        } else {
            return "AKUN TIDAK TERSEDIA !";
        }
    }
}

$userAuth = new UserAuthentication($con);

if (isset($_POST['loginbtn'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $loginResult = $userAuth->authenticateUser($username, $password);

    if ($loginResult !== true) {
        echo '<div class="alert alert-warning" role="alert">' . $loginResult . '</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<style>
    .main {
        height: 100vh;
    }

    .login-box {
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 10px;
    }
</style>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div>
                    <button class="btn btn-success form-control mt-3" type="submit" name="loginbtn">LOGIN</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
require_once 'backend.php';
if (isset($_SESSION['id'])) {
    header('Location: todos.php');
    exit;
}

$db = new database();

if (isset($_POST['Login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new users($id = null, $username, $email = null, $password, $rpassword = null);
    $userController = new userController($db);
    $userController->login($user);
}



?>
<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" href="assets/img/icon/favicon.ico" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <div class="modal modal-sheet  d-block bg-dark p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Login</h1>
                    <a href="index.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>

                </div>

                <div class="modal-body p-5 pt-0">
                    <form class="" method="post">
                        <div class="form-floating mb-3">
                            <input name="username" type="text" class="form-control rounded-3" id="floatingInput" required>
                            <label for="floatingInput">Username or E-mail</label>
                        </div>


                        <div class="form-floating mb-3">
                            <input name="password" type="password" class="form-control rounded-3" id="floatingPassword" required>
                            <label for="floatingPassword">Password</label>
                        </div>




                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="Login" value="Login">Login</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>
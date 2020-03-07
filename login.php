<?php
require_once 'functions/functions.php';
my_session_start('secure_blogest');

$hello_msg = '';

if (isset($_SESSION['hello_msg'])) {
    $hello_msg = $_SESSION['hello_msg'];
}

if (isset($_POST['submit'])) {
    if ($_SESSION['csrf_token'] == $_POST['csrf_token']) {
        if (empty($_POST['email'])) {
            $err = "Please fill in your email";
        } elseif (empty($_POST['password'])) {
            $err = "Please fill in your password";
        } else {
            $email = strtolower(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

            if ($link = db_connect()) {
                $email = mysqli_real_escape_string($link, $email);
                $password = mysqli_real_escape_string($link, $password);

                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($link, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if (password_verify($password, $row['password'])) {
                        if ($row['approved'] == 1) {
                            $_SESSION['fname'] = $row['first_name'];
                            $_SESSION['lname'] = $row['last_name'];
                            $_SESSION['avatar'] = $row['avatar'];
                            $_SESSION['uid'] = $row['id'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
                            $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
                            if ($row['admin'] == 1) {
                                $_SESSION['admin'] = 'admin';
                            }
                            header('location: index.php');
                        } else {
                            $err = "Your account as not been approved yet";
                        }
                    } else {
                        $err = "Email or password are not valid";
                    }
                }
            } else {
                $err = "Something went wrong with server's DB, try again later";
            }
        }
    }
}

$token = sha1(rand(10000000, 50000000) . time());
$_SESSION['csrf_token'] = $token;
?>

<?php include_once 'templates/header.php'; ?>

<!-- main-content-area start -->
<div id="main-content" class="main-content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 aligncenter">
                <div class="log">
                    <h6 class="log-title">log in</h6>
                    <div class="log-content">
                        <form action="" method="post">
                            <input name="csrf_token" type="hidden" value="<?= htmlspecialchars(@$token); ?>">
                            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars(@$_POST['email']); ?>" required />
                            <br>
                            <input type="password" name="password" placeholder="Password" required />
                            <br>
                            <?php if (!empty($err)): ?>
                                <p class="alert alert-danger"><?= htmlspecialchars(@$err); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($hello_msg)): ?>
                                <p class="alert alert-info"><?= htmlspecialchars(@$hello_msg); ?></p>
                            <?php endif; ?>
                            <input type="submit" name="submit" value="log in" />
                        </form>
                        <br>
                        <p><a href="register.php">New account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main-content-area end -->

<?php include_once 'templates/footer.php'; ?>


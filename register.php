<?php
require_once 'functions/functions.php';
my_session_start('secure_blogest');

$err = '';

define('UPLOAD_MAX_SIZE', 1024 * 1024 * 20);
$ex = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];
$uploads_dir = 'img/avatars';

if (isset($_POST['submit'])) {
    if ($_SESSION['csrf_token'] == $_POST['csrf_token']) {
        if (empty($_POST['fname'])) {
            $err = "You must enter your first name";
        } elseif (empty($_POST['lname'])) {
            $err = "You must enter your last name";
        } elseif (empty($_POST['email'])) {
            $err = "You must enter your email";
        } elseif (empty($_POST['password'])) {
            $err = "You must enter a password";
        } else {
            $fname = ucwords(strtolower(trim(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING))));
            $lname = ucwords(strtolower(trim(filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING))));

            $email = strtolower(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

            if ($link = db_connect()) {
                $email = mysqli_real_escape_string($link, $email);
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = mysqli_query($link, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $err = "Email already exists, try again";
                } else {
                    $fname = mysqli_real_escape_string($link, $fname);
                    $lname = mysqli_real_escape_string($link, $lname);
                    $email = mysqli_real_escape_string($link, $email);
                    $password = mysqli_real_escape_string($link, $password);
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    if (!empty($_FILES['avatar']['name'])) {
                        if (is_uploaded_file($_FILES['avatar']['tmp_name'])) {
                            if ($_FILES['avatar']['size'] <= UPLOAD_MAX_SIZE && $_FILES['avatar']['error'] == 0) {
                                $file_info = pathinfo($_FILES['avatar']['name']);
                                $file_ex = strtolower($file_info['extension']);
                                $tmp_name = $_FILES['avatar']['tmp_name'];
                                $random_num = rand(10000000, 50000000);
                                $upload_name = $random_num . '-' . $_FILES['avatar']['name'];
                                if (in_array($file_ex, $ex)) {
                                    move_uploaded_file($tmp_name, "$uploads_dir/$upload_name");
                                    $avatar = "$uploads_dir/$upload_name";
                                }
                            } else {
                                $err = 'Please make sure you are uploading jpg/jpeg/png/bmp/gif file up to 20MB';
                            }
                        }
                    } else {
                        $avatar = "$uploads_dir/default_avatar.jpg";
                    }
                    $sql = "INSERT INTO users VALUES('', '$fname', '$lname', '$email', '$password', '0', '0', '$avatar')";
                    $result = mysqli_query($link, $sql);
                    if ($result && mysqli_affected_rows($link) > 0) {
                        $_SESSION['hello_msg'] = "Hello $fname $lname, Your account as been registered, admin will approve you shortlly";
                        header("location: login.php");
                    } else {
                        unlink($avatar);
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
                    <h6 class="log-title">register</h6>
                    <div class="log-content">
                        <form action="" method="post" enctype="multipart/form-data">
                            <input name="csrf_token" type="hidden" value="<?= htmlspecialchars(@$token); ?>">
                            <input type="text" name="fname" placeholder="First name" value="<?= htmlspecialchars(@$_POST['fname']); ?>" required />
                            <br>
                            <input type="text" name="lname" placeholder="Last name" value="<?= htmlspecialchars(@$_POST['lname']); ?>" required />
                            <br>
                            <label for="register-avatar">Upload your Avatar:<br><img class="avatar" src="img/avatars/default_avatar.jpg"/></label>
                            <input id="register-avatar" type="file" name="avatar">
                            <br>
                            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars(@$_POST['email']); ?>" required />
                            <br>
                            <input type="password" name="password" placeholder="Password" required />
                            <br>
                            <?php if (!empty($err)): ?>
                                <p class="alert alert-warning"><?= htmlspecialchars(@$err); ?></p>
                            <?php endif; ?>
                            <input type="submit" name="submit" value="register" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main-content-area end -->

<?php include_once 'templates/footer.php'; ?>


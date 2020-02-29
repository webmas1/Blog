<?php
require_once 'functions/functions.php';

my_session_start('secure_blogest');

if (!checkUser()) {
    header('location: login.php');
}

if ($_GET['user_id'] != $_SESSION['uid']) {
    header('location: index.php');
}

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
        } else {
            $fname = ucwords(strtolower(trim(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING))));
            $lname = ucwords(strtolower(trim(filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING))));
            $email = strtolower(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)));
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));

            if ($link = db_connect()) {
                $uid = $_SESSION['uid'];
                $fname = mysqli_real_escape_string($link, $fname);
                $lname = mysqli_real_escape_string($link, $lname);
                $email = mysqli_real_escape_string($link, $email);
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
                    $avatar = $_SESSION['avatar'];
                }
                $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email', avatar = '$avatar' WHERE id = '$uid'";
                if (!empty($password)) {
                    $password = mysqli_real_escape_string($link, $password);
                    $password = password_hash($password, PASSWORD_BCRYPT);
                    $sql = "UPDATE users SET first_name = '$fname', last_name = '$lname', email = '$email', password = '$password', avatar = '$avatar' WHERE id = '$uid'";
                }
                $result = mysqli_query($link, $sql);
                if ($result && mysqli_affected_rows($link) > 0) {
                    $sql = "SELECT * FROM users WHERE email = '$email'";
                    $result = mysqli_query($link, $sql);
                    if ($result && mysqli_affected_rows($link) > 0) {
                        $row = mysqli_fetch_assoc($result);
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
                        }
                    }
                    header("location: personal.php?user_id=$uid");
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
            <div class="col-md-12 col-sm-12">
                <div class="posts-area">
                    <h2 class="section-title"><?= htmlspecialchars(@$_SESSION['fname'] . ' ' . @$_SESSION['lname']); ?></h2>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 aligncenter">
                            <div class="personal-area">
                                <h6 class="log-title">personal info</h6>
                                <div class="personal-content">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input name="csrf_token" type="hidden" value="<?= htmlspecialchars(@$token); ?>">
                                        <label for="personal-avatar"><img class="avatar" src="<?= htmlspecialchars(@$_SESSION['avatar']); ?>"/></label>
                                        <input id="personal-avatar" type="file" name="avatar">
                                        <input id="personal-fname" type="text" name="fname" placeholder="First name" value="<?= htmlspecialchars(@$_SESSION['fname']); ?>" required />
                                        <br>
                                        <input id="personal-lname" type="text" name="lname" placeholder="Last name" value="<?= htmlspecialchars(@$_SESSION['lname']); ?>" required />
                                        <br>
                                        <input personal-email type="email" name="email" placeholder="Email" value="<?= htmlspecialchars(@$_SESSION['email']); ?>" required />
                                        <br>
                                        <input personal-password type="password" name="password" placeholder="New password" />
                                        <br>
                                        <?php if (!empty($err)): ?>
                                            <p class="alert alert-warning"><?= htmlspecialchars(@$err); ?></p>
                                        <?php endif; ?>
                                        <input type="submit" name="submit" value="update info" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-content-area end -->

    <?php include_once 'templates/footer.php'; ?>
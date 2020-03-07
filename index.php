<?php
require_once 'functions/functions.php';
my_session_start('secure_blogest');

if (!checkUser()) {
    header('location: login.php');
}

$err = '';
$post_msg = '';
$del_err = '';
$update_err = '';
$update_msg = '';



//-------DELETE POST--------//
if (isset($_SESSION['del_err'])) {
    $del_err = $_SESSION['del_err'];
    echo "<script>alert('$del_err');</script>";
    unset($_SESSION['del_err']);
}

//-------UPDATE POST--------//
if (isset($_SESSION['post_id'])) {
    if ($_SESSION['csrf_token'] == $_POST['csrf_token']) {
        $post_id = $_SESSION['post_id'];
        if (isset($_POST['update'])) {
            if (empty($_POST['edit_title'])) {
                $update_err = "Please give a title to your post";
            } elseif (empty($_POST['edit_content'])) {
                $update_err = "Please give some content to your post";
            } else {
                $title = trim(filter_input(INPUT_POST, 'edit_title', FILTER_SANITIZE_STRING));
                $content = trim(filter_input(INPUT_POST, 'edit_content', FILTER_SANITIZE_STRING));

                if ($link = db_connect()) {
                    $title = mysqli_real_escape_string($link, $title);
                    $content = mysqli_real_escape_string($link, $content);

                    $uid = $_SESSION['uid'];

                    if (is_numeric($post_id)) {

                        $post_id = mysqli_real_escape_string($link, $post_id);
                        if (isset($_SESSION['admin'])) {
                            $sql = "UPDATE posts SET title = '$title', content = '$content', updated = CURRENT_TIME() WHERE id = '$post_id'";
                        } else {
                            $sql = "UPDATE posts SET title = '$title', content = '$content', updated = CURRENT_TIME() WHERE id = '$post_id' AND uid = '$uid'";
                        }
                        $result = mysqli_query($link, $sql);

                        if ($result && mysqli_affected_rows($link) > 0) {
                            $update_msg = 'Post has been updated';
                            echo "<script>alert('$update_msg');</script>";
                            unset($_SESSION['post_id']);
                            $update_msg = '';
                        }
                    }
                }
            }
        } elseif (isset($_POST['cancel'])) {
            
            unset($_SESSION['post_id']);
        }
    }
}

//-------NEW POST--------//
if (isset($_POST['submit'])) {
    if ($_SESSION['csrf_token'] == $_POST['csrf_token']) {
        if (empty($_POST['title'])) {
            $err = "Please give a title to your post";
        } elseif (empty($_POST['content'])) {
            $err = "Please give some content to your post";
        } else {
            $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
            $content = trim(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING));

            if ($link = db_connect()) {
                $title = mysqli_real_escape_string($link, $title);
                $content = mysqli_real_escape_string($link, $content);
                $uid = $_SESSION['uid'];

                $sql = "INSERT INTO posts (id, uid, title, content, created, updated) VALUES ('', '$uid', '$title', '$content', CURRENT_TIME(), CURRENT_TIME());";
                $result = mysqli_query($link, $sql);

                if ($result && mysqli_affected_rows($link) > 0) {
                    $post_msg = "Your post has been posted";
                    $_POST['title'] = '';
                    $_POST['content'] = '';
                }
            }
        }
    }
}

//-------BRINGS ALL POSTS FROM DB--------//
if ($link = db_connect()) {
    $sql = "SELECT posts.*,users.first_name ,users.last_name, users.avatar FROM posts JOIN users on posts.uid = users.id ORDER BY posts.id DESC";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
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
            <div class="col-md-8 col-sm-12">
                <div class="posts-area">
                    <h2 class="section-title">posts</h2>
                    <div class="row">
                        <?php if (isset($data)): ?>
                            <?php foreach ($data as $post): ?>
                                <div id="post-id-<?= htmlspecialchars(@$post['id']); ?>" class="col-md-12 col-sm-12 post">
                                    <?php if (@$_SESSION['post_id'] == @$post['id']): ?>
                                        <div class="sidebar-content write-post update-post">
                                            <h6 class="widget-title">Update the post</h6>
                                            <div class="write-post-form">
                                                <form action="" method="post">
                                                    <input name="csrf_token" type="hidden" value="<?= htmlspecialchars($token); ?>">
                                                    <input type="text" name="edit_title" placeholder="Title" value="<?= htmlspecialchars(@$post['title']); ?>" required />
                                                    <textarea name="edit_content" placeholder="Your post" required oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'><?= htmlspecialchars(@$post['content']); ?></textarea>
                                                    <?php if (!empty($update_msg)): ?>
                                                        <p class="alert alert-success"><?= htmlspecialchars(@$update_msg); ?></p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($update_err)): ?>
                                                        <p class="alert alert-warning"><?= htmlspecialchars(@$update_err); ?></p>
                                                    <?php endif; ?>
                                                    <input type="submit" name="update" value="update" />
                                                </form>
                                                <form action="" method="post">
                                                    <input name="csrf_token" type="hidden" value="<?= htmlspecialchars($token); ?>">
                                                    <input type="submit" name="cancel" value="cancel" />
                                                </form>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="post-content">
                                            <?php if ($post['uid'] == $_SESSION['uid'] || isset($_SESSION['admin'])): ?>
                                                <a class="del-btn btn btn-sm text-danger" href="delete_post.php?post_id=<?= htmlspecialchars(@$post['id']); ?>" onclick="return del_alert()"><span class="far fa-trash-alt"></span></a>
                                                <a class="edit-btn btn btn-sm text-muted" href="edit_post.php?post_id=<?= htmlspecialchars(@$post['id']); ?>"><span class="far fa-edit"></span></a>
                                            <?php endif; ?>

                                            <h5><?= htmlspecialchars(@$post['title']); ?></h5>
                                            <p><?= htmlspecialchars(@$post['content']); ?></p>
                                            <p class="post-info">
                                                <img class="avatar" src="<?= htmlspecialchars(@$post['avatar']); ?>"/>
                                                <span class="author">by <?= htmlspecialchars(@$post['first_name']); ?> <?= htmlspecialchars(@$post['last_name']); ?></span><span class="created"><?= htmlspecialchars(@$post['created']); ?></span>
                                                <?php if ($post['updated'] != $post['created']): ?>
                                                    <small class="text-muted">( updated: <?= htmlspecialchars(@$post['updated']); ?> )</small>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    <?php unset($_SESSION['post_id']); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <!-- /.posts-area -->
                </div>
            </div>

            <!-- /.sidebar-area -->
            <div class="order-lg-last col-md-4 order-md-last col-md-offset-0 col-sm-8 col-sm-offset-2 order-first">
                <div class="sidebar-area fix">
                    <div class="single-sidebar-widget">
                        <h6 class="widget-title">Write new post</h6>
                        <div class="sidebar-content write-post">
                            <div class="write-post-form">
                                <form action="" method="post">
                                    <input name="csrf_token" type="hidden" value="<?= htmlspecialchars($token); ?>">
                                    <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars(@$_POST['title']); ?>" required />
                                    <textarea name="content" placeholder="Your post" required><?= htmlspecialchars(@$_POST['content']); ?></textarea>
                                    <?php if (!empty($post_msg)): ?>
                                        <p class="alert alert-success"><?= htmlspecialchars(@$post_msg); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($err)): ?>
                                        <p class="alert alert-warning"><?= htmlspecialchars(@$err); ?></p>
                                    <?php endif; ?>
                                    <input type="submit" name="submit" value="post" />
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
<?php
if (isset($_SESSION['post_id'])) {
    $post_id = $_SESSION['post_id'];
    echo "<script>$('html, body').animate({scrollTop: $('#post-id-$post_id').offset().top}, 0);</script>";
}
?>


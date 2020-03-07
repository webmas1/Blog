<?php
require_once 'functions/functions.php';
my_session_start('secure_blogest');

if (!checkAdmin()) {
    header('location: index.php');
}

if ($link = db_connect()) {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $users = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
}

if (isset($_GET['approve'])){
    $uid = $_GET['approve'];
    if ($link = db_connect()) {
        $sql = "UPDATE users SET approved=1 WHERE id=$uid";
        $result = mysqli_query($link, $sql);
    }
    header('location: admin.php');
}
?>

<?php include_once 'templates/header.php'; ?>

<div id="main-content" class="main-content-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="posts-area">
                    <h2 class="section-title">manage users</h2>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 aligncenter">
                            <?php if (isset($users)): ?>
                                <div class="table-responsive">
                                    <table class="table users-table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>First name</th>
                                                <th>Last name</th>
                                                <th>Email</th>
                                                <th>Approval</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                                <?php if ($user['admin'] == 0): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars(@$user['id']); ?></td>
                                                        <td><?= htmlspecialchars(@$user['first_name']); ?></td>
                                                        <td><?= htmlspecialchars(@$user['last_name']); ?></td>
                                                        <td><?= htmlspecialchars(@$user['email']); ?></td>
                                                        <td>
                                                            <?php if ($user['approved'] == 0): ?>
                                                                <a class="btn btn-success" href="admin.php?approve=<?= htmlspecialchars(@$user['id']); ?>">Aprrove now</a>
                                                            <?php elseif ($user['approved'] == 1): ?>
                                                                Approved
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- main-content-area end -->

<?php include_once 'templates/footer.php'; ?>


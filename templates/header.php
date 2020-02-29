<!DOCTYPE html>
<html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Blogest</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- favicon
                    ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

        <!-- Google Fonts
                    ============================================ -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>

        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
        
        <!-- Masonry
                    ============================================ -->
        <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script> 

        <!-- font-awesome CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

        <!-- owl.carousel CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">
        <link rel="stylesheet" href="css/owl.transitions.css">
        <!-- meanmenu CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/meanmenu.css">
        <!-- normalize CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/normalize.css">
        <!-- main CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/main.css">
        <!-- style CSS
                    ============================================ -->
        <link rel="stylesheet" href="style.css">
        <!-- responsive CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/responsive.css">
        <!-- modernizr JS
                    ============================================ -->
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        
        <script>
            function del_alert(url) {
            return confirm("Are you sure you want to delete the post?");
        }
        </script>
    </head>

    <body class="home-2">
        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->

        <!-- header-area start -->
        
        <header id="header" class="header-area">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-right fix">
                                <div class="header-links">
                                    <ul>
                                        <?php if ((isset($_SESSION['fname']) && isset($_SESSION['lname'])) || isset($_SESSION['admin'])): ?>
                                        <li>Welcome <a href="personal.php?user_id=<?= $_SESSION['uid'] ?>"><?= @$_SESSION['fname'] . ' ' . @$_SESSION['lname'] ?></a> </li>
                                            <?php if (isset($_SESSION['admin'])): ?>
                                            <li><a href="admin.php">Manage users</a></li>
                                            <?php endif; ?>
                                            <li><a href="logout.php">Log out</a></li>
                                        <?php else: ?>
                                            <li><a href="login.php">Log in</a></li>
                                            <li><a href="register.php">Register</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.header-top -->
            <div class="header-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="logo">
                                <a href="index.php"><img src="img/logo/logo.png" alt="Logo" /></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="main-menu">
                                <nav>
                                    <ul class="main-nav navbar-right">
                                        <li>
                                            <a href="index.php">Home</a>
                                        </li>
                                        <li>
                                            <a href="about.php">About us</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- /.main-menu -->
                        </div>
                    </div>
                </div>
                <!-- mobile-menu-area start -->
                <div class="mobile-menu-area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <nav id="dropdown">
                                    <ul>
                                        <li>
                                            <a href="index.php">Home</a>
                                        </li>
                                        <li>
                                            <a href="about.php">About us</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                
                <!-- mobile-menu-area end -->
            </div>
            <!-- /.header-bottom -->
        </header>
        <!-- header-area end -->

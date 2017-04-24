<?php
    //on demarre la session
    session_start();
    require_once ('lib/php/fonction.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="about.php">About</a>
                    </li>
                    <li>
                        <a href="services.php">Services</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <li class="active">
                        <a href="portfolio.php">Portfolio</a>
                    </li>
                    <?php

                    if (isset($_SESSION['id']))
                    {   
                        echo'
                            <li><a href="deconnection.php">Se deconnecter</a></li>
                            <li><a href="panier.php">Panier <b style="color:white;"><?php echo "({$cartItemCount})"; ?></b> </a></li>           
                            <li><a href="profil.php">Profil</a></li>';
                        if ($_SESSION['admin'] == 1)
                        {
                            echo'<li><a href="admin.php">Administrateur</a></li>';
                        }
                    }
                    else
                    {
                        echo'<li><a href="inscription.php">Inscription</a></li>
                        <li><a href="connection.php">Se connecter</a></li>';
                    }

                ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <small>Portfolio</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">Portfolio</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-6 img-portfolio">
                <a href="portfolio-item.html">
                    <a href="http://www.jeuxvideo.com/"><img class="img-responsive img-hover" src="img/jeuxvideo.png" width="700" height="400" alt=""></a>
                </a>
                <h3>
                    <a href="http://www.jeuxvideo.com/">Site de jeuxvideo.com</a>
                </h3>
            </div>
            <div class="col-md-6 img-portfolio">
                <a href="portfolio-item.php">
                    <a href="http://www.play3-live.com/"><img class="img-responsive img-hover" src="img/play3.png" width="700" height="400" alt=""></a>
                </a>
                <h3>
                    <a href="http://www.play3-live.com/">Site de play3-live.com</a>
                </h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-6 img-portfolio">
                <a href="portfolio-item.php">
                    <a href="http://www.anime-kun.net/"><img class="img-responsive img-hover" src="img/animekun.png" width="700" height="400" alt=""></a>
                </a>
                <h3>
                    <a href="http://www.anime-kun.net/">Site de anime-kun.net</a>
                </h3>
            </div>
            <div class="col-md-6 img-portfolio">
                <a href="portfolio-item.html">
                    <a href="http://www.mangaluxe.com/"><img class="img-responsive img-hover" src="img/mangaluxe.png" width="700" height="400" alt=""></a>
                </a>
                <h3>
                    <a href="http://www.mangaluxe.com/">Site de mangaluxe.com</a>
                </h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-6 img-portfolio">
                <a href="portfolio-item.html">
                    <a href="http://www.hitcombo.com/"><img class="img-responsive img-hover" src="img/hitcombo.png" width="700" height="400" alt=""></a>
                </a>
                <h3>
                    <a href="http://www.hitcombo.com/">Site de hitcombo.com</a>
                </h3>
            </div>
            <div class="col-md-6 img-portfolio">
                <a href="portfolio-item.html">
                    <a href="http://www.nautiljon.com/"><img class="img-responsive img-hover" src="img/nautiljon.png" width="700" height="400" alt=""></a>
                </a>
                <h3>
                    <a href="http://www.nautiljon.com/">Site de nautiljon.com</a>
                </h3>
            </div>
        </div>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

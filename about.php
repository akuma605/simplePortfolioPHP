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
                    <li class="active">
                        <a href="about.php">About</a>
                    </li>
                    <li>
                        <a href="services.php">Services</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <li>
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

        <div id="cv">
                <h1>Mon CV</h1><hr>
                <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">About</li>
                </ol>
            </div>
        </div>
                <div class="content_cv">
                    <h4>Ghazouani Yassine</h4>
                        <p>
                            Adresse : Avenue Norbert Gille<br/>
                            Téléphone : 5555555<br/>
                            E-Mail : akuma605@hotmail.com<br/>
                            Date de naissance : 22 mars 1986<br/>
                            Nationalité : Belge<br/>
                            Etat civil : Marié<br/>
                        </p>

                    <h4>Formations</h4>
                        <p>
                            2013<br/>
                            Formation en Web developper à l’institut Paul Hankar (Bruxelles).<br/><br/>
                            2006<br/>
                            CESS en Comptabilité.
                        </p>
                    <h4>Expériences professionnelles</h4>
                        <p>
                            2014<br/>
                            Stage en entreprise<br/>
                        </p>
                    <h4>Connaissances informatiques</h4>
                        <p>
                            Office<br/>
                            Word / Excel / PowerPoint<br/><br/>
                            Web<br/>
                            Photoshop / Illustrator / Programmation/ Drupal<br/>
                        </p>
                    <h4>Langues</h4>
                        <p>
                            Langue maternelle :<br/>
                            Français<br/><br/>
                            Bonne connaissance :<br/>
                            Néerlandais / Anglais / Arabe / Japonais<br/>
                        </p>
                    <h4>Loisirs</h4>
                        <p>
                            Lecture / Sport <br/>
                        </p>

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

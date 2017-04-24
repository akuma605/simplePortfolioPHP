    <?php   
    //on demarre la session
    session_start();
    include_once ('lib/php/fonction.php');//on fait appel à la page fonction pour la connection!
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
    <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">Profil</li>
                </ol>
            </div>
        </div>

        <?php   

    if( isset($_POST['modifier']) )
    {
        //initialisation du contenu à afficher --> il est vide si on n'affiche rien!
        $contenu = '';

        //on part du principe qu'il n'y a pas d'erreur dans le formulaire
        $_SESSION['erreurform'] = false;

        //On récupère les valeurs entrées par l'utilisateur :
        $new_adresse            = secureData($_POST['adresse']);
        $new_cp                 = secureData($_POST['cp']);
        $new_ville              = secureData($_POST['ville']);
        $new_pays               = secureData($_POST['pays']);
        $new_mail               = secureData($_POST['mail']);
        $new_login              = secureData($_POST['login']);
        $new_mdp                = md5($_POST['mdp']);
        $new_newsletter         = $_POST['newsletter'];

        //on valide les champs du formulaire
        valider_adresse($_POST['adresse']);
        valider_cp($_POST['cp']);
        valider_ville($_POST['ville']);
        valider_pays($_POST['pays']);
        valider_mail($_POST['mail']);
        valider_login($_POST['login']);
        valider_mdp($_POST['mdp']);
        valider_newsletter($_POST['newsletter']);

        // après validation, on vérifie s'il y a une erreur
        if($_SESSION['erreurform'])
        {
            //on renvoie vers la page où il y a le formulaire
            header('refresh:0;url=profil.php');
        }
        else
        {
            //on se connecte
                $connection = connectBD();
                
                if ($connection)
                {
                    try
                    {
                        //on tente d'executer les requetes suivantes dans une transaction
                        //on lance la transaction
                        $connection->beginTransaction();

                        //si connection on prépare la requête
                        $connection->exec('UPDATE utilisateurs SET adresse = "'.$new_adresse.'" WHERE id='.$_SESSION['id']);
                        $connection->exec('UPDATE utilisateurs SET cp = '.$new_cp.' WHERE id='.$_SESSION['id']);
                        $connection->exec('UPDATE utilisateurs SET  ville = "'.$new_ville.'"  WHERE id='.$_SESSION['id']);
                        $connection->exec('UPDATE utilisateurs SET pays = "'.$new_pays.'" WHERE id='.$_SESSION['id']);
                        $connection->exec('UPDATE utilisateurs SET mail = "'.$new_mail.'"  WHERE id='.$_SESSION['id']); 
                        $connection->exec('UPDATE utilisateurs SET mdp = "'.$new_mdp.'"  WHERE id='.$_SESSION['id']);
                        $connection->exec('UPDATE utilisateurs SET newsletter = "'.$new_newsletter.'"  WHERE id='.$_SESSION['id']);  
                        
                        //si jusque là tout va bien, on valide la transaction
                        $connection->commit();

                        unset( $connection );

                        $contenu = '<info>Vos données ont été modifiées.<br/> Veuillez vous reconnecter.</info>';
                        header ('refresh:3;url=connection.php');
                    }
                    catch(PDOException $e)//en cas d'erreur
                        {
                            //on annule la transaction
                            $connection->rollback();

                            //on affiche un message d'erreur ainsi que les erreur
                            $contenu = '<erreur> Erreur: Erreur lors de la requête, veuillez contacter votre administrateur!</erreur></br>';
                            $contenu .= '<erreur>Erreur: '.$e->getMessage().'</erreur></br>';
                            $contenu .= '<erreur>Erreur:'.$e->getCode().'</erreur></br>';

                            //on arrête l'execution s'il y a du code après
                            exit();
                        }   
                }
                else
                {
                    $contenu = '<erreur>Erreur : Impossible de se connecté à la BD, veuillez contacter votre administrateur!</erreur>';

                }
        }  
?>

    <div id="content">
        <h1>Modification...</h1>
        <?php
            //affichage du contenu de la page
            echo $contenu;
        ?>

<?php
    }

    else
    {
        //accès à la page sans passer par le formulaire, renvoi de l'index
        header('refresh:1;url=profil.php');

    }
?>

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
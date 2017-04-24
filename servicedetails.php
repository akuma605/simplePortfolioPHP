<?php 
//on demarre la session
    session_start();
	require_once('lib/php/fonction.php');	
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
                    <li class="active">
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

        <div id="content">
         <br/><br/>

        <?php
            if( !isset($_SESSION['id']))
                {    
                     echo' <div class="alert alert-info"> Vous devez être connectez pour pouvoir commander!</div>'; 
                }                           
        ?>
        <?php
            //vérification si un id existe
            if(isset($_GET['id']) )
            {
            $id = $_GET['id'];
            //echo $_GET['id'];
    
                try
                {
            
                    //connection à la BD
                    $connection = ConnectBD();
                        
                    $req = 'SELECT * FROM services WHERE id ="'.$id.'"';             
                   
                    //exécution de la requête pour récuperer tous les id des services                 
                    $resultats = $connection->query($req);

                    //boucle d'affichage par ligne
                    while( $tabs = $resultats->fetch(PDO::FETCH_ASSOC))
                        {
                            //var_dump($tabs);

            //ferme la 1ere balise php
                            //affichage de la table des services
            ?>
                            <tr>
                                <td><b style="display:none;"><?php echo $tabs['id']; ?></b></td>
                                <td><?php echo$tabs['titre']; ?></td><br/>
                                <td><?php echo $tabs['detail']; ?></td>
                                <td><strong>PRIX : </strong><?php echo $tabs['prix']; ?> €</td>
                            </tr>                               
                            <p><a href="services.php" class="btn btn-primary">Retour</a> <a href="trt-panier.php?action=ajouter&amp;id=<?php echo $tabs['id'];?>&amp;titre=<?php echo $tabs['titre'] ;?>&amp;prix=<?php echo $tabs['prix']; ?>" class="btn btn-primary">Commander</a></p>
                
            <?php //reouvre la 1ere balise
                                            
                        }   
                    
                    //on libére les résultats de la mémoire
                    $resultats->closeCursor();      
                                    
                    //on ferme la connexion à la BD
                    unset( $connection );  

                }
                catch(PDOException $e) // en cas d'erreur
                {
                    // on affiche un message d'erreur ainsi que les erreurs
                    echo '<erreur>Erreur [0023]: Erreur lors de la requête, veuillez contacter votre administrateur!</erreur>';     
                    echo '<erreur>Erreur : '.$e->getMessage().'</erreur><br/>';
                    echo '<erreur>N° : '.$e->getCode().'</erreur><br/>';
                        
                    //on arrête l'exécution s'il y a du code après
                    exit();
                }                           
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
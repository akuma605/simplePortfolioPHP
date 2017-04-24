<?php 
	//on demarre la session
    session_start();

	// on vérifie si l'utilisateur est connecté	
	if( !isset($_SESSION['id']) )
	{
		header('Location: index.php');
	}
	else
		
	{
		
		//les includes
		require_once ('lib/php/fonction.php');//on fait appel à la page fonction pour la connection!
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
                            <li class="active"><a href="panier.php">Panier <b style="color:white;"><?php echo "({$cartItemCount})"; ?></b> </a></li>           
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

    <div class="container">

		<div id="content">
			<h2>Votre panier</h2><hr>
			<!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">Panier</li>
                </ol>
            </div>
        </div>
		<?php
		//on remplis la variable $afficher_message_reussite = message de réussite d'ajout au panier
		if(isset($_SESSION['afficher_message_reussite']) && $_SESSION['afficher_message_reussite']) 
		{
		?>
			<div class="alert alert-success">
				Votre service a bien été enregistré dans votre panier.
			</div>
		<?php
		}
		?>

		<?php
		//on remplis la variable $afficher_message_erreur = message d'erreur d'ajout au panier
		if(isset($_SESSION['afficher_message_erreur']) && $_SESSION['afficher_message_erreur']) 
		{
		?>
			<div class="alert alert-info">
				Ce service a déjà été enregistré dans votre panier.
			</div>
		<?php
		}
			//variable date du jour pour la date de commande							
			$date_commande = date('d-m-y');

			echo '<info><h4>Bonjour <b>'.$_SESSION['prenom'].' '.$_SESSION['nom'].'</b>, Voici les services commandés!</h4> </info> </br>';
		?>
		
		<?php
			echo'<P><rose>VOTRE NUMERO DE CLIENT : </rose> '.$_SESSION['id'].'</p> <rose> Date de Commande : </rose> '.$date_commande.'<br/><br/>';
		?>

						
					
		<?php

			//s'il y a un panier
			if (isset($_SESSION['panier'])) 
			{
				//var_dump($_SESSION['panier']);

				//boucle pour récupérer les élément du panier
				foreach ($_SESSION['panier'] as $key => $value) 
            	{
            		echo '<div style="width:650px;background-color:#B5E655;color:black;border-radius:5px;">';
            		echo 'ID du service commandé : '.$value[0].'<br>'; //la valeur 0 = id su service
            		echo 'TITRE du service commandé : '.$value[1].'<br>'; // la valeur 1 = le titre du service
            		echo 'PRIX du service commandé : '.$value[2].' € <br>'; // la valeur 2 = le prix du service
        ?>
            <p style="background-color:#B5E655;text-align:right;border-radius:5px;">
            	<a href="trt-panier.php?action=supprimer&amp;id=<?php echo $value[0]; ?>" class="btn btn-primary"> supprimer
            	</a> <a href="trt-panier.php?action=valider&amp;id=<?php echo $value[0];?>" class="btn btn-primary">Valider</a>
            </p>
        <?php
            echo "</div>";
        		}

			}
			//sinon le panier est vide
			else
			{
				echo "<h4>Votre panier est vide<h4/><br/><br/>";
			}		
		?>

		<a href="services.php" class="btn btn-primary">retour</a> <a href="trt-panier.php?action=vider" class="btn btn-primary" >vider le panier</a> 

		</div><!--fin div content-->

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
<?php
	
	}	
?>
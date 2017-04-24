<?php 	
	//on demarre la session
    session_start();
      //inclure la page fonction
	include_once ('lib/php/fonction.php');

		if( isset($_POST['inscription']) )
		{
			//le contenu est vide si on n'affiche rien
			$contenu = '';

			//la session erreur est false
			$_SESSION['erreurform'] = false;

			//on récupère les données entrées par l'utilisateur
			$nom 				= secureData($_POST['nom']);
			$prenom				= secureData($_POST['prenom']);
			$sexe 				= secureData($_POST['sexe']);
			$adresse 			= secureData($_POST['adresse']);
			$cp 				= secureData($_POST['cp']);
			$ville 				= secureData($_POST['ville']);
			$pays 				= secureData($_POST['pays']);
			$mail 				= secureData($_POST['mail']);
			$login 				= secureData($_POST['login']);
			$mdp 				= md5($_POST['mdp']);
			$date_inscription 	= date('y-m-d');
			$newsletter 		= $_POST['newsletter'];
			$admin 				= 0;
			
			
			//on vérifie s'il y a un doublon du login
			verifier_login($login);
			//on valide les champs du formulaire
			valider_nom($_POST['nom']);
			valider_prenom($_POST['prenom']);
			valider_sexe($_POST['sexe']);
			valider_adresse($_POST['adresse']);
			valider_cp($_POST['cp']);
			valider_ville($_POST['ville']);
			valider_pays($_POST['pays']);  
			valider_mail($_POST['mail']);
			valider_login($_POST['login']);
			valider_mdp($_POST['mdp']);
			valider_newsletter($_POST['newsletter']);
			
				
		
			if($_SESSION['erreurform'])
			{
				//on renvoie vers la page où il y a le formulaire
				header('refresh:1;url=inscription.php');
			}
			else
			{
				//on se connecte
				$connection = connectBD();

				if ($connection)
				{
					try
					{
						//on lance la transaction
						$connection->beginTransaction();

						//si connection on prépare la requête
						$connection->exec('INSERT INTO utilisateurs VALUES(null,"'.$nom.'","'.$prenom.'","'.$sexe.'","'.$adresse.'","'.$cp.'","'.$ville.'","'.$pays.'","'.$mail.'","'.$login.'","'.$mdp.'","'.$date_inscription.'","'.$newsletter.'","'.$admin.'","'.$_SERVER['REMOTE_ADDR'].'")'); 
								
						//validation de la transaction
						$connection->commit();

						//appel de la fonction qui connecte l'utilisateur
						login($connection,$login,$mdp);

						//On donne une valeur au contenu
						$contenu = '<info>Vous etes inscrit(e)!</info>';
						//on renvoie vers la page d'acceuil
						header ('refresh:3;url=index.php');
					}
					//si erreur
					catch(PDOException $e)
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
					$contenu = '<erreur>Erreur : Impossible de se connecter à la BD, veuillez contacter votre administrateur!</erreur>';
				}
				
				?>

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
                        echo'<li class="active"><a href="inscription.php">Inscription</a></li>
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
						<h1>Inscription...</h1>	

						<?php
							//affichage du contenu de la page
							echo $contenu;
						?>
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
		}
	else
	{
		//accès à la page sans passer par le formulaire, renvoi de l'index
		header('refresh:2;url=inscription.php');
	}
?>
		

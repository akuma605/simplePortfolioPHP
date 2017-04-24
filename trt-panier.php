<?php
session_start();
if( !isset($_SESSION['id']) )
	{
		header('Location: index.php');
	}
	else
		
	{

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

    <!-- Page Content -->
    	<div class="container">

       	<title>Connection</title>

		<div id="content">
		    <section>
                <article>  
            	   <h1>Enregistrement...</h1>
				
                </article>
            </section>
	   </div>
	
<?php
		//on détermine les message d'erreur et de réussite à false par défaut!
		$_SESSION['afficher_message_erreur']  = false;
		$_SESSION['afficher_message_reussite']  = false;

		//condition qui verifie l'existence des variables
		$action = isset($_GET['action'])? $_GET['action'] : "" ; 
		$id_service = isset($_GET['id']) ? $_GET['id'] : "";
    	$titre = isset($_GET['titre']) ? $_GET['titre'] : "";
    	$prix = isset($_GET['prix']) ? $_GET['prix'] : "";

    	// vérifie l'existence d'un panier. 
		//si non, on en crée un avec comme valeur un tableau
		if (!isset($_SESSION['panier'])) 
		{
			$_SESSION['panier'] = array();
		}

		//séléction du type d'action à faire
		switch ($action) 
		{
			case  'ajouter':
				//SI LE SERVICE EXISTE ON AUGMENTE LA QUANTITE SINON ON LE MET A 1
				if (isset($_SESSION['panier'][$id_service])) 
				{
					//$_SESSION['panier'][$id]++; 
					//message_erreur devient true, on ne peut pas augmenter la quantité.
					$_SESSION['afficher_message_erreur'] = true;
					//redirige vers la page panier 
					header('refresh:0;url=panier.php'); 
				}
				else 
				{
					$_SESSION['panier'][$id_service] = array($id_service, $titre, $prix);
										
					$_SESSION['afficher_message_reussite'] = true;
					$_SESSION['afficher_message_erreur'] = ""; //le met en null pour éviter qu'il ne s'affiche
					
					header('refresh:0;url=panier.php');
				}
			break;
			
			case 'supprimer'://cas ou on veut supprimer un ou plusieur article	

				//détruit la session du service concerné
				unset($_SESSION['panier'][$id_service]);
				header('refresh:0;url=panier.php');
			break;

			case 'vider':// cas ou on veut vider le panier
			
				//detruit la session panier
				unset($_SESSION['panier']);
				header('refresh:0;url=panier.php');
			break;

			case 'valider'://valider le panier

				if(isset($_GET['action']) && isset($_GET['id']))
				{

					//on se connecte
					$connection = ConnectBD();
					//on détermine la variable date
					$date_commande 	= date('y-m-d');
					//le contenu est vide
					$contenu = "";

					//boucle qui parcourt le panier
					foreach ($_SESSION['panier'] as $key => $value) 
					{				
						$user_id = $_SESSION['id'];
						//$key = $id_service;
						//$value[1] = le titre du service
						//$value[2] = le prix du service
						try 
						{
							//on lance la transaction
							$connection->beginTransaction();
							//si connection on prépare la requête
							$connection->exec('INSERT INTO commandes VALUES (NULL, "'.$_SESSION['id'].'","'.$key .'","'.$_SESSION['mail'].'","'.$value[2].'","'.$date_commande.'")'); 
												
							//validation de la transaction
							$connection->commit();

							//On donne une valeur au contenu
							$contenu = '<info>Votre commande à bien été prise en compte!!!</info>';
						} 
						//erreur
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
					//et tu redirige
					header('refresh:3;url=panier.php');
					echo $contenu;		
				}
			break;	
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
 <?php 
	//on demarre la session
    session_start();	
	require_once ('lib/php/fonction.php');//on fait appel à la page fonction pour la connection!

	if( isset($_POST['bouton']) )
		{
			//Le contenu est vide
			$contenu ='';

			//pas d'erreur par default
			$_SESSION['erreurform'] = false;

			//valider les données entrées par l'utilisateur
			valider_login($_POST['login']);
			valider_mdp($_POST['mdp']);

			//on vérifie s'il y a erreur
			if($_SESSION['erreurform'])
			{
				//s'il y a erreur, réinitialisation de l'erreur de connection
				$_SESSION['erreur_connection'] = '';

				//renvoie vers la page avec le formulaire
				header('refresh:0;url=connection.php');
			}
			else
			{
				//connection à la BD
				$connection = ConnectBD();
				
				//on récupère les données sécurisées du formulaire 
				$login = secureData($_POST['login']);
				$mdp = md5(secureData($_POST['mdp']));
				
				//oon connecte l'utilisateur grace à la focntion
				$connecte = login($connection, $login, $mdp);
				
				//si connection
				if( $connecte )
				{
					//redirection vers la page index.php
					header('refresh:3;url=index.php');
						
					//on prépare le contenu à afficher
					$contenu = '<info>Bonjour <b>'.$_SESSION['prenom'].' '.$_SESSION['nom'].'</b>.</info></br></br>';	
				}
				else
				{
					//on prépare l'erreur à afficher
					$_SESSION['erreur_connection'] = '<erreur>Votre login ou mot de passe est erroné!</erreur>';
					
					//renvoi vers la page du formulaire de connection
					header('refresh:1;url=connection.php');
				}

			}
?>

	<title>Connection</title>
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

       	<title>Connection</title>

		<div id="content">
		    <section>
                <article>  
            	   <h1>Connection...</h1>
                  
				        <?php
				        echo $contenu;
		                ?>
				
                </article>
            </section>
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
<?php
	}
	else
	{
		//accès à la page sans passer par le formulaire -> redirection vers la page d'index
		header('refresh:0;url=index.php');
	}
?>
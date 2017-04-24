<?php
	//on demarre la session
    session_start();

	//on vérifie si l'utilisateur est un admin et s'il est connecté
	if (!isset($_SESSION['id']))
	{
		// l'utilisateur est renvoyé vers la page index
		header('refresh:0;url=index.php');
	}

	elseif ($_SESSION['admin'] == 0) 
	{
		// l'utilisateur est renvoyé vers la page index
		header('refresh:0;url=index.php');
	}

	//Les includes
	include_once ('lib/php/fonction.php');//on fait appel à la page fonction pour la connection!
?>

	<title>Administration</title>
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
                            echo'<li class="active"><a href="admin.php">Administrateur</a></li>';
                        }
                    }
                    else
                    {
                        echo'<li><a href="inscription.php">Inscription</a></li>
                        <li class="active"><a href="connection.php">Se connecter</a></li>';
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

			</br><h1>Administrateur</h1><hr>

			<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">Inscription</li>
                </ol>
            </div>
        </div>

        </br><h2>Commandes</h2><hr>

		<?php

			$contenu="";

			//on se connecte
			$connection = connectBD();

			if($connection)
			{
				//requête de sélection
				$requête = 'SELECT * FROM commandes';

				$resultats = $connection->query($requête);

				if($resultats->rowCount()>0)
				{
					//création d'une table
					echo '
						<table class="profil" w>
						<td class="noir" >N° de commande</td>
						<td class="noir">ID Client</td>
						<td class="noir">ID du service</td>
						<td class="noir">Adresse E-mail</td>
						<td class="noir">Prix</td>
						<td class="noir">Date de commande</td>';

					//boucle pour récupérer les données	
					foreach ($resultats as $key) 
					{
						//affichage de la commande
						echo '<tr>
							<td style="width:150px;"> '.$key['id'].'</td>
							<td style="width:150px;">'.$key['user_id'].'</td>
							<td style="width:150px;">'.$key['service_id'].'</td>
							<td style="width:250px;">'.$key['mail'].'</td>
							<td style="width:100px;">'.$key['prix'].' €</td>
							<td style="width:200px;">'.$key['date_commande'].'</td>
							<td><a alt="Supprimer" href="admin_trt.php?action=1&id='.$key['id'].'"" ><img syle="float:right;" src="img/delete.jpg" width="50" height="50"></a> </td>
							</tr>';
					}
				
					echo'</table>';
				}
			}
			else
			{
				$contenu = '<erreur>Erreur : Impossible de se connecter à la BD, veuillez contacter votre administrateur!</erreur>';
			}
		?>

    </br><h2>Membre</h2><hr>

        <?php

            $contenu="";

            //on se connecte
            $connection = connectBD();

            if($connection)
            {
                //requête de sélection
                $requête = 'SELECT * FROM utilisateurs';

                $resultats = $connection->query($requête);

                if($resultats->rowCount()>0)
                {
                    //création d'une table
                    echo '
                        <table>
                        <td>ID Membre</td>
                        <td>Nom</td>
                        <td>Prenom</td>
                        <td>Adresse E-mail</td>
                        <td>Admin</td>';

                    //boucle pour récupérer les données 
                    foreach ($resultats as $key) 
                    {
                        //affichage de la commande
                        echo '<tr>
                            <td style="width:150px;"> '.$key['id'].'</td>
                            <td style="width:150px;">'.$key['nom'].'</td>
                            <td style="width:150px;">'.$key['prenom'].'</td>
                            <td style="width:250px;">'.$key['mail'].'</td>  
                            <td style="width:250px;">'.$key['admin'].'</td>';

                            if (!$key['admin'] == 1)
                            {
                                echo '<td><a alt="Supprimer" href="admin_trt2.php?action=1&id='.$key['id'].'"" ><img syle="float:right;" src="img/delete.jpg" width="50" height="50"></a> </td></tr>';
                            }
                    }
                
                    echo'</table>';
                }
            }
            else
            {
                $contenu = '<erreur>Erreur : Impossible de se connecter à la BD, veuillez contacter votre administrateur!</erreur>';
            }
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

    <!-- /.container -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	</body>
</html>
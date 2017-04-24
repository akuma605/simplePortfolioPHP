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
   <?php 
    //on demarre la session
    session_start();    
    require_once ('lib/php/fonction.php');//on fait appel à la page fonction pour la connection!
      
?>
    <title>Connection</title>
</head>
<body>
    <?php ?>
        <div id="content">

                <form name="connect" method="POST" action="connectionTRT.php">
                        <fieldset>
                            <h1>Connection</h1><hr>
                            <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">Inscription</li>
                </ol>
            </div>
        </div>

                            <label for="login"> Login</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="login" type="text" name="login" value="<?php if(isset($_SESSION['form_login'])){echo $_SESSION['form_login'];} ?>">
                            <span class="erreur_message"></span> 
                            <?php if(isset($_SESSION['erreurform_login'])){echo $_SESSION['erreurform_login'];} ?><br/>

                            <label for="password"> Mot de passe</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="mdp" type="password" name="mdp" value="<?php if(isset($_SESSION['form_mdp'])){echo $_SESSION['form_mdp'];} ?>">
                            <span class="erreur_message"></span> 
                            <?php  if(isset($_SESSION['erreurform_mdp'])) {echo $_SESSION['erreurform_mdp'];}?><br/><br/>
                        </fieldset>

                        <input type="submit" class="btn btn-primary" name="bouton" value="Connection"><br/><br/>
                    </form>         
        </div>

    <script src="lib/js/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(function(){
            //fonction de validation du login
            $("#login").keyup(function(){//fonction de validation du login
                if(!$("#login").val().match(/^[^ -][a-zA-Z]{3,10}$/)){
                    $("#login").next(".erreur_message").show().text("Veuillez entrer un login valide");
                }
                else{
                    $("#login").next(".erreur_message").hide().text("");
                }
                })
            //fonction de validation du mdp 
            $("#mdp").keyup(function(){
                if(!$("#mdp").val().match(/^[^ -][a-zA-Z]{3,10}$/)){
                    $("#mdp").next(".erreur_message").show().text("Veuillez entrer un mot de passe valide");
                }
                else{
                    $("#mdp").next(".erreur_message").hide().text("");
                }
                })
        })

    </script>

    </body>
</html>

<?php
    
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
</div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

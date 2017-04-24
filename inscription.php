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
    
    <?php   
    //on demarre la session
    session_start();

    // on vérifie si l'utilisateur est connecté         
    if( isset($_SESSION['id']) )
    {
        // l'utilisateur est connecté, pas besoin de s'inscrire
        header ('refresh:0;url=index.php');
        //echo'Vous êtes déjà inscrit!</br>';
    }   
    else
    {

    //les includes
    include_once ('lib/php/fonction.php');//on fait appel à la page fonction pour la connection!
?>
            
    <title>Inscription</title>
</head>
    <body>
        <div id="content">
            <h1>Inscription</h1><hr>
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
            
                <form id="formulaire" name="formulaire" method="POST" action="inscriptionTRT.php">
                    <fieldset>
                        <legend>Formulaire d'insciption</legend>
                        <p>
                            <label for="nom" style="width:400px;"> Nom*</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="nom" type="text" name="nom" value="<?php if(isset($_SESSION['form_nom'])){ echo $_SESSION['form_nom'];} ?>" maxlength="20"/>
                            <span class="erreur_message"></span> 
                            <?php if(isset($_SESSION['erreurform_nom'])){echo $_SESSION['erreurform_nom'];}?><br/>
                            <i>*le nom doit comporter 2 à 20 caractéres et ne doit pas contenir d'espace.</i>
                        </p> 

                        <p>
                            <label for="prenom" style="width:400px;"> Prénom</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="prenom" type="text" name="prenom" value="<?php if(isset($_SESSION['form_prenom'])){echo $_SESSION['form_prenom'];} ?>" maxlength="20">
                            <span class="erreur_message"></span> 
                            <?php if(isset($_SESSION['erreurform_prenom'])){echo $_SESSION['erreurform_prenom'];} ?>
                        </p>

                        <p>
                            <label style="width:400px;">Sexe</label>
                            <?php
                            if(isset($_SESSION['form_sexe']))
                            {
                                switch($_SESSION['form_sexe'])
                                {
                                    case'F':
                                    echo'<input type="radio" id="radio_f" name="sexe" value="F" checked>F';
                                    echo'<input type="radio" id="radio_m" name="sexe" value="M">M';
                                    break;
                                    
                                    case'M':
                                    echo'<input type="radio" id="radio_f" name="sexe" value="F">F';
                                    echo'<input type="radio" id="radio_m" name="sexe" value="M" checked>M';
                                    break;
                                }
                            }
                            else
                            {
                                    echo'<input type="radio" id"radio_f" name="sexe" value="F" checked>F';
                                    echo'<input type="radio" id="radio_m" name="sexe" value="M">M<br/><br/>';
                            } 

                            ?>
                        </p>

                        <p>
                            <label for="adresse" style="width:400px;"> Adresse</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;"  id="adresse" type="text" name="adresse" value="<?php if(isset($_SESSION['form_adresse'])){echo $_SESSION['form_adresse'];} ?>">
                            <span class="erreur_message"></span>
                            <?php if(isset($_SESSION['erreurform_adresse'])) {echo $_SESSION['erreurform_adresse'];} ?>
                        </p>

                        <p> 
                            <label for="cp" style="width:400px;"> Code postal</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;"  id="cp" type="int" name="cp" value="<?php if(isset($_SESSION['form_cp'])){echo $_SESSION['form_cp'];} ?>">
                            <span class="erreur_message"></span>
                            <?php if(isset($_SESSION['erreurform_cp'])) {echo $_SESSION['erreurform_cp'];} ?>
                        </p>

                        <p>
                            <label for="ville" style="width:400px;"> Ville</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="ville" type="text" name="ville" value="<?php if(isset($_SESSION['form_ville'])){echo $_SESSION['form_ville'];} ?>">
                            <span class="erreur_message"></span>
                            <?php if(isset($_SESSION['erreurform_ville'])) {echo $_SESSION['erreurform_ville'];} ?>
                        <p/>
                        
                        <p>
                            <label for="pays" style="width:400px;">Pays</label>
                            <?php
                                //création du tableau des pays
                                $pays = creer_pays();

                                //création de la liste des pays dynamiquement
                                echo '<select id="pays" name="pays" style="width:200px;border: 1px solid #ccc; border-radius: 4px;">';
                                foreach ($pays as $code => $nom)
                                {
                                    echo '<option value="'.$code.'" ';
                                    if (isset($_SESSION['form_pays']) )
                                    {
                                        //on vérifie si le choix du pays déjà choisi
                                        if($code == $_SESSION['form_pays'] )
                                        {
                                            echo 'selected';
                                        }
                                    }
                                    else
                                    {
                                        // la belgique est sélectionnée par défaut
                                        if($code =='BE')
                                        {
                                            echo 'selected';
                                        }
                                    }

                                    echo '>' .$pays[$code]['FR'].'</option>';
                                }
                                echo '</select><br/><br/>';
                            ?>
                            <?php if(isset($_SESSION['erreurform_pays'])) {echo $_SESSION['erreurform_pays'];} ?>
                        </p>

                        <p>
                            <label for="mail" style="width:400px;"> E-mail</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;"  id="mail" type="mail" name="mail" value="<?php if(isset($_SESSION['form_mail'])){echo $_SESSION['form_mail'];} ?>">
                            <span class="erreur_message"></span>
                            <?php if(isset($_SESSION['erreurform_mail'])) {echo $_SESSION['erreurform_mail'];} ?> 
                        <p/>
                                            
                        <p>
                            <label for="login" style="width:400px;"> Login</label>
                            <input style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="login" type="text" name="login" value="<?php if(isset($_SESSION['form_login'])){echo $_SESSION['form_login'];}?>" maxlength="10">
                            <span class="erreur_message"></span>
                            <?php if(isset($_SESSION['erreurform_login'])) {echo $_SESSION['erreurform_login'];} ?>
                        <p/>

                        <p>
                            <label for="password" style="width:400px;"> Mot de passe </label>
                            <input  style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="mdp" type="password" name="mdp" value="<?php if(isset($_SESSION['form_mdp'])){echo $_SESSION['form_mdp'];}?>" maxlength="8">
                            <span class="erreur_message"></span>
                            <?php if(isset($_SESSION['erreurform_mdp'])) {echo $_SESSION['erreurform_mdp'];} ?> 
                        </p>

                        <p>
                            <label style="width:400px;">Voulez-vous être abonné à notre newsletter?</label>
                            <?php
                            if(isset($_SESSION['form_newsletter']))
                            {
                                switch($_SESSION['form_newsletter'])
                                {
                                    case'Oui':
                                    echo'<input type="radio" id="radio_o" name="newsletter" value="Oui" checked>Oui';
                                    echo'<input type="radio" id="radio_n" name="newsletter" value="Non">Non';
                                    break;
                                    
                                    case'Non':
                                    echo'<input type="radio" id="radio_o" name="newsletter" value="Oui">Oui';
                                    echo'<input type="radio" id="radio_n" name="newsletter" value="Non" checked>Non';
                                    break;
                                }
                            }
                            else
                            {
                                    echo'<input type="radio" id"radio_o" name="newsletter" value="Oui" checked>Oui';
                                    echo'<input type="radio" id="radio_n" name="newsletter" value="Non">Non<br/><br/>';
                            } 
                            ?>
                        </p>
                    </fieldset>
                    <p><i>Tout les champs sont obligatoires!</i></p><br/><br/><br/>

                    <input type="submit" class="btn btn-primary" name="inscription" value="Iscription" id="inscription"/> 
                </form> 
        </div>

        <script src="lib/js/jquery.min.js" type="text/javascript"></script>
            <script type="text/javascript">

                $(function(){
                    //fonction de validation du nom
                    $("#nom").keyup(function(){
                        if(!$("#nom").val().match(/^[^ -][a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð'-]+$/i))
                        {
                            $("#nom").next(".erreur_message").show().text("veuillez entrer un nom valide");
                        }
                        else
                        {
                            $("#nom").next(".erreur_message").hide().text("");
                        }
                    })
                    //fonction de validation du prénom
                    $("#prenom").keyup(function(){
                        if(!$("#prenom").val().match(/^[^ -][a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð'-]+$/i))
                        {
                            $("#prenom").next(".erreur_message").show().text("veuillez entrer un prenom valide");
                        }
                        else
                        {
                            $("#prenom").next(".erreur_message").hide().text("");
                        }
                    })
                    //fonction de validation de l'adresse
                    $("#adresse").keyup(function(){
                        if($("#adresse").val() == "")
                        {
                            $("#adresse").next(".erreur_message").show().text("Veuillez remplir le champs");
                        }
                        else
                        {
                            $("#adresse").next(".erreur_message").hide().text("");
                        }
                    })

                    //fonction de validation du cp
                    $("#cp").keyup(function(){
                        if(!$("#cp").val().match(/^[0-9]{2,}$/))
                        {
                            $("#cp").next(".erreur_message").show().text("Veuillez entrer un cp valide");
                        }
                        else{
                            $("#cp").next(".erreur_message").hide().text("");
                        }
                    })
                    //fonction de validation de la ville
                    $("#ville").keyup(function(){
                        if($("#ville").val() == "")
                        {
                            $("#ville").next(".erreur_message").show().text("Veuillez remplir le champs");
                        }
                        else
                        {
                            $("#ville").next(".erreur_message").hide().text("");
                        }
                    })
                    //fonction de validation du mail
                    $("#mail").keyup(function(){
                        if(!$("#mail").val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9])+([a-zA-Z0-9\._-])*\.([a-zA-Z])+$/))
                        {
                            $("#mail").next(".erreur_message").show().text("Veuillez entrer un mail valide");
                        }
                        else
                        {
                            $("#mail").next(".erreur_message").hide().text("");
                        }
                    })
                    //fonction de validation du login
                    $("#login").keyup(function(){
                        if(!$("#login").val().match(/^[^ -][a-zA-Z]{2,10}$/))
                        {
                            $("#login").next(".erreur_message").show().text("Veuillez entrer un login valide");
                        }
                        else
                        {
                            $("#login").next(".erreur_message").hide().text("");
                        }
                    })
                    //fonction de validation du mdp
                    $("#mdp").keyup(function(){
                        if(!$("#mdp").val().match(/^[^ -][a-zA-Z]{2,10}$/))
                        {
                            $("#mdp").next(".erreur_message").show().text("Veuillez entrer un mot de passe valide");
                        }
                        else
                        {
                            $("#mdp").next(".erreur_message").hide().text("");
                        }
                    })
                })
        </script> 
    </body>
</html>
<?php
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
</div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>

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
            
    <title>Inscription</title>
</head>
    <body>
        <div id="content">

            <h1>Profil utilisateur</h1>

            <div id="profil">
                <table class="profil">
                    <form id="form" name="form" method="POST" action="profilTRT.php">
                    
                    <tr class="fonce">
                        <td class="noir">ID :</td>
                        <td><?php echo $_SESSION['id']; ?></td>
                    </tr>   
                    <tr><td></td><td></td></tr>     

                    <tr class="clair">
                        <td class="noir">Nom :</td>
                        <td><?php echo $_SESSION['nom']; ?></td>
                    </tr>
                    <tr><td></td><td></td></tr>
                        
                    <tr class="fonce">
                        <td class="noir">Prénom :</td>
                        <td><?php echo $_SESSION['prenom']; ?></td>
                    </tr>
                    <tr><td></td><td></td></tr>
                        
                    <tr class="clair">
                        <td class="noir">Sexe :</td>
                        <td><?php echo $_SESSION['sexe']; ?></td>
                    </tr>
                    <tr><td></td><td></td></tr>
                        
                    <tr class="fonce">
                        <td class="noir">Adresse :</td>
                        <td><?php echo $_SESSION['adresse']; ?></td>
                    <tr class="clair">
                        <td class="noir" style="color:#aa333e;">Modifier votre adresse :</td>
                        <td> <input id="new_adresse" style="width:200px;border: 1px solid #ccc; border-radius: 4px;" type="text" name="adresse"  value="<?php echo $_SESSION['adresse']; ?>" >
                        <span class="erreur_message"></span>
                        <?php if(isset($_SESSION['erreurform_adresse'])) {echo $_SESSION['erreurform_adresse'];} ?><br/></td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="fonce">
                        <td class="noir">Code Postal :</td> 
                        <td><?php echo $_SESSION['cp']; ?></td>
                    </tr>
                    <tr class="clair">
                        <td class="noir" style="color:#aa333e;">Modifier votre code postal :</td>
                        <td><input id="new_cp" style="width:200px;border: 1px solid #ccc; border-radius: 4px;" type="int" name="cp" value= "<?php echo $_SESSION['cp']; ?>">
                        <span class="erreur_message"></span>
                        <?php if(isset($_SESSION['erreurform_cp'])) {echo $_SESSION['erreurform_cp'];} ?><br/></td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="fonce">
                        <td class="noir">Ville :</td>
                        <td><?php echo $_SESSION['ville']; ?></td>
                    </tr>
                    <tr class ="clair">
                        <td class="noir" style="color:#aa333e;">Modifier votre ville :</td>
                        <td><input id="new_ville" style="width:200px;border: 1px solid #ccc; border-radius: 4px;" type="text" name="ville" value="<?php echo $_SESSION['ville']; ?>">    
                        <span class="erreur_message"></span>
                        <?php if(isset($_SESSION['erreurform_ville'])) {echo $_SESSION['erreurform_ville'];} ?><br/></td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="fonce">
                        <td class="noir">Pays :</td>
                        <td><?php echo $_SESSION['pays']; ?></td>
                    </tr>
                    <tr class ="clair">
                        <td class="noir" style="color:#aa333e;">Modifier votre pays :</td>
                            <td><?php
                                //création du tableau des pays
                                $pays = creer_pays();

                                //création de la liste des pays dynamiquement
                                echo '<select style="width:200px;border: 1px solid #ccc; border-radius: 4px;" id="new_pays" name="pays">';
                                foreach ($pays as $code => $nom)
                                {
                                    echo '<option value="'.$code.'" ';
                                    if (isset($_SESSION['pays']) )
                                    {
                                        //on vérifie si le choix du pays déjà choisi
                                        if($code == $_SESSION['pays'] )
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
                        <span class="erreur_message"></span>
                        <?php if(isset($_SESSION['erreurform_pays'])) {echo $_SESSION['erreurform_pays'];} ?>
                    </td>
                    </tr>
                    <tr><td></td><td></td></tr>  

                    <tr class="fonce">
                        <td class="noir">E-mail :</td>
                        <td><?php echo $_SESSION['mail']; ?></td>
                    </tr>
                    <tr class ="clair">
                        <td class="noir" style="color:#aa333e;">Modifier votre E-mail :</td>
                        <td><input id="new_mail" style="width:200px;border: 1px solid #ccc; border-radius: 4px;" type="mail" name="mail" value="<?php echo $_SESSION['mail']; ?>">
                        <span class="erreur_message"></span>
                        <?php if(isset($_SESSION['erreurform_mail'])) {echo $_SESSION['erreurform_mail'];} ?> <br/></td>    
                    </tr>
                    <tr><td></td><td></td></tr> 

                    <tr class="fonce">
                        <td class="noir">Login :</td>
                        <td><?php echo $_SESSION['login']; ?></td>
                    </tr>
                    <tr class="clair">
                        <td class="noir" style="color:#aa333e;">Modifier votre login :</td>
                        <td><input id="new_login" style="width:200px;border: 1px solid #ccc; border-radius: 4px;" type="text" name="login" value="<?php echo $_SESSION['login']; ?>">
                        <span class="erreur_message"></span>
                        <?php if(isset($_SESSION['erreurform_login'])) {echo $_SESSION['erreurform_login'];} ?><br/>    
                        </td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="fonce">
                        <td class="noir">Mot de passe :</td>
                        <td><?php if(isset($_SESSION['form_mdp'])){echo $_SESSION['form_mdp'];}?></td>
                    </tr>
                    <tr class="clair">
                        <td class="noir" style="color:#aa333e;">Modifier votre mot de passe :</td>
                        <td><input id="new_mdp" style="width:200px;border: 1px solid #ccc; border-radius: 4px;" type="password" name="mdp" value="<?php if(isset($_SESSION['form_mdp'])){echo $_SESSION['form_mdp'];}?>" maxlength="8">
                        <span class="erreur_message"></span>
                        <?php if(isset($_SESSION['erreurform_mdp'])) {echo $_SESSION['erreurform_mdp'];} ?> </br></td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="fonce">
                        <td class="noir">Date d'inscription :</td>
                        <td><?php echo $_SESSION['date_inscription']; ?></td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="fonce">
                        <td class="noir">Newsletter:</td>
                        <td><?php echo $_SESSION['newsletter']; ?></td>
                    </tr>
                    <tr class="clair">
                    <td class ="noir"style="color:#aa333e;">Modifier newsletter</td>
                    <?php
                        if(isset($_SESSION['newsletter']))
                            {
                                switch($_SESSION['newsletter'])
                                {
                                    case'Oui':
                                    echo'<td><input type="radio" id="radio_o" name="newsletter" value="Oui" checked>Oui';
                                    echo'<input type="radio" id="radio_n" name="newsletter" value="Non">Non</td>';
                                    break;
                                        
                                    case'Non':
                                    echo'<td><input type="radio" id="radio_o" name="newsletter" value="Oui">Oui';
                                    echo'<input type="radio" id="radio_n" name="newsletter" value="Non" checked>Non</td>';
                                    break;
                                }
                            }
                            else
                            {
                                echo'<td><input type="radio" id"radio_o" name="newsletter" value="Oui" checked>Oui';
                                echo'<input type="radio" id="radio_n" name="newsletter" value="Non">Non<br/><br/></td>';
                            } 
                    ?></tr>
                    <tr><td></td><td></td></tr>

                    <tr class="clair">
                        <td class="noir">Admin :</td>
                        <td><?php echo $_SESSION['admin']; ?></td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="fonce">
                        <td class="noir">Adresse IP :</td>
                        <td><?php echo $_SESSION['ip']  ; ?></td>
                    </tr>
                    <tr><td></td><td></td></tr>

                    <tr class="clair">
                        <td class="noir">Cookies :</td>
                        <td><?php echo isset($_COOKIE['login'])?'Activés':'Desactivés'; ?></td>
                    </tr>   
                </table>
                <br/>
                <input class="btn btn-primary" type="submit" name="modifier" value="Modifier" id="modifier"/><br/>
            </form>
        </div>

        <script src="lib/js/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">

            $(function(){
                $("#new_adresse").keyup(function()
                {
                    if($("#new_adresse").val() == "")
                    {
                        $("#new_adresse").next(".erreur_message").show().text("Veuillez remplir le champs");
                    }
                    else
                    {
                        $("#new_adresse").next(".erreur_message").hide().text("");
                    }
                })

                $("#new_cp").keyup(function()
                {
                    if(!$("#new_cp").val().match(/^[0-9]{2,}$/))
                    {
                        $("#new_cp").next(".erreur_message").show().text("Veuillez entrer un cp valide");
                    }
                    else{
                        $("#new_cp").next(".erreur_message").hide().text("");
                    }
                })

                $("#new_ville").keyup(function()
                {
                    if($("#new_ville").val() == "")
                    {
                        $("#new_ville").next(".erreur_message").show().text("Veuillez remplir le champs");
                    }
                    else
                    {
                        $("#new_ville").next(".erreur_message").hide().text("");
                    }
                })
                
                $("#new_mail").keyup(function()
                {
                    if(!$("#new_mail").val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9])+([a-zA-Z0-9\._-])*\.([a-zA-Z])+$/))
                    {
                        $("#new_mail").next(".erreur_message").show().text("Veuillez entrer un mail valide");
                    }
                    else
                    {
                        $("#new_mail").next(".erreur_message").hide().text("");
                    }
                })
                    
                $("#new_login").keyup(function()
                {
                    if(!$("#new_login").val().match(/^[^ -][a-zA-Z]{4,10}$/))
                    {
                        $("#new_login").next(".erreur_message").show().text("Veuillez entrer un login valide");
                    }
                    else
                    {
                        $("#new_login").next(".erreur_message").hide().text("");
                    }
                })
                    
                $("#new_mdp").keyup(function()
                {
                    if(!$("#new_mdp").val().match(/^[^ -][a-zA-Z]{3,10}$/))
                    {
                        $("#new_mdp").next(".erreur_message").show().text("Veuillez entrer un mot de passe valide");
                    }
                    else
                    {
                        $("#new_mdp").next(".erreur_message").hide().text("");
                    }
                })

            })

        </script> 

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
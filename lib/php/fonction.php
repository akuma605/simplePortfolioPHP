<?php
//on requière le fichier config pour l'affichage des erreurs php (surtout sur pour les mac!:o))
require_once('config.php');

//fonction de la connection à la base de donnée
function connectBD()
{
	try
	{
		// connection à la BD
		$connection = new PDO('mysql:host=localhost; dbname=yassineportfolio', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

		//on prend l'UTF8 en compte
		$connection ->exec('SET NAMES UTF8');

		//renvoi des données de connection à la BD
		return $connection;
	}	

	//si problème la connection ne se fait pas et on affiche un message d'erreur
	catch(exception $e)
	{
		echo '<erreur>Erreur : Impossible de se connecter à la base de données, veuillez contacter votre administrateur!</erreur></br>';
		echo '<erreur>Erreur :'.$e->getMessage().'</erreur></br>';
		echo'<erreur>Erreur:'.$e->getCode().'</erreur>';

		//on sort de la connection
		exit();

	}
}
//fonction de mise en session
/*
*	ENTREE : RECOIS DES DONNEES EN TABLEAU	
*	SORTIE : LES DONNEES MISENT EN SESSION
*/
function setSession($data)
{
	$_SESSION['id_service']     = $data['id_service'];
	$_SESSION['nom_service']    = $data['nom_service'];
	$_SESSION['description_service'] = $data['description_service'];
	$_SESSION['prix_service']  	= $data['prix_service'];							
	$_SESSION['comment_service'] = $data['comment_service'];

}

//fonction pour créer les sessions avec les données de l'utilisateur
function createSession($donnee)
{
	$_SESSION['id']     			= $donnee['id'];
	$_SESSION['nom']    			= $donnee['nom'];
	$_SESSION['prenom'] 			= $donnee['prenom'];
	$_SESSION['sexe']  				= $donnee['sexe'];							
	$_SESSION['adresse']			= $donnee['adresse'];
	$_SESSION['cp']					= $donnee['cp'];
	$_SESSION['ville']				= $donnee['ville'];
	$_SESSION['pays']  				= $donnee['pays'];
	$_SESSION['mail']  				= $donnee['mail'];
	$_SESSION['login'] 				= $donnee['login'];
	$_SESSION['mdp']  				= $donnee['mdp'];
	$_SESSION['date_inscription']	= $donnee['date_inscription'];
	$_SESSION['admin'] 				= $donnee['admin'];
	$_SESSION['newsletter'] 		= $donnee['newsletter'];
	$_SESSION['ip']					= $donnee['ip'];
}

//fonction pour sécuriser les données: les espaces en trop & tabulation avec trim; l'élimination des slashes avec stripslashes; et l'interdiction des caractères html avec htmlspecialchars
function secureData( $donnee )
{
	$donnee = trim( $donnee );
	$donnee = stripslashes( $donnee );
	$donnee = htmlspecialchars( $donnee );

	//on renvoi les données sécurisés
	return $donnee;
}	

//fonction de login pour la connection au site
function login( $connection , $login , $mdp )
{
	try
	{
		//on lance la requête pour récupérer le login et le mot de passe de l'utilisateur
		$resultats = $connection->query('SELECT * FROM utilisateurs WHERE login="'.$login.'" AND mdp="'.$mdp.'"');
	
		//on vérifie si on a des résultats par ligne
		if( $resultats->rowCount() > 0 )
		{
			//update de l'adresse IP
			$connection->beginTransaction();
			$connection->exec('UPDATE utilisateurs SET ip="'.$_SERVER['REMOTE_ADDR'].'" WHERE login="'.$login.'" AND mdp="'.$mdp.'"');
			$connection->commit();

			//on récupère les données se trouvant dans la BD
			$resultats = $connection->query('SELECT * FROM utilisateurs WHERE login="'.$login.'" AND mdp="'.$mdp.'"');

			//mise des résultats dans un tableau 
			$tab = $resultats->fetch(PDO::FETCH_ASSOC);
			
			//appel de la la fonction qui crée la session utilisateur
			createSession( $tab );
		
			//on libére les résultats de la mémoire
			$resultats->closeCursor();		
			
			//on ferme la connexion
			unset( $connection );	

		
			if( !isset($_COOKIE['login']) )
			
			{	//s'il n'y a pas de cookie login, on en créé (cookie login et cookie mot de passe d'une durée de 7 jours)				
				setcookie('login',$_SESSION['login'],$GLOBALS['duree'],$GLOBALS['chemin'],$GLOBALS['domaine'],$GLOBALS['https'],$GLOBALS['httponly']); 
				setcookie('mdp',$_SESSION['mdp'],$GLOBALS['duree'],$GLOBALS['chemin'],$GLOBALS['domaine'],$GLOBALS['https'],$GLOBALS['httponly']); 
			}
			return true;
		}
		else
		{
			return false;
		}	
	}
	//si problème la connection ne se fait pas et on affiche un message d'erreur
	catch(PDOException $e) 
	{
		echo '<erreur>Erreur [0022]: Erreur lors de la requête, veuillez contacter votre administrateur!</erreur>';		
		echo '<erreur>Erreur : '.$e->getMessage().'</erreur><br/>';
		echo '<erreur>N° : '.$e->getCode().'</erreur><br/>';
		
		//on sort de la connection
		exit();
	} 	
}		

////////////////////////////////////Fonctions qui valide les champs d'un formulaire

// fontion qui valide le login
function valider_login($login)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_login'] = $login;	
	
	//login avec 3 à 10 caractéres alphabétiques
    if( !preg_match('/^[a-zA-Z]{3,10}$/', $login) )
	{
		$_SESSION['erreurform']       = true;
		$_SESSION['erreurform_login'] = '<erreur>Veuillez entrer un login valide!</erreur>';
	}
	else
	{
		$_SESSION['erreurform_login'] = '';
	}
}

//fonction qui valide le nom
function valider_nom($nom)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_nom'] = $nom;

	//nom avec 2 à 20 caractères et pas d'espace
	if(!preg_match("/^[^ -][a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð '-]{2,20}$/", $nom) )
	{
		$_SESSION['erreurform'] = true;
		$_SESSION ['erreurform_nom'] = '<erreur>Veuillez entrer un nom valide!</erreur>';
	}
	else
	{
		$_SESSION['erreurform_nom'] = '';
	}
}

//conftion qui valide le prénom
function valider_prenom($prenom)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_prenom'] = $prenom;

	// prénom avec 2 à 20 caractères et pas d'espaces
	if(!preg_match("/^[^ -][a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð '-]{4,20}$/", $prenom) )
	{
		$_SESSION['erreurform'] = true;
		$_SESSION ['erreurform_prenom'] = '<erreur>Veuillez enter un prénom valide!</erreur>';
	}
	else
	{
		$_SESSION['erreurform_prenom'] = '';
	}
}

//fonction qui valide le sexe
function valider_sexe($sexe)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_sexe']= $sexe;

	//choix du sexe de F=féminin et M=masculin
	if(!preg_match("/^[FM]{1}$/",$sexe))
	{
		$_SESSION['erreurform'] = true;
		$_SESSION ['erreurform_sexe'] = '<erreur>Veuillez choisir votre sexe!</erreur>';
	}
	else
	{
		echo $_SESSION ['erreurform_sexe'] = '';
	}
}

//fonction pour valider l'adresse. On demande juste que le champs ne soit pas vide.
function valider_adresse($adresse)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_adresse'] = $adresse;

	//si le champ est vide
	if( empty($adresse) )
	{
		$_SESSION['erreurform'] = true;
		$_SESSION ['erreurform_adresse'] = '<erreur>Veuillez remplir le champs!</erreur>';
	}
	else
	{
		echo $_SESSION ['erreurform_adresse'] = '';
	}
}

//fonction pour valider le code postale. On demande juste que le champs ne soit pas vide.
function valider_cp($cp)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si il faut revenir en arriére
	$_SESSION['form_cp']= $cp;

	//si le champ est vide
	if( empty($cp) )
		{
		$_SESSION['erreurcp'] = true;
		$_SESSION ['erreurform_cp'] = '<erreur>Veuillez remplir le champs!</erreur>';
	}
	else
	{
		echo $_SESSION ['erreurform_cp'] = '';
	}

}

//fonction pour valider l'adresse. On demande juste que le champs ne soit pas vide.
function valider_ville($ville)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_ville']= $ville;

	//si le champ est vide
	if( empty($ville) )
	{
		$_SESSION['erreurville'] = true;
		$_SESSION ['erreurform_ville'] = '<erreur>veuillez remplir le champs!</erreur>';
	}
	else
	{
		echo $_SESSION ['erreurform_ville'] = '';
	}
}


//fonction qui valide le pays
function valider_pays($pays)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_pays']= $pays;

	//on créer un tableau des pays -> voir la fonction creer_pays(), plus bas.
	$tabPays = creer_pays();

	//on vérifie si le code pays du formulaire est présent dans notre tableau $tabPays
	if(!array_key_exists($pays, $tabPays) )
	{
		$_SESSION['erreurform'] = true;
		$_SESSION['erreurform_pays'] = '<erreur>pays invalide</erreur>';
	}
	else
	{
		$_SESSION['erreurform_pays'] = '';
	}
}

//fonction qui valide l'email
function valider_mail($mail)
{
	//on sauvegarde les données
	$_SESSION['form_mail'] = $mail;
	
	if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9])+([a-zA-Z0-9\._-])*\.([a-zA-Z])+$/', $mail))
	{
		$_SESSION['erreurform'] = true;
		$_SESSION['erreurform_mail'] = '<erreur>Veuillez entrer un mail valide!';
	}

	else
	{
		$_SESSION['erreurform_mail'] = '';
	}
}


//fonction qui valide le mot de passe
function valider_mdp($mdp)
{
	//on sauvegarde les donnés dans les champs
	$_SESSION['form_mdp'] = $mdp;

	//mot de passe contenant de 3 à 8 caractères alphabétiques
	if(!preg_match('/^[a-zA-Z]{3,8}$/', $mdp))
	{
		$_SESSION['erreurform'] = true;
		$_SESSION['erreurform_mdp'] = '<erreur>Veuillez entrer un mot de passe valide</erreur>';

	}
	else
	{
		$_SESSION['erreurform_mdp'] = '';
	}

}

//fonction qui vérifie l'unicité du login
function verifier_login($login)
{
	//on sauvegarde les données dans les champs du formulaire
	$_SESSION['form_login'] = $login;

	//connection BD
	$connection = ConnectBD();
	//si on est connecté
	if($connection)
	{
		//on lance un select pour vérification si le login existe!
		$resultats=$connection->query('SELECT login FROM utilisateurs WHERE login ="'.$login.'" ');

		//si on a obtenu des résultat
		if($resultats -> rowCount() > 0)
		{
			//le login existe --> message d'erreur
			$_SESSION['erreurform']=true;
			$_SESSION['erreurform_login'] = '<erreur>le login existe déjà! veuillez en choisir un autre, SVP.</erreur>';
		}
		else
		{
			$_SESSION['erreurform_login'] = '';
		}
	}
	//message d'erreur si on n'arrive pas à se connecté à la BD
	else
	{
		$contenu = '<erreur>Impossible de se connecter à la base de donnée, veuillez contacter votre administrateur!</erreur>';

	}
}

//fonction qui créer le tableau des pays, pour éviter de tout taper dans son html.
function creer_pays()
{
	$tabPays = array(
	 'AF' => array('FR' => 'Afghanistan', 'EN' => 'Afghanistan'),
	 'ZA' => array('FR' => 'Afrique du Sud', 'EN' => 'South Africa'),
	 'AL' => array('FR' => 'Albanie', 'EN' => 'Albania'),
	 'DZ' => array('FR' => 'Algérie', 'EN' => 'Algeria'),
	 'DE' => array('FR' => 'Allemagne', 'EN' => 'Germany'),
	 'AD' => array('FR' => 'Andorre', 'EN' => 'Andorra'),
	 'AO' => array('FR' => 'Angola', 'EN' => 'Angola'),
	 'AI' => array('FR' => 'Anguilla', 'EN' => 'Anguilla'),
	 'AQ' => array('FR' => 'Antarctique', 'EN' => 'Antarctica'),
	 'AG' => array('FR' => 'Antigua-et-Barbuda', 'EN' => 'Antigua & Barbuda'),
	 'AN' => array('FR' => 'Antilles néerlandaises', 'EN' => 'Netherlands Antilles'),
	 'SA' => array('FR' => 'Arabie saoudite', 'EN' => 'Saudi Arabia'),
	 'AR' => array('FR' => 'Argentine', 'EN' => 'Argentina'),
	 'AM' => array('FR' => 'Arménie', 'EN' => 'Armenia'),
	 'AW' => array('FR' => 'Aruba', 'EN' => 'Aruba'),
	 'AU' => array('FR' => 'Australie', 'EN' => 'Australia'),
	 'AT' => array('FR' => 'Autriche', 'EN' => 'Austria'),
	 'AZ' => array('FR' => 'Azerbaïdjan', 'EN' => 'Azerbaijan'),
	 'BJ' => array('FR' => 'Bénin', 'EN' => 'Benin'),
	 'BS' => array('FR' => 'Bahamas', 'EN' => 'Bahamas, The'),
	 'BH' => array('FR' => 'Bahreïn', 'EN' => 'Bahrain'),
	 'BD' => array('FR' => 'Bangladesh', 'EN' => 'Bangladesh'),
	 'BB' => array('FR' => 'Barbade', 'EN' => 'Barbados'),
	 'PW' => array('FR' => 'Belau', 'EN' => 'Palau'),
	 'BE' => array('FR' => 'Belgique', 'EN' => 'Belgium'),
	 'BZ' => array('FR' => 'Belize', 'EN' => 'Belize'),
	 'BM' => array('FR' => 'Bermudes', 'EN' => 'Bermuda'),
	 'BT' => array('FR' => 'Bhoutan', 'EN' => 'Bhutan'),
	 'BY' => array('FR' => 'Biélorussie', 'EN' => 'Belarus'),
	 'MM' => array('FR' => 'Birmanie', 'EN' => 'Myanmar (ex-Burma)'),
	 'BO' => array('FR' => 'Bolivie', 'EN' => 'Bolivia'),
	 'BA' => array('FR' => 'Bosnie-Herzégovine', 'EN' => 'Bosnia and Herzegovina'),
	 'BW' => array('FR' => 'Botswana', 'EN' => 'Botswana'),
	 'BR' => array('FR' => 'Brésil', 'EN' => 'Brazil'),
	 'BN' => array('FR' => 'Brunei', 'EN' => 'Brunei Darussalam'),
	 'BG' => array('FR' => 'Bulgarie', 'EN' => 'Bulgaria'),
	 'BF' => array('FR' => 'Burkina Faso', 'EN' => 'Burkina Faso'),
	 'BI' => array('FR' => 'Burundi', 'EN' => 'Burundi'),
	 'CI' => array('FR' => 'Côte d\'Ivoire', 'EN' => 'Ivory Coast (see Cote d\'Ivoire)'),
	 'KH' => array('FR' => 'Cambodge', 'EN' => 'Cambodia'),
	 'CM' => array('FR' => 'Cameroun', 'EN' => 'Cameroon'),
	 'CA' => array('FR' => 'Canada', 'EN' => 'Canada'),
	 'CV' => array('FR' => 'Cap-Vert', 'EN' => 'Cape Verde'),
	 'CL' => array('FR' => 'Chili', 'EN' => 'Chile'),
	 'CN' => array('FR' => 'Chine', 'EN' => 'China'),
	 'CY' => array('FR' => 'Chypre', 'EN' => 'Cyprus'),
	 'CO' => array('FR' => 'Colombie', 'EN' => 'Colombia'),
	 'KM' => array('FR' => 'Comores', 'EN' => 'Comoros'),
	 'CG' => array('FR' => 'Congo', 'EN' => 'Congo'),
	 'KP' => array('FR' => 'Corée du Nord', 'EN' => 'Korea, Demo. People\'s Rep. of'),
	 'KR' => array('FR' => 'Corée du Sud', 'EN' => 'Korea, (South) Republic of'),
	 'CR' => array('FR' => 'Costa Rica', 'EN' => 'Costa Rica'),
	 'HR' => array('FR' => 'Croatie', 'EN' => 'Croatia'),
	 'CU' => array('FR' => 'Cuba', 'EN' => 'Cuba'),
	 'DK' => array('FR' => 'Danemark', 'EN' => 'Denmark'),
	 'DJ' => array('FR' => 'Djibouti', 'EN' => 'Djibouti'),
	 'DM' => array('FR' => 'Dominique', 'EN' => 'Dominica'),
	 'EG' => array('FR' => 'Égypte', 'EN' => 'Egypt'),
	 'AE' => array('FR' => 'Émirats arabes unis', 'EN' => 'United Arab Emirates'),
	 'EC' => array('FR' => 'Équateur', 'EN' => 'Ecuador'),
	 'ER' => array('FR' => 'Érythrée', 'EN' => 'Eritrea'),
	 'ES' => array('FR' => 'Espagne', 'EN' => 'Spain'),
	 'EE' => array('FR' => 'Estonie', 'EN' => 'Estonia'),
	 'US' => array('FR' => 'États-Unis', 'EN' => 'United States'),
	 'ET' => array('FR' => 'Éthiopie', 'EN' => 'Ethiopia'),
	 'FI' => array('FR' => 'Finlande', 'EN' => 'Finland'),
	 'FR' => array('FR' => 'France', 'EN' => 'France'),
	 'GE' => array('FR' => 'Géorgie', 'EN' => 'Georgia'),
	 'GA' => array('FR' => 'Gabon', 'EN' => 'Gabon'),
	 'GM' => array('FR' => 'Gambie', 'EN' => 'Gambia, the'),
	 'GH' => array('FR' => 'Ghana', 'EN' => 'Ghana'),
	 'GI' => array('FR' => 'Gibraltar', 'EN' => 'Gibraltar'),
	 'GR' => array('FR' => 'Grèce', 'EN' => 'Greece'),
	 'GD' => array('FR' => 'Grenade', 'EN' => 'Grenada'),
	 'GL' => array('FR' => 'Groenland', 'EN' => 'Greenland'),
	 'GP' => array('FR' => 'Guadeloupe', 'EN' => 'Guinea, Equatorial'),
	 'GU' => array('FR' => 'Guam', 'EN' => 'Guam'),
	 'GT' => array('FR' => 'Guatemala', 'EN' => 'Guatemala'),
	 'GN' => array('FR' => 'Guinée', 'EN' => 'Guinea'),
	 'GQ' => array('FR' => 'Guinée équatoriale', 'EN' => 'Equatorial Guinea'),
	 'GW' => array('FR' => 'Guinée-Bissao', 'EN' => 'Guinea-Bissau'),
	 'GY' => array('FR' => 'Guyana', 'EN' => 'Guyana'),
	 'GF' => array('FR' => 'Guyane française', 'EN' => 'Guiana, French'),
	 'HT' => array('FR' => 'Haïti', 'EN' => 'Haiti'),
	 'HN' => array('FR' => 'Honduras', 'EN' => 'Honduras'),
	 'HK' => array('FR' => 'Hong Kong', 'EN' => 'Hong Kong, (China)'),
	 'HU' => array('FR' => 'Hongrie', 'EN' => 'Hungary'),
	 'BV' => array('FR' => 'Ile Bouvet', 'EN' => 'Bouvet Island'),
	 'CX' => array('FR' => 'Ile Christmas', 'EN' => 'Christmas Island'),
	 'NF' => array('FR' => 'Ile Norfolk', 'EN' => 'Norfolk Island'),
	 'KY' => array('FR' => 'Iles Cayman', 'EN' => 'Cayman Islands'),
	 'CK' => array('FR' => 'Iles Cook', 'EN' => 'Cook Islands'),
	 'FO' => array('FR' => 'Iles Féroé', 'EN' => 'Faroe Islands'),
	 'FK' => array('FR' => 'Iles Falkland', 'EN' => 'Falkland Islands (Malvinas)'),
	 'FJ' => array('FR' => 'Iles Fidji', 'EN' => 'Fiji'),
	 'GS' => array('FR' => 'Iles Géorgie du Sud et Sandwich du Sud', 'EN' => 'S. Georgia and S. Sandwich Is.'),
	 'HM' => array('FR' => 'Iles Heard et McDonald', 'EN' => 'Heard and McDonald Islands'),
	 'MH' => array('FR' => 'Iles Marshall', 'EN' => 'Marshall Islands'),
	 'PN' => array('FR' => 'Iles Pitcairn', 'EN' => 'Pitcairn Island'),
	 'SB' => array('FR' => 'Iles Salomon', 'EN' => 'Solomon Islands'),
	 'SJ' => array('FR' => 'Iles Svalbard et Jan Mayen', 'EN' => 'Svalbard and Jan Mayen Islands'),
	 'TC' => array('FR' => 'Iles Turks-et-Caicos', 'EN' => 'Turks and Caicos Islands'),
	 'VI' => array('FR' => 'Iles Vierges américaines', 'EN' => 'Virgin Islands, U.S.'),
	 'VG' => array('FR' => 'Iles Vierges britanniques', 'EN' => 'Virgin Islands, British'),
	 'CC' => array('FR' => 'Iles des Cocos (Keeling)', 'EN' => 'Cocos (Keeling) Islands'),
	 'UM' => array('FR' => 'Iles mineures éloignées des États-Unis', 'EN' => 'US Minor Outlying Islands'),
	 'IN' => array('FR' => 'Inde', 'EN' => 'India'),
	 'ID' => array('FR' => 'Indonésie', 'EN' => 'Indonesia'),
	 'IR' => array('FR' => 'Iran', 'EN' => 'Iran, Islamic Republic of'),
	 'IQ' => array('FR' => 'Iraq', 'EN' => 'Iraq'),
	 'IE' => array('FR' => 'Irlande', 'EN' => 'Ireland'),
	 'IS' => array('FR' => 'Islande', 'EN' => 'Iceland'),
	 'IL' => array('FR' => 'Israël', 'EN' => 'Israel'),
	 'IT' => array('FR' => 'Italie', 'EN' => 'Italy'),
	 'JM' => array('FR' => 'Jamaïque', 'EN' => 'Jamaica'),
	 'JP' => array('FR' => 'Japon', 'EN' => 'Japan'),
	 'JO' => array('FR' => 'Jordanie', 'EN' => 'Jordan'),
	 'KZ' => array('FR' => 'Kazakhstan', 'EN' => 'Kazakhstan'),
	 'KE' => array('FR' => 'Kenya', 'EN' => 'Kenya'),
	 'KG' => array('FR' => 'Kirghizistan', 'EN' => 'Kyrgyzstan'),
	 'KI' => array('FR' => 'Kiribati', 'EN' => 'Kiribati'),
	 'KW' => array('FR' => 'Koweït', 'EN' => 'Kuwait'),
	 'LA' => array('FR' => 'Laos', 'EN' => 'Lao People\'s Democratic Republic'),
	 'LS' => array('FR' => 'Lesotho', 'EN' => 'Lesotho'),
	 'LV' => array('FR' => 'Lettonie', 'EN' => 'Latvia'),
	 'LB' => array('FR' => 'Liban', 'EN' => 'Lebanon'),
	 'LR' => array('FR' => 'Liberia', 'EN' => 'Liberia'),
	 'LY' => array('FR' => 'Libye', 'EN' => 'Libyan Arab Jamahiriya'),
	 'LI' => array('FR' => 'Liechtenstein', 'EN' => 'Liechtenstein'),
	 'LT' => array('FR' => 'Lituanie', 'EN' => 'Lithuania'),
	 'LU' => array('FR' => 'Luxembourg', 'EN' => 'Luxembourg'),
	 'MO' => array('FR' => 'Macao', 'EN' => 'Macao, (China)'),
	 'MG' => array('FR' => 'Madagascar', 'EN' => 'Madagascar'),
	 'MY' => array('FR' => 'Malaisie', 'EN' => 'Malaysia'),
	 'MW' => array('FR' => 'Malawi', 'EN' => 'Malawi'),
	 'MV' => array('FR' => 'Maldives', 'EN' => 'Maldives'),
	 'ML' => array('FR' => 'Mali', 'EN' => 'Mali'),
	 'MT' => array('FR' => 'Malte', 'EN' => 'Malta'),
	 'MP' => array('FR' => 'Mariannes du Nord', 'EN' => 'Northern Mariana Islands'),
	 'MA' => array('FR' => 'Maroc', 'EN' => 'Morocco'),
	 'MQ' => array('FR' => 'Martinique', 'EN' => 'Martinique'),
	 'MU' => array('FR' => 'Maurice', 'EN' => 'Mauritius'),
	 'MR' => array('FR' => 'Mauritanie', 'EN' => 'Mauritania'),
	 'YT' => array('FR' => 'Mayotte', 'EN' => 'Mayotte'),
	 'MX' => array('FR' => 'Mexique', 'EN' => 'Mexico'),
	 'FM' => array('FR' => 'Micronésie', 'EN' => 'Micronesia, Federated States of'),
	 'MD' => array('FR' => 'Moldavie', 'EN' => 'Moldova, Republic of'),
	 'MC' => array('FR' => 'Monaco', 'EN' => 'Monaco'),
	 'MN' => array('FR' => 'Mongolie', 'EN' => 'Mongolia'),
	 'MS' => array('FR' => 'Montserrat', 'EN' => 'Montserrat'),
	 'MZ' => array('FR' => 'Mozambique', 'EN' => 'Mozambique'),
	 'NP' => array('FR' => 'Népal', 'EN' => 'Nepal'),
	 'NA' => array('FR' => 'Namibie', 'EN' => 'Namibia'),
	 'NR' => array('FR' => 'Nauru', 'EN' => 'Nauru'),
	 'NI' => array('FR' => 'Nicaragua', 'EN' => 'Nicaragua'),
	 'NE' => array('FR' => 'Niger', 'EN' => 'Niger'),
	 'NG' => array('FR' => 'Nigeria', 'EN' => 'Nigeria'),
	 'NU' => array('FR' => 'Nioué', 'EN' => 'Niue'),
	 'NO' => array('FR' => 'Norvège', 'EN' => 'Norway'),
	 'NC' => array('FR' => 'Nouvelle-Calédonie', 'EN' => 'New Caledonia'),
	 'NZ' => array('FR' => 'Nouvelle-Zélande', 'EN' => 'New Zealand'),
	 'OM' => array('FR' => 'Oman', 'EN' => 'Oman'),
	 'UG' => array('FR' => 'Ouganda', 'EN' => 'Uganda'),
	 'UZ' => array('FR' => 'Ouzbékistan', 'EN' => 'Uzbekistan'),
	 'PE' => array('FR' => 'Pérou', 'EN' => 'Peru'),
	 'PK' => array('FR' => 'Pakistan', 'EN' => 'Pakistan'),
	 'PA' => array('FR' => 'Panama', 'EN' => 'Panama'),
	 'PG' => array('FR' => 'Papouasie-Nouvelle-Guinée', 'EN' => 'Papua New Guinea'),
	 'PY' => array('FR' => 'Paraguay', 'EN' => 'Paraguay'),
	 'NL' => array('FR' => 'Pays-Bas', 'EN' => 'Netherlands'),
	 'PH' => array('FR' => 'Philippines', 'EN' => 'Philippines'),
	 'PL' => array('FR' => 'Pologne', 'EN' => 'Poland'),
	 'PF' => array('FR' => 'Polynésie française', 'EN' => 'French Polynesia'),
	 'PR' => array('FR' => 'Porto Rico', 'EN' => 'Puerto Rico'),
	 'PT' => array('FR' => 'Portugal', 'EN' => 'Portugal'),
	 'QA' => array('FR' => 'Qatar', 'EN' => 'Qatar'),
	 'CF' => array('FR' => 'République centrafricaine', 'EN' => 'Central African Republic'),
	 'CD' => array('FR' => 'République démocratique du Congo', 'EN' => 'Congo, Democratic Rep. of the'),
	 'DO' => array('FR' => 'République dominicaine', 'EN' => 'Dominican Republic'),
	 'CZ' => array('FR' => 'République tchèque', 'EN' => 'Czech Republic'),
	 'RE' => array('FR' => 'Réunion', 'EN' => 'Reunion'),
	 'RO' => array('FR' => 'Roumanie', 'EN' => 'Romania'),
	 'GB' => array('FR' => 'Royaume-Uni', 'EN' => 'Saint Pierre and Miquelon'),
	 'RU' => array('FR' => 'Russie', 'EN' => 'Russia (Russian Federation)'),
	 'RW' => array('FR' => 'Rwanda', 'EN' => 'Rwanda'),
	 'SN' => array('FR' => 'Sénégal', 'EN' => 'Senegal'),
	 'EH' => array('FR' => 'Sahara occidental', 'EN' => 'Western Sahara'),
	 'KN' => array('FR' => 'Saint-Christophe-et-Niévès', 'EN' => 'Saint Kitts and Nevis'),
	 'SM' => array('FR' => 'Saint-Marin', 'EN' => 'San Marino'),
	 'PM' => array('FR' => 'Saint-Pierre-et-Miquelon', 'EN' => 'Saint Pierre and Miquelon'),
	 'VA' => array('FR' => 'Saint-Siège ', 'EN' => 'Vatican City State (Holy See)'),
	 'VC' => array('FR' => 'Saint-Vincent-et-les-Grenadines', 'EN' => 'Saint Vincent and the Grenadines'),
	 'SH' => array('FR' => 'Sainte-Hélène', 'EN' => 'Saint Helena'),
	 'LC' => array('FR' => 'Sainte-Lucie', 'EN' => 'Saint Lucia'),
	 'SV' => array('FR' => 'Salvador', 'EN' => 'El Salvador'),
	 'WS' => array('FR' => 'Samoa', 'EN' => 'Samoa'),
	 'AS' => array('FR' => 'Samoa américaines', 'EN' => 'American Samoa'),
	 'ST' => array('FR' => 'Sao Tomé-et-Principe', 'EN' => 'Sao Tome and Principe'),
	 'SC' => array('FR' => 'Seychelles', 'EN' => 'Seychelles'),
	 'SL' => array('FR' => 'Sierra Leone', 'EN' => 'Sierra Leone'),
	 'SG' => array('FR' => 'Singapour', 'EN' => 'Singapore'),
	 'SI' => array('FR' => 'Slovénie', 'EN' => 'Slovenia'),
	 'SK' => array('FR' => 'Slovaquie', 'EN' => 'Slovakia'),
	 'SO' => array('FR' => 'Somalie', 'EN' => 'Somalia'),
	 'SD' => array('FR' => 'Soudan', 'EN' => 'Sudan'),
	 'LK' => array('FR' => 'Sri Lanka', 'EN' => 'Sri Lanka (ex-Ceilan)'),
	 'SE' => array('FR' => 'Suède', 'EN' => 'Sweden'),
	 'CH' => array('FR' => 'Suisse', 'EN' => 'Switzerland'),
	 'SR' => array('FR' => 'Suriname', 'EN' => 'Suriname'),
	 'SZ' => array('FR' => 'Swaziland', 'EN' => 'Swaziland'),
	 'SY' => array('FR' => 'Syrie', 'EN' => 'Syrian Arab Republic'),
	 'TW' => array('FR' => 'Taïwan', 'EN' => 'Taiwan'),
	 'TJ' => array('FR' => 'Tadjikistan', 'EN' => 'Tajikistan'),
	 'TZ' => array('FR' => 'Tanzanie', 'EN' => 'Tanzania, United Republic of'),
	 'TD' => array('FR' => 'Tchad', 'EN' => 'Chad'),
	 'TF' => array('FR' => 'Terres australes françaises', 'EN' => 'French Southern Territories - TF'),
	 'IO' => array('FR' => 'Territoire britannique de l\'Océan Indien', 'EN' => 'British Indian Ocean Territory'),
	 'TH' => array('FR' => 'Thaïlande', 'EN' => 'Thailand'),
	 'TL' => array('FR' => 'Timor Oriental', 'EN' => 'Timor-Leste (East Timor)'),
	 'TG' => array('FR' => 'Togo', 'EN' => 'Togo'),
	 'TK' => array('FR' => 'Tokélaou', 'EN' => 'Tokelau'),
	 'TO' => array('FR' => 'Tonga', 'EN' => 'Tonga'),
	 'TT' => array('FR' => 'Trinité-et-Tobago', 'EN' => 'Trinidad & Tobago'),
	 'TN' => array('FR' => 'Tunisie', 'EN' => 'Tunisia'),
	 'TM' => array('FR' => 'Turkménistan', 'EN' => 'Turkmenistan'),
	 'TR' => array('FR' => 'Turquie', 'EN' => 'Turkey'),
	 'TV' => array('FR' => 'Tuvalu', 'EN' => 'Tuvalu'),
	 'UA' => array('FR' => 'Ukraine', 'EN' => 'Ukraine'),
	 'UY' => array('FR' => 'Uruguay', 'EN' => 'Uruguay'),
	 'VU' => array('FR' => 'Vanuatu', 'EN' => 'Vanuatu'),
	 'VE' => array('FR' => 'Venezuela', 'EN' => 'Venezuela'),
	 'VN' => array('FR' => 'ViÃªt Nam', 'EN' => 'Viet Nam'),
	 'WF' => array('FR' => 'Wallis-et-Futuna', 'EN' => 'Wallis and Futuna'),
	 'YE' => array('FR' => 'Yémen', 'EN' => 'Yemen'),
	 'YU' => array('FR' => 'Yougoslavie', 'EN' => 'Saint Pierre and Miquelon'),
	 'ZM' => array('FR' => 'Zambie', 'EN' => 'Zambia'),
	 'ZW' => array('FR' => 'Zimbabwe', 'EN' => 'Zimbabwe'),
	 'MK' => array('FR' => 'ex-République yougoslave de Macédoine', 'EN' => 'Macedonia, TFYR')
	);
	
	return $tabPays;
}

//fonction qui valide la newsletter
function valider_newsletter($newsletter)
{
	//on sauvegarde les données du champ, dans une session, si il y a une erreur et si 'il faut revenir en arriére
	$_SESSION['form_newsletter']= $newsletter;

	//choix de oui et non
	if(!preg_match("/^[OuiNon]{3}$/",$newsletter))
	{
		$_SESSION['erreurform'] = true;
		$_SESSION ['erreurform_newsletter'] = '<erreur>Veuillez choisir!</erreur>';
	}
	else
	{
		echo $_SESSION ['erreurform_newsletter'] = '';
	}
}

?>
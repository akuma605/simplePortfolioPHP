-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 24 Avril 2017 à 06:46
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `yassineportfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `mail` varchar(50) COLLATE utf8_bin NOT NULL,
  `prix` int(11) NOT NULL,
  `date_commande` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `titre` varchar(50) COLLATE utf8_bin NOT NULL,
  `detail` varchar(2000) COLLATE utf8_bin NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `services`
--

INSERT INTO `services` (`id`, `titre`, `detail`, `prix`) VALUES
(1, '<h1>Création de sites Internet</h1>', '<div class="large-6 columns"> <div style="padding: 10px 0 10px 0;"> <p>La création de site Internet est plus qu\'une simple vitrine pour votre entreprise.<br/> C\'est une façon de concevoir votre relation avec vos partenaires, clients, prospects.</p> <p>Du site vitrine, au catalogue de produits, en passant par des sites d\'e-commerce, nous développon une large gamme de solution </p>   <h2>Web Design &amp; Site internet</h2> <ul class="liste"> <li><strong>Design UI</strong> :&nbsp;Conception d’interface utilisateur</li> <li>Création de site Internet</li> <li><strong>Responsive</strong> webdesign (optimisée pour mobiles &amp; tablettes)</li> <li>Intégration HTML5 / CSS3 /JS, validation W3C</li> <li>Prototypage et élaboration de&nbsp;<strong>wireframes </strong>(zoning)</li> <li>Gestion du site par <strong>CMS</strong></li> <li>Optimisation des performances</li> </ul>  <h2>Méthodologie web</h2> <ul class="liste"> <li>Rencontre client</li> <li>Réalisation visuelle &amp interactive</li> <li>Développement dynamique</li> <li>Test du site web</li> </ul>  <h2>Solutions web</h2> <ul class="liste"> <li>Sites e-commerce</li> <li>Intranet</li> <li>Blog</li> <li>Bannières</li> <li>Site Internet Flash</li> </ul><p>Nos prix varient en fonction de la demande.<br/> Les prix indiqués sont des prix minimaux et à titre informatifs.<br/> Un devis précis sera remis, après un briefing détaillé. Aucune commande ne sera effectives sans accord au préalable du devis.</p></div></div>', 1500),
(2, '<h1>Applications mobiles</h1>', '<div class="large-6 columns"> <div style="padding: 10px 0 10px 0;"> <p>Je conçois des interfaces modernes pour vous aider à rendre votre site efficace, accessible et agréable à utiliser sur tous les supports.</p>  <h2>Développement d\'applications pour smartphones et tablettes: IOS, Android....</h2> <ul class="liste"> <li>Ergonomie web</li> <li>Design d\'interfaces</li> <li>Expérience utilisateur</li> </ul><p>Nos prix varient en fonction de la demande.<br/> Les prix indiqués sont des prix minimaux et à titre informatifs.<br/> Un devis précis sera remis, après un briefing détaillé. Aucune commande ne sera effectives sans accord au préalable du devis.</p>  </div> </div>', 1000),
(3, '<h1>Graphisme et Identité visuelle</h1>', '<div id="content>"<div class="large-6 columns"> <div style="padding: 10px 0 10px 0;">  <p>Votre identité visuelle est une représentation graphique qui est propre à votre entreprise ou à votre activité. Elle s’exprime par un choix de formes, de signes, de couleurs, par une mise en page et une typographie particulière.</p>  <h2> Création d\'identité visuelle.</h2> <ul class="liste">   <li>Logo.</li> <li>Charte graphique.</li> <li>Typographie.</li> </ul> <p>Nos prix varient en fonction de la demande.<br/> Les prix indiqués sont des prix minimaux et à titre informatifs.<br/> Un devis précis sera remis, après un briefing détaillé. Aucune commande ne sera effectives sans accord au préalable du devis.</p> </div> </div> ', 500),
(4, '<h1>Webmarketing SEO</h1>', '<div class="large-6 columns"> <div style="padding: 10px 0 10px 0;">  <p>Votre site en 1ère page des moteurs de recherche, référencement naturel, e-mailing...</p>  <h2>Votre site en 1ère page des moteurs de recherche, référencement naturel, e-mailing...</h2> <ul class="liste">   <li>Référencement du site Internet.</li> <li>Optimisation du positionnement du site Internet.</li> <li>Suivi de positionnement.</ul> <p>Nos prix varient en fonction de la demande.<br/> Les prix indiqués sont des prix minimaux et à titre informatifs.<br/> Un devis précis sera remis, après un briefing détaillé. Aucune commande ne sera effectives sans accord au préalable du devis.</p> </div> </div>', 1000);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) CHARACTER SET latin1 NOT NULL,
  `prenom` varchar(50) CHARACTER SET latin1 NOT NULL,
  `sexe` char(1) CHARACTER SET latin1 NOT NULL,
  `adresse` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cp` int(6) NOT NULL,
  `ville` varchar(50) CHARACTER SET latin1 NOT NULL,
  `pays` varchar(50) CHARACTER SET latin1 NOT NULL,
  `mail` varchar(50) CHARACTER SET latin1 NOT NULL,
  `login` varchar(50) CHARACTER SET latin1 NOT NULL,
  `mdp` varchar(50) CHARACTER SET latin1 NOT NULL,
  `date_inscription` date NOT NULL,
  `newsletter` char(3) CHARACTER SET latin1 NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `ip` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 11 Janvier 2015 à 13:33
-- Version du serveur :  5.5.38
-- Version de PHP :  5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `pufhcm_it`
--

-- --------------------------------------------------------

--
-- Structure de la table `caracterise`
--

CREATE TABLE `caracterise` (
  `idIntervenant` int(11) NOT NULL,
  `idStatut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `caracterise`
--

INSERT INTO `caracterise` (`idIntervenant`, `idStatut`) VALUES
(1, 1),
(2, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(5, 2),
(6, 1),
(7, 1),
(7, 2),
(8, 1),
(9, 1),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(13, 1),
(14, 1),
(14, 2),
(15, 1),
(15, 2),
(16, 1),
(16, 2),
(17, 1),
(18, 1),
(18, 2),
(19, 1),
(20, 1),
(20, 2),
(21, 1),
(21, 2);

-- --------------------------------------------------------

--
-- Structure de la table `compose`
--

CREATE TABLE `compose` (
  `idFormation` int(11) NOT NULL,
  `idSemestre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `compose`
--

INSERT INTO `compose` (`idFormation`, `idSemestre`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `contenu`
--

CREATE TABLE `contenu` (
`id` int(11) NOT NULL,
  `libelle` text COLLATE utf8_unicode_ci NOT NULL,
  `FR` text COLLATE utf8_unicode_ci NOT NULL,
  `ENG` text COLLATE utf8_unicode_ci NOT NULL,
  `idPage` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `contenu`
--

INSERT INTO `contenu` (`id`, `libelle`, `FR`, `ENG`, `idPage`) VALUES
(1, '1er paragraphe page d''accueil', 'blablablablablablablablabla balbalbla blablabla bla blabalbalbalablab', 'bliblibliblibliblibli blibliblibli bli blibilbiliblilbi', 1),
(3, '1er paragraphe page Licence', 'Le Vietnam connaît actuellement un développement économique considérable dans tous les domaines professionnels. Dans ce contexte, les technologies de l’information constituent un levier essentiel dans la modernisation de l’économie vietnamienne. Les entreprises installées au Vietnam, qu’elles soient publiques ou privées, vietnamiennes ou internationales, ressentent aujourd’hui un besoin crucial d’informaticiens de haut niveau. La licence d''informatique s''adresse aux étudiants intéressés par l''informatique sous tous ses aspects. Elle vise à en donner les bases tant théoriques que pratiques. Les diplômés de cette licence seront immédiatement opérationnels dans des métiers nombreux et variés ou bien pourront continuer des études en master d''informatique. Trois diplômes peuvent être obtenus au sein du cycle Licence d''informatique : un DUT Informatique, une Licence Professionnelle Systèmes Informatiques et Logiciels, une Licence de Sciences et Technologies mention Informatique.', '', 3),
(4, 'test1', 'zzz', '', 1),
(5, 'bidon', 'yyy', '', 1),
(6, 'pararagraphe test etu', 'Ceci est un test !', '', 4);

-- --------------------------------------------------------

--
-- Structure de la table `encadrement`
--

CREATE TABLE `encadrement` (
  `idMission` int(11) NOT NULL,
  `idIntervenant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `encadrement`
--

INSERT INTO `encadrement` (`idMission`, `idIntervenant`) VALUES
(25, 4),
(26, 5),
(26, 5),
(28, 9),
(29, 13),
(24, 3);

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
`id` int(11) NOT NULL,
  `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `coef` int(11) NOT NULL,
  `date` date NOT NULL,
  `idMission` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `type`, `coef`, `date`, `idMission`) VALUES
(12, 'ExamenCours', 0, '2015-01-09', 24),
(13, 'ExamenCours', 4, '2015-01-09', 25),
(14, 'ExamenCours', 3, '2014-11-27', 26),
(15, 'null', 0, '0000-00-00', 27),
(16, 'null', 0, '0000-00-00', 28),
(17, 'NoteTD', 0, '0000-00-00', 29),
(18, 'NoteProjet', 5, '2014-12-16', 30),
(19, 'null', 0, '0000-00-00', 31),
(21, 'null', 0, '0000-00-00', 33);

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
`id` int(11) NOT NULL,
  `libelle` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `formation`
--

INSERT INTO `formation` (`id`, `libelle`) VALUES
(1, 'Licence Pro DAWIN'),
(2, 'Master Info');

-- --------------------------------------------------------

--
-- Structure de la table `intervenant`
--

CREATE TABLE `intervenant` (
`id` int(11) NOT NULL,
  `nom` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `intervenant`
--

INSERT INTO `intervenant` (`id`, `nom`, `email`) VALUES
(1, 'M.Airouche', 'm.airouche@gmail.com'),
(2, 'G.Passault', 'g.passault@labri.com'),
(3, 'Mme.Rouet', 'rouet@iut.com'),
(4, 'C.Sutour', 'c.sutour@iut.com'),
(5, 'Mr.Ramet', 'ramet@labri.fr'),
(6, 'Mme.Vialard', 'vialard@labri.fr'),
(7, 'N.Journet', 'journet@labri.fr'),
(8, 'Mr.Thomassin', 'thomassin@gmail.com'),
(9, 'Mme.Brachet', 'brachet@iut.com'),
(10, 'Mr.Rubi', 'rubi@labri.fr'),
(11, 'Mr.Perrot', 'perrot@labri.fr'),
(12, 'Mme.Uny', 'uny@iut.com'),
(13, 'Mme.Curval', 'curval@iut.com'),
(14, 'Mr.Casteigts', 'casteigts@iut.com'),
(15, 'Mr.Benard', 'benard@iut.com'),
(16, 'Mr.Fosse', 'fosse@iut.com'),
(17, 'Mme.Fitton', 'fitton@iut.com'),
(18, 'Mr.LeLevier', 'lelevier@cube.com'),
(19, 'Mr.Jardry', 'jardry@iut.com'),
(20, 'Mr.Kulpa', 'kulpa@iut.com'),
(21, 'Mr.Gilbert', 'gilbert@iut.com');

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
`id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `fiche` text COLLATE utf8_unicode_ci NOT NULL,
  `idModule` int(11) NOT NULL,
  `idFormation` int(11) NOT NULL,
  `backgroundColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `textColor` varchar(7) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `mission`
--

INSERT INTO `mission` (`id`, `title`, `start`, `end`, `fiche`, `idModule`, `idFormation`, `backgroundColor`, `textColor`) VALUES
(24, 'Anglais LP', '2014-09-29', '2015-01-15', '', 5, 1, '#f20ef2', '#000000'),
(25, 'Geometrie Algo Lin LP', '2014-09-08', '2014-12-09', '', 3, 1, '#9e7ee0', '#000000'),
(26, 'POO LP', '2014-09-09', '2014-11-05', '', 1, 1, '#ce7ee0', '#000000'),
(27, 'Qualité LP', '2014-09-12', '2014-10-04', '', 9, 1, '#00ddff', '#000000'),
(28, 'Ergonomie', '2014-09-16', '2014-09-25', '', 10, 1, '#ff00fb', '#000000'),
(29, 'Communication LP', '2014-09-23', '2014-11-26', '', 17, 1, '#00ff80', '#000000'),
(30, 'Dvlp Android LP', '2014-10-02', '2015-01-16', '', 14, 1, '#bfff00', '#000000'),
(31, 'test', '2015-01-01', '2015-01-31', '', 1, 1, '#333333', '#ffffff'),
(33, 'test3', '2015-01-05', '2015-01-10', '', 1, 1, '#045c0f', '#ffffff');

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE `module` (
`id` int(11) NOT NULL,
  `libelle` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `idSemestre` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `module`
--

INSERT INTO `module` (`id`, `libelle`, `idSemestre`) VALUES
(1, 'POO', 1),
(2, 'Web', 1),
(3, 'Algo', 1),
(4, 'traitement image', 2),
(5, 'Anglais', 1),
(6, 'Anglais', 2),
(7, 'Base de données', 1),
(8, 'Algo', 2),
(9, 'Qualité', 1),
(10, 'Ergonomie', 1),
(11, 'Gestion de projet', 1),
(12, 'OpenGL', 1),
(13, 'WebGL', 2),
(14, 'Android', 1),
(15, 'Android', 2),
(16, 'Panorama', 1),
(17, 'Communication', 1),
(18, 'jQuery', 1),
(19, 'JEE', 1),
(20, '.Net', 1),
(21, '.Net', 2),
(22, 'Modélisation', 1),
(23, 'Modélisation', 2),
(24, 'Php', 1),
(25, 'Php', 2),
(26, 'Management projet', 2),
(27, 'Conduite Reunion', 2),
(28, 'Animation', 2);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE `page` (
`id` int(11) NOT NULL,
  `libelle` text COLLATE utf8_unicode_ci NOT NULL,
  `path` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`id`, `libelle`, `path`) VALUES
(1, 'page d''accueil', ''),
(2, 'page master', 'master'),
(3, 'page licence', 'licence'),
(4, 'page vous êtes etudiants', 'etudiant'),
(5, 'page vous êtes professionnels', 'professionnel');

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

CREATE TABLE `semestre` (
`id` int(11) NOT NULL,
  `libelle` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `semestre`
--

INSERT INTO `semestre` (`id`, `libelle`) VALUES
(1, 'semestre1'),
(2, 'semestre2');

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
`id` int(11) NOT NULL,
  `libelle` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `statut`
--

INSERT INTO `statut` (`id`, `libelle`) VALUES
(1, 'enseignant'),
(2, 'chargeTD');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
`id` int(11) NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `mdp` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `mdp`, `admin`) VALUES
(1, 'yanick.servant@free.fr', 'c236e3a64dadde1a78913489f020cb23', 1),
(2, 'lucas.montion@gmail.com', '509e0244c8020a36a80f4aa95df65c64', 0),
(3, 'jquery', '*DD8A11E135D7BC246CE8D6B7B7BF89100AFEE6D1', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `caracterise`
--
ALTER TABLE `caracterise`
 ADD KEY `idStatut` (`idStatut`), ADD KEY `idIntervenant` (`idIntervenant`);

--
-- Index pour la table `compose`
--
ALTER TABLE `compose`
 ADD KEY `idSemestre` (`idSemestre`), ADD KEY `idFormation` (`idFormation`);

--
-- Index pour la table `contenu`
--
ALTER TABLE `contenu`
 ADD PRIMARY KEY (`id`), ADD KEY `idPage` (`idPage`);

--
-- Index pour la table `encadrement`
--
ALTER TABLE `encadrement`
 ADD KEY `idMission` (`idMission`), ADD KEY `idIntervenant` (`idIntervenant`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
 ADD PRIMARY KEY (`id`), ADD KEY `idMission` (`idMission`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `intervenant`
--
ALTER TABLE `intervenant`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_missionModule` (`idModule`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
 ADD PRIMARY KEY (`id`), ADD KEY `idSemestre` (`idSemestre`);

--
-- Index pour la table `page`
--
ALTER TABLE `page`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contenu`
--
ALTER TABLE `contenu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `intervenant`
--
ALTER TABLE `intervenant`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT pour la table `mission`
--
ALTER TABLE `mission`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT pour la table `page`
--
ALTER TABLE `page`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `semestre`
--
ALTER TABLE `semestre`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `caracterise`
--
ALTER TABLE `caracterise`
ADD CONSTRAINT `caracterise_ibfk_1` FOREIGN KEY (`idStatut`) REFERENCES `statut` (`id`),
ADD CONSTRAINT `caracterise_ibfk_2` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`id`);

--
-- Contraintes pour la table `compose`
--
ALTER TABLE `compose`
ADD CONSTRAINT `compose_ibfk_1` FOREIGN KEY (`idSemestre`) REFERENCES `semestre` (`id`),
ADD CONSTRAINT `compose_ibfk_2` FOREIGN KEY (`idFormation`) REFERENCES `formation` (`id`);

--
-- Contraintes pour la table `contenu`
--
ALTER TABLE `contenu`
ADD CONSTRAINT `contenu_ibfk_1` FOREIGN KEY (`idPage`) REFERENCES `page` (`id`);

--
-- Contraintes pour la table `encadrement`
--
ALTER TABLE `encadrement`
ADD CONSTRAINT `encadrement_ibfk_1` FOREIGN KEY (`idMission`) REFERENCES `mission` (`id`),
ADD CONSTRAINT `encadrement_ibfk_2` FOREIGN KEY (`idIntervenant`) REFERENCES `intervenant` (`id`);

--
-- Contraintes pour la table `evaluation`
--
ALTER TABLE `evaluation`
ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`idMission`) REFERENCES `mission` (`id`);

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
ADD CONSTRAINT `fk_missionModule` FOREIGN KEY (`idModule`) REFERENCES `module` (`id`);

--
-- Contraintes pour la table `module`
--
ALTER TABLE `module`
ADD CONSTRAINT `module_ibfk_1` FOREIGN KEY (`idSemestre`) REFERENCES `semestre` (`id`);

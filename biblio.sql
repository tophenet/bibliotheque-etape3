-- SOURCE C:\wamp64\www\bdd\biblio-etape2-3\bibliotheque.sql
SET NAMES utf8;

DROP DATABASE IF EXISTS biblio;
CREATE DATABASE biblio CHARACTER SET 'utf8';

USE biblio;

-- DROP TABLE IF EXISTS theme;
-- DROP TABLE IF EXISTS livres;
-- DROP TABLE IF EXISTS livres_theme;
-- DROP TABLE IF EXISTS `utilisateur`;

START TRANSACTION;

CREATE TABLE livres (
   id int NOT NULL AUTO_INCREMENT,
   titre varchar(150) NOT NULL,
   nb int NOT NULL,
   nbPages int NOT NULL,
   image varchar(150) NOT NULL,
   description text NOT NULL,
  PRIMARY KEY (id)
)ENGINE=InnoDB;
INSERT INTO `livres` (`id`, `titre`, `nb`, `nbPages`, `image`, `description`) VALUES
(1, 'Les quatre accords toltèques', 1, 1602, 'tolteques.jpg', 'Castaneda a fait découvrir au grand public les enseignements des chamans mexicains qui ont pour origine la tradition toltèque, gardienne des connaissances de Quetzacoatl, le serpent à plumes. Dans ce livre, Don Miguel révèle la source des croyances limi-tatrices qui nous privent de joie et créent des souffrances inutiles. br/ br/ Il montre en des termes très simples comment on peut se libérer du conditionnement collectif - le rêve de la planète, basé sur la peur - afin de retrouver la dimension d\'amour inconditionnel qui est à notre origine et constitue le fondement des enseignements toltèques. br/ br/ Les quatre accords proposent un puissant code de conduite capable de transformer rapidement notre vie en une expérience de liberté, de vrai bonheur et d\'amour. Le monde fascinant de la Connaissance véritable et incarnée est enfin à la portée de chacun.'),
(2, 'Saturne', 6, 466, 'saturne.jpg', 'Sa fille est encore un bébé quand Harry meurt à 34 ans dans des circonstances tragiques. Il est issu d’une grande lignée de médecins contraints à l’exil au moment de l’indépendance de l’Algérie, et qui ont rebâti un empire médical en France. L’aîné, Armand, mettra ses pas dans ceux de sa famille. Mais la passion de Harry pour une femme à la beauté incendiaire fera voler en éclats les reliques d’un royaume où l’argent coule à flots. Saturne dépeint le crépuscule d’un monde et de ses dieux. C’est aussi un roman sur l’épreuve de nos deuils, et une grande histoire d’amour : celle d’une enfant guettée par la folie et la mort, mais qui est devenue écrivain parce que, une nuit, elle en avait fait la promesse au fantôme de son père.\n\r\n      Sarah Chiche est l’auteure de plusieurs romans et essais. Son quatrième roman, Saturne, sélectionné par les prix littéraires les plus prestigieux, a rencontré un grand succès public et critique.'),
(3, 'Tout le bleu du ciel', 14, 642, 'ciel.jpg', 'Petitesannonces.fr : Jeune homme de 26 ans, condamné à une espérance de vie de deux ans par un Alzheimer précoce, souhaite prendre le large pour un ultime voyage. Recherche compagnon(ne) pour partager avec moi ce dernier périple.\n\r\n    Émile a décidé de fuir l’hôpital, la compassion de sa famille et de ses amis. À son propre étonnement, il reçoit une réponse à cette annonce. Trois jours plus tard, devant le camping-car acheté secrètement, il retrouve Joanne, une jeune femme coiffée d’un grand chapeau noir qui a pour seul bagage... '),
(4, 'Kilomètre zéro', 2, 246, 'kilometre.jpg', 'Maëlle, directrice financière d\'une start-up en pleine expansion, n\'a tout simplement pas le temps pour les rêves. Mais quand sa meilleure amie, Romane, lui demande un immense service - question de vie ou de mort -, elle accepte malgré elle de rejoindre le Népal. Elle ignore que l\'ascension des Annapurnas qu\'elle s\'apprête à faire sera aussi le début d\'un véritable parcours initiatique.Au cours d\'expériences et de rencontres bouleversantes, Maëlle va apprendre les secrets du bonheur profond et transformer sa vie. Mais... '),
(5, 'Le tourbillon de la vie', 8, 326, 'tourbillon.jpg', 'Au cours d\'un été, Arthur et son petit-fils décident de rattraper les années perdues. Plus de soixante ans les séparent, mais, ensemble, ils vont partager les souvenirs de l\'un et les rêves de l\'autre. Le bonheur serait total si Arthur ne portait pas un lourd secret…Un roman sur le temps qui passe, la transmission et les plaisirs simples qui font le sel de la vie.Entre émotion, rire et nostalgie, Aurélie Valognes nous touche en plein cœur.Humanité et bienveillance. Une parenthèse enchantée. CNews.Ce récit tendre et plein d... '),
(6, 'Je revenais des autres', 12, 304, 'autres.jpg', 'Philippe a quarante ans, est directeur commercial, marié et père de deux enfants. Ambre a vingt ans, n’est rien et n’a personne. Sauf lui. Quand, submergée par le vide de sa vie, elle essaie de mourir, Philippe l’envoie loin, dans un village de montagne, pour qu’elle se reconstruise, qu’elle apprenne à vivre sans lui. Pour sauver sa famille aussi.\r\n    Je revenais des autres est l’histoire d’un nouveau départ. Le feuilleton d’un hôtel où vit une bande de saisonniers tous un peu abîmés par la vie. Le récit de leurs amitiés,... '),
(7, 'Rien ne t\'efface', 4, 162, 'efface.jpg', 'C\'était il y a dix ans. Jour pour jour.\r\n    Un matin d\'été, sur la plage de Saint-Jean-de-Luz, le petit Esteban disparaissait.\r\n    Maddi, sa mère, ne s\'est jamais pardonné d\'avoir baissé la garde. Et puis, dix ans plus tard, même plage, même âge : ce garçon qui lui ressemble tant... Même silhouette de crevette, même maillot indigo, même tache de naissance. Sosie ? Jumeau ? Pour Maddi, aucun doute : ce garçon, ce Tom, c\'est son fils – Esteban réincarné. Pour le suivre, le protéger, elle laissera tout derrière elle. Car rien ne... '),
(8, 'Ces femmes qui aiment trop', 6, 248, 'trop.jpg', 'Les femmes qui aiment trop sont attirées par des hommes troubles, distants, aux humeurs changeantes, parfois alcooliques, infidèles ou obsédés par leur travail. Les femmes qui aiment trop trouvent les hommes biens plutôt ennuyeux et tombent sur des hommes qui ne parviennent pas à les aimer en retour. Les femmes qui aiment trop se sentent vides sans ces hommes mais tourmentées en leur présence. A travers des récits authentiques et personnels, Robin Norwood nous plonge au coeur des rouages psychologiques qui amènent tant de femmes à s\'enfermer dans des relations compliquées ou destructrices. Indispensable et bouleversant, ce livre aidera toutes les femmes à briser le cercle infernal de la dépendance amoureuse et de l\'échec pour redevenir elles-mêmes et s\'aimer mieux pour mieux aimer.'),
(9, 'L\'Étranger', 8, 420, 'etranger.jpg', 'Quand la sonnerie a encore retenti, que la porte du box s\'est ouverte, c\'est le silence de la salle qui est monté vers moi, le silence, et cette singulière sensation que j\'ai eue lorsque j\'ai constaté que le jeune journaliste avait détourné les yeux. Je n\'ai pas regardé du côté de Marie. Je n\'en ai pas eu le temps parce que le président m\'a dit dans une forme bizarre que j\'aurais la tête tranchée sur une place publique au nom du peuple français..'),
(10, 'Lait et miel', 10, 162, 'miel.jpg', 'lait et miel est un recueil poétique que toutes les femmes devraient avoir sur leur table de nuit ou la table basse de leur salon. Accompagnés de ses propres dessins, ses poèmes, d\'une honnêteté et d\'une authenticité rares, se lisent comme les expériences collectives et quotidiennes d\'une femme du... '),
(11, 'Séquences mortelles', 18, 468, 'mortelles.jpg', 'L’illustre Jack McEvoy, devenu journaliste pour un site web de défense des consommateurs, a eu raison de bien des assassins. Jusqu\'au jour où il est accusé de meurtre par deux inspecteurs du LAPD. Et leurs arguments ont du poids : il aurait tué une certaine Tina Portrero, avec laquelle il a effectivement passé une nuit. Malgré les interdictions de la police et de son propre patron, il enquête et découvre que d\'autres femmes sont mortes de la même et parfaitement horrible façon : le cou brisé. Le tueur, il le comprend aussi,... ');

CREATE  TABLE  IF NOT  EXISTS  utilisateur (
login varchar(50) NOT NULL,
  password varchar(100) NOT NULL,
  mail varchar(100) NOT NULL,
  role varchar(50) NOT NULL,
  image varchar(100),
  est_valide tinyint(1) NOT NULL,
  clef varchar(50), 
  PRIMARY KEY (login)
) ENGINE=InnoDB;
INSERT INTO `utilisateur` (`login`, `password`, `mail`, `role`, `image`, `est_valide`) VALUES
('admin','$2y$10$Z.NV5jhY4Emy2XRJlbVnJ.uWsmeJkOB06xKq5Eb8ml9QapXUOJOmm','ctouti@gmail.com','administrateur','profils/profil.png',1),
('abonne', '$2y$10$pF2pLd2Cs8tuQv2kKonj/ujHiQf6s.Tuo5ZmKxcy927GN11iyxpIC', 'ctouti@gmail.com', 'abonne', 'profils/profil.png', 1),
('hugo', '$2y$10$Fapf2t9/GpnUK/k.JCWH3eOU/DezeKmMW0ed9dGvWkKhdp1dEWj/O', 'ctouti@gmail.com', 'abonne', 'profils/profil.png', 1),
('tophe', '$2y$10$1wRqiw9qcMXT2lD69DQgpetpq2GuzNN8pqLqa0hFQAg9kL6PiIKYa', 'ctouti@gmail.com', 'abonne', 'profils/profil.png', 1);

CREATE TABLE utilisateur_livre_emprunter(
        idEmprunt Int  Auto_increment  NOT NULL ,
        idLivre   Int NOT NULL ,
        login     Varchar (50) NOT NULL ,
        date_pret DateTime NOT NULL , 
        date_retour DateTime ,
	CONSTRAINT utilisateur_livre_emprunter_PK PRIMARY KEY (idEmprunt) ,
	CONSTRAINT utilisateur_livre_emprunter_livre_FK FOREIGN KEY (idLivre) REFERENCES livres(id) ,
	CONSTRAINT utilisateur_livre_emprunter_utilisateur0_FK FOREIGN KEY (login) REFERENCES utilisateur(login)
)ENGINE=InnoDB;

COMMIT;


<?php
ini_set('display_errors', 1);

//Fonction qui permet de se connecter a la base de donnees
function connexion(){
  $host = "localhost";
  $user = "root";
  $password = "Iroise29";
  $dbname = "TestMedinov";

  $mysqli = new mysqli($host, $user, $password, $dbname);
  if ($mysqli->connect_errno) {
      echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      return($mysqli->connect_errno);
  }
  return $mysqli;
}

//Fonction qui permet de créer la table RoleUtilisateur
function create_table_role(){
  $sql="CREATE TABLE IF NOT EXISTS RoleUtilisateur(
  id char(1),
  libelle varchar(9) NOT NULL,
  PRIMARY KEY (id)
  ) ENGINE=InnoDB;";

  return $sql;
}

//Fonction qui permet de creer la table Utilisateur
function create_table_utilisateur(){
  $sql="CREATE TABLE IF NOT EXISTS Utilisateur (
    id int(11) NOT NULL AUTO_INCREMENT,
    nom varchar(60),
    prenom varchar(60),
    adresse varchar(250),
    cp char(5),
    ville char(50),
    dateEmbauche date,
    login varchar(20),
    password varchar(60),
    roleUtilisateur char(1),
    PRIMARY KEY (id),
    CONSTRAINT fk_Role FOREIGN KEY (roleUtilisateur) REFERENCES RoleUtilisateur(id)
  ) ENGINE=InnoDB;";

  return $sql;
}

//Fonction qui permet de creer la table Etat
function create_table_etat(){
  $sql="CREATE TABLE IF NOT EXISTS Etat (
    id char(2) NOT NULL,
    libelle varchar(30) DEFAULT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB;";

  return $sql;
}

//Fonction qui permet de creer la table FicheFrais
function create_table_fichefrais(){
  $sql="CREATE TABLE IF NOT EXISTS FicheFrais (
    id int(11) NOT NULL AUTO_INCREMENT,
    idVisiteur int(11) DEFAULT NULL,
    mois tinyint(2) unsigned DEFAULT NULL,
    annee int(4) unsigned DEFAULT NULL,
    nbJustificatifs int(11) DEFAULT NULL,
    montantValide decimal(10,2) DEFAULT NULL,
    dateModif date DEFAULT NULL,
    idEtat char(2) DEFAULT NULL,
    PRIMARY KEY (idVisiteur, mois, annee),
    UNIQUE (id),
    CONSTRAINT fk_Visiteur FOREIGN KEY (idVisiteur) REFERENCES Utilisateur(id),
    CONSTRAINT fk_Etat FOREIGN KEY (idEtat) REFERENCES Etat(id)
  ) ENGINE=InnoDB;";

  return $sql;
}

//Fonction qui permet de creer la table Forfait
function create_table_forfait(){
  $sql="CREATE TABLE IF NOT EXISTS Forfait (
    id varchar(3) NOT NULL,
    libelle varchar(20) DEFAULT NULL,
    montant decimal(5,2) DEFAULT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB;";

  return $sql;
}

//Fonction qui permet de creer la table LigneFraisForfait
function create_table_lignefraisforfait() {
  $sql = "CREATE TABLE IF NOT EXISTS LigneFraisForfait (
    idFicheFrais int(11) NOT NULL,
    idForfait varchar(3) NOT NULL,
    quantite int(11) UNSIGNED,
    PRIMARY KEY (idFicheFrais, idForfait),
    CONSTRAINT fk_Forfait FOREIGN KEY (idForfait) REFERENCES Forfait(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_FicheFrais FOREIGN KEY (idFicheFrais) REFERENCES FicheFrais(id) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB;";

  return $sql;
}

//Fonction qui permet de remplir la table Etat
function insert_into_etat(){
  $sql="INSERT INTO Etat (id, libelle) VALUES
    ('RB', 'Remboursee'),
    ('CL', 'Saisie Cloturee'),
    ('CR', 'Fiche creee, saisie en cours'),
    ('VA', 'Validee et mise en paiement');";

  return $sql;
}

//Fonction qui permet de remplir la table Forfait
function insert_into_forfait(){
  $sql="INSERT INTO Forfait (id, libelle, montant) VALUES
    ('ETP', 'Forfait Etape', 110.00),
    ('KM', 'Frais Kilometrique', 0.62),
    ('NUI', 'Nuitee Hotel', 80.00),
    ('REP', 'Repas Restaurant', 25.00);";

  return $sql;
}

//Fonction qui permet de remplir la table Role
function insert_into_role(){
  $sql="INSERT INTO RoleUtilisateur VALUES
    ('V', 'Visiteur'),
    ('C', 'Comptable'),
    ('A', 'Admin');";

    return $sql;
}
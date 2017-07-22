drop database if exists TachesEmployes;
create database TachesEmployes;
USE TachesEmployes

CREATE TABLE Tache (
	id int AUTO_INCREMENT NOT NULL,
	libelle varchar(255),	
	heureDebut time,
	heureFin time,
	completed tinyint(1) not null,
	Primary key(id)
);

CREATE TABLE Employe (
	id int AUTO_INCREMENT NOT NULL,
	nom varchar(30),	
	Primary key (id)
);

CREATE TABLE Repartition (
	idEmploye int NOT NULL,
	idTache int NOT NULL,	
	Primary key(idEmploye,idTache),
	FOREIGN KEY (idEmploye) REFERENCES Employe(id),
	FOREIGN KEY (idTache) REFERENCES Tache(id)
);


GRANT ALL PRIVILEGES ON TachesEmployes.* TO adminTE@'localhost' IDENTIFIED BY '' WITH GRANT OPTION;

insert into Tache(libelle,heureDebut,heureFin,completed) values ('rediger cahier des charges','08:00:00','11:00:00',0);
insert into Tache(libelle,heureDebut,heureFin,completed) values ('élaborer tests unitaires','14:00:00','16:00:00',0);
insert into Employe(nom) values ("Bernard");
insert into Employe(nom) values ("Toto");
insert into Repartition(idEmploye,idTache) values (1,2);
insert into Repartition(idEmploye,idTache) values (2,1);
-- création script base de donnée vivehotel

create database if not exists vivehotel default character set utf8 collate utf8_general_ci;
use vivehotel; 

set foreign_key_checks = 0;

-- création table client 

drop table if exists client;
create table client (
    cli_id int auto_increment primary key, 
    cli_nom varchar(500) not null, 
    cli_identifiant varchar(500) not null,
    cli_mdp varchar(500) not null, 
    cli_email varchar(500) not null    
)engine=innodb; 

-- création table personnel

drop table if exists personnel;
create table personnel (
    per_id int auto_increment primary key,
    per_nom varchar(500) not null,
    per_identifiant varchar(500) not null,
    per_mdp varchar(500) not null,
    per_email varchar(500) not null,
    per_role varchar(500) not null,
    per_hotel int not null
)engine=innodb; 

-- création table hotel 

drop table if exists hotel;
create table hotel (
    hot_id int auto_increment primary key,    
    hot_statut varchar(500) not null,
    hot_nom varchar(500) not null,
    hot_adresse varchar(500) not null,
    hot_departement varchar(500) not null,
    hot_description text not null,
    hot_longitude int not null,
    hot_latitude int not null,
    hot_hocategorie int not null
)engine=innodb; 

-- création table chambre 

drop table if exists chambre;
create table chambre (
    cha_id int auto_increment primary key,
    cha_numero varchar(500) not null,
    cha_statut varchar(500) not null,
    cha_surface int not null,    
    cha_typelit1 varchar(500) not null, 
    cha_typelit2 varchar(500) not null,
    cha_description text not null,
    cha_jacuzzi boolean not null,
    cha_balcon boolean not null,
    cha_wifi boolean not null,
    cha_minibar boolean not null,
    cha_coffre boolean not null,
    cha_vue boolean not null,
    cha_chcategorie int not null 
)engine=innodb; 

-- création table services 
drop table if exists services;
create table services (
    ser_id int auto_increment primary key,
    ser_nom varchar(500) not null    
)engine=innodb; 

-- création table Categorie_chambre 
drop table if exists chcategorie;
create table chcategorie (
    chc_id int auto_increment primary key,
    chc_categorie varchar(500) not null    
)engine=innodb; 

-- création table categorie_hotel 
drop table if exists hocategorie;
create table hocategorie (
    hoc_id int auto_increment primary key,
    hoc_categorie varchar(500) not null    
)engine=innodb;

drop table if exists reservation;
create table reservation (
    res_id int auto_increment primary key,
    res_date_creation datetime not null,
    res_date_debut datetime not null,
    res_date_maj datetime not null,
    res_date_fin datetime not null,
    res_etat varchar(500) not null, 
    res_client int not null, 
    res_hotel int not null, 
    res_chambre int not null
)engine=innodb;

-- création table commander 
drop table if exists commander;
create table commander (
    com_id int auto_increment primary key,
    com_quantite int not null,
    com_services int not null, 
    com_reservation int not null 
)engine=innodb;

-- création table proposer 
drop table if exists proposer;
create table proposer (
    pro_id int auto_increment primary key,
    pro_prix float not null,
    pro_hotel int not null, 
    pro_services int not null
)engine=innodb;

-- création table tarifer 
drop table if exists tarifer;
create table tarifer (
    tar_id int auto_increment primary key,
    tar_prix float not null,
    tar_hocategorie int not null, 
    tar_chcategorie int not null
)engine=innodb;

set foreign_key_checks =1;

-- contraintes d'intrégritées 

alter table personnel add constraint cs1 foreign key (per_hotel) references hotel(hot_id) on delete cascade;
alter table hotel add constraint cs2 foreign key (hot_hocategorie) references hocategorie(hoc_id) on delete cascade;
alter table chambre add constraint cs3 foreign key (cha_chcategorie) references chcategorie(chc_id) on delete cascade;
alter table reservation add constraint cs4 foreign key (res_client) references client(cli_id) on delete cascade;
alter table reservation add constraint cs5 foreign key (res_hotel) references hotel(hot_id) on delete cascade;
alter table reservation add constraint cs6 foreign key (res_chambre) references chambre(cha_id) on delete cascade;
alter table commander add constraint cs7 foreign key (com_services) references services(ser_id) on delete cascade;
alter table commander add constraint cs8 foreign key (com_reservation) references reservation(res_id) on delete cascade;
alter table proposer add constraint cs9 foreign key (pro_hotel) references hotel(hot_id) on delete cascade;
alter table proposer add constraint cs10 foreign key (pro_services) references services(ser_id) on delete cascade;
alter table tarifer add constraint cs11 foreign key (tar_hocategorie) references hocategorie(hoc_id) on delete cascade;
alter table tarifer add constraint cs12 foreign key (tar_chcategorie) references chcategorie(chc_id) on delete cascade;


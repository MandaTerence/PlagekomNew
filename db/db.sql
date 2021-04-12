use plagekom;
CREATE TABLE personnel (
    Matricule varchar(10) Primary key,
    Date_d_embauche date,			 			 	
	Nom 	varchar(250) ,	   		 			   	
	Prenom 	varchar(250) ,	   		 			   	
	Date_de_naissance 	date, 			 			   	
	Lieu_de_naissance 	varchar(50), 	   		 			   	
	Sexe 	varchar(10), 	   		 			   	
	Situation_Matrimoniale 	varchar(10), 	   		 			   	
	Nombre_d_enfant 	int(2), 			   	
	Cin_personnel 	varchar(15), 	   		 			   	
	Date_cin_personnel 	date,		 			     
	Lieu_delivrance_du_cin_personnel 	varchar(100), 	   		 			   
	Date_duplicata_cin_personnel 	date ,		
	Lieu_de_dupliacata_cin_personnel 	varchar(100),   				   	
	Adresse_du_personnel 	varchar(100), 			   	
	Contact_du_personnel 	varchar(10),	   		 			   	
	Nom_et_prenom_du_tuteur 	varchar(250),  		 			   	
	Lien_de_parente 	varchar(50),	 			   	
	Cin_du_tuteur 	varchar(15),		   	
	Date_de_delivrance_cin_tuteur 	date,		 			   	
	Adresse_du_tuteur 	varchar(100),		 			   	
	Contact_du_tuteur 	varchar(10),		 			   	
	Fonction_a_l_embauche 	int(3),	 			   	
	Fonction_actuelle 	int(3),			   	
	Mode_de_pass_login 	varchar(11),		 			   	
	statut  varchar(50)
);
CREATE TABLE fonction (
	id INT Primary KEY,
	designation varchar(250) NOT NULL	
);
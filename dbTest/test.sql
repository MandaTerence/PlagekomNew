Select * from malus join malus_detail on malus_detail.Id_malus = malus.Id;


select COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA 
from `facture` 
    inner join `detailvente` on `detailvente`.`Facture` = `facture`.`id` 
    inner join `prix` on `detailvente`.`ID_prix` = `prix`.`Id` 
    inner join `produit` on `produit`.`Code_produit` = `prix`.`Code_produit` 
    inner join `mission` on `mission`.`Id_de_la_mission` like `facture`.`Id_de_la_mission` 
where `facture`.`Matricule_personnel` like 'VP00080'
and `Produit`.`Designation` like 'BE NICE FEMININE CLEANSING GOLD'

select ''

select
    `Produit`.`Designation`,(detailvente.Quantite * prix.Prix_detail) as prix
    from `facture`
    inner join `detailvente` on `detailvente`.`Facture` = `facture`.`id`
    inner join `prix` on `detailvente`.`ID_prix` = `prix`.`Id`
    inner join `produit` on `produit`.`Code_produit` = `prix`.`Code_produit`
    inner join `mission` on `mission`.`Id_de_la_mission` like `facture`.`Id_de_la_mission`
where `facture`.`Matricule_personnel` like 'VP00080'
;



SELECT
    sum(dv.Quantite * pr.Prix_detail) as prix
FROM 
    facture f
    JOIN    detailvente dv on dv.Facture = f.id
    JOIN    prix pr on dv.ID_prix = pr.Id 
where
    Matricule_personnel like 'VP00080'
    
    and Date BETWEEN '10/10/2020' and NOW()

CREATE TABLE classement(

);

CREATE TABLE classement(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    place SMALLINT NOT NULL,
    Id_de_la_mission VARCHAR(60) NOT NULL,
    Commercial VARCHAR(60) NOT NULL
);
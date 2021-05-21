select
    *
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix like prix.Id
    and Status like '' 
    limit 2
;

select
    sum(prix.Prix_detail*detailvente.Quantite)
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix like prix.Id
    where Facture.Matricule_personnel like 'VP00080'
    and Status IS NULL
;

select
    sum(prix.Prix_detail*detailvente.Quantite)
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix like prix.Id
    where Facture.Ress_sec_oplg like 'VP21039'
    and Status like 'livre'
;

select SUM(Eng+Pospect+Client_fidel)
from pointressource 
JOIN facture ON pointressource.Id_facture like facture.Id_facture
WHERE Matricule like 'VP00080'
AND YEAR(facture.Date) like 2021
AND MONTH(facture.Date) in (3,4);

select distinct 
    detailmission.personnel as Matricule
from mission 
JOIN detailmission
    on detailmission.Id_de_la_mission = mission.Id_de_la_mission
where statut like 'En_cours'
AND Type_de_mission like 'MISSION'
UNION DISTINCT
select distinct
    equipe_temporaire.matricule_personnel as Matricule
from mission 
JOIN equipe_temporaire
    on equipe_temporaire.Id_de_la_mission = equipe_temporaire.Id_de_la_mission
where statut like 'En_cours'
AND Type_de_mission like 'MISSION';

select distinct Id_de_la_mission from facture where Matricule_personnel like 'VP12087';

select  
    Sum(DATEDIFF(Date_de_fin, Date_depart)+1-FLOOR(DATEDIFF(Date_de_fin,Date_depart)/7)) as jourMissionTotal
from
    mission
where Id_de_la_mission in (select distinct Id_de_la_mission from facture where Matricule_personnel like 'VP21037');
;

select  
    Sum(DATEDIFF(Date_de_fin, Date_depart)+1-FLOOR(DATEDIFF(Date_de_fin,Date_depart)/7)) as jourMissionTotal
from
    facture
join mission
    ON facture.Id_de_la_mission like mission.Id_de_la_mission
where facture.Matricule_personnel like 'VP12087'
;

select count(distinct Date) from facture where Matricule_personnel like 'VP12087';

select (DATEDIFF(Date_de_fin, Date_depart)+1-FLOOR(DATEDIFF(Date_de_fin,Date_depart)/7)) as jourMissionTotal from mission


select Id_de_la_mission from facture where Matricule_personnel like 'VP21125' and where Id_de_la_mission in (select Id_de_la_mission from mission);

SELECT
    p.Matricule,
    p.Nom,
    p.Prenom,
    Sum(d.Quantite * pr.Prix_detail) as CA,
    count(distinct f.Date) as jourTravail,
FROM personnel p
JOIN facture f 
    ON f.Matricule_personnel like p.Matricule
JOIN detailvente d
    ON d.Facture = f.id
JOIN prix pr
    ON d.ID_prix = pr.Id
JOIN mission ms
    ON ms.Id_de_la_mission = f.Id_de_la_mission
WHERE p.Fonction_actuelle like 1 OR  p.Fonction_actuelle like 6
GROUP BY p.Matricule,p.Nom,p.Prenom
ORDER BY CA DESC
;

SELECT
    p.Matricule,
    p.Nom,
    p.Prenom,
    Sum(d.Quantite * pr.Prix_detail) as CA,
    count(distinct f.Date) as jourTravail
FROM personnel p
JOIN facture f 
    ON f.Matricule_personnel like p.Matricule
JOIN detailvente d
    ON d.Facture = f.id
JOIN prix pr
    ON d.ID_prix = pr.Id
WHERE p.Fonction_actuelle like 1 OR  p.Fonction_actuelle like 6
GROUP BY p.Matricule,p.Nom,p.Prenom
ORDER BY CA DESC
;

DB::table('facture')
    ->where('facture.Matricule_personnel','like',$this->Matricule)
    ->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
    ->select(DB::raw('COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA'))
    ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
    ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')

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
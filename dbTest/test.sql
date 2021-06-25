


-- annuel: 12,13,14,15,17

-- indemnite: 7,2,6,4

--first day of the month
And facture.Date between '2021-05-25' and '2021-06-24'

select
    facture.Date
from facture
where facture.Matricule_personnel = 'VT00005'
;

where facture.Date between '2021-05-25' and '2021-06-24'

select
    COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA,date,Id_zone
from facture
join detailvente on detailvente.Facture = facture.id
join prix on detailvente.ID_prix = prix.Id
And facture.Date between '2021-05-26' and '2021-06-25'

where facture.Matricule_personnel = 'VP21317'

group By facture.date,Id_zone
;



$ventes = DB::table('facture')
->where('facture.Matricule_personnel',$this->Matricule)
->whereBetween('facture.Date', [$interval->firstDate,$interval->lastDate])
->selectRaw("COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA,date,Id_zone")
->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
->groupBy('date','Id_zone')

SELECT
    sum(detailvente.Quantite * prix.Prix_detail)
FROM facture
join detailvente on detailvente.Facture = facture.id
join prix on detailvente.ID_prix = prix.Id
where facture.Matricule_personnel = 'VP00080'
and facture.date between '2021-05-1' and '2021-06-18'
group by date
;




$ventes = DB::table('facture')
        ->where('facture.Matricule_personnel',$this->Matricule)
        ->whereRaw("MONTH(CURRENT_DATE()) = MONTH(date)")
        ->whereRaw("YEAR(CURRENT_DATE()) = YEAR(date)")
        ->selectRaw("COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA,date,Id_zone")
        ->join('detailvente', 'detailvente.Facture', '=', 'facture.id')
        ->join('prix', 'detailvente.ID_prix', '=', 'prix.Id')
        ->groupBy('date','Id_zone')
        ->get();

select
    *
from malus_detail
join malus on malus.Id = malus_detail.Id_malus
;

SELECT
    COALESCE(SUM(detailvente.Quantite * prix.Prix_detail),0) as CA,date,Id_zone
FROM facture
join detailvente on detailvente.Facture = facture.id
join prix on detailvente.ID_prix = prix.Id
where facture.Matricule_personnel = 'VP00080'
And MONTH(CURRENT_DATE()) = MONTH(date)
And YEAR(CURRENT_DATE()) = YEAR(date)
group By date,Id_zone
;

select
    count(distinct Date)
from
    facture
where
    Month(Date) = Month(CURRENT_DATE)
;

select * 
from
    facture
join 
;

select
    detailmission.Date_d_activation,
    Type_de_mission
from detailmission
join mission on mission.Id_de_la_mission = detailmission.Id_de_la_mission
where detailmission.personnel = 'VP00080'
order by Date_d_activation desc
limit 1;

select
    distinct Date
from
    facture
where
    Matricule_personnel = 'VP00080'
AND 
    Month(Date) = Month(CURRENT_DATE)
;

select
    Sum(DATEDIFF(Date_de_fin, DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY))+1-FLOOR(DATEDIFF(Date_de_fin,Date_depart)/7)) as jourMission
from mission
where statut = 'En_cours';

select * 
from Privilege_detail
where Id_type_privilege = 2
and Id_privilege = 9
;

select count(distinct Date) as jourTravail
from facture
join mission on facture.Id_de_la_mission = mission.Id_de_la_mission

select count(distinct Date) as jourTravail
from facture
join mission on facture.Id_de_la_mission = mission.Id_de_la_mission


select coalesce(sum(valeur),0)
from Privilege_detail
    where Id_privilege = 9
    and Id_type_privilege = 1
;

select
    sum(detailvente.Quantite)
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix = prix.Id
    where 
    (Facture.Ress_sec_oplg = 'VP00080'
    and Status like 'livre'
    and MONTH(facture.Date) = MONTH(CURRENT_DATE())
    and YEAR(Date) = YEAR(CURRENT_DATE())
    )
    OR
    (Facture.Matricule_personnel = 'VP00080'
    and Status like ''
    and MONTH(facture.Date) = MONTH(CURRENT_DATE())
    and YEAR(Date) = YEAR(CURRENT_DATE())
    )
;
-- vente terrain
select
    sum(prix.Prix_detail*detailvente.Quantite)
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix = prix.Id
    where Facture.Matricule_personnel = 'VP00080'
    and Status like ''
    and MONTH(facture.Date) = MONTH(CURRENT_DATE())
    and YEAR(Date) = YEAR(CURRENT_DATE())
;

-- vente FB
select
    sum(prix.Prix_detail*detailvente.Quantite)
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix = prix.Id
    where Facture.Ress_sec_oplg = 'VP00080'
    and Status like 'livre'
    and MONTH(facture.Date) = MONTH(CURRENT_DATE())
    and YEAR(Date) = YEAR(CURRENT_DATE())
;
-- vente terrain
select
    sum(prix.Prix_detail*detailvente.Quantite)
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix = prix.Id
    where Facture.Matricule_personnel = 'VP00080'
    and Status like ''
    and MONTH(facture.Date) = MONTH(CURRENT_DATE())
    and YEAR(Date) = YEAR(CURRENT_DATE())
;

select
    *
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix = prix.Id
    and Status like '' 
    limit 2
;

select
    sum(prix.Prix_detail*detailvente.Quantite)
    from facture 
    join detailvente on detailvente.Facture = facture.Id
    join prix on detailvente.Id_prix = prix.Id
    where Facture.Matricule_personnel = 'VP00080'
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
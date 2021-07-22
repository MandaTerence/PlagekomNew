CREATE TABLE equipe_temporaire (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Id_de_la_mission VARCHAR(60) NOT NULL REFERENCES mission(Id_de_la_mission),
    matricule_personnel VARCHAR(60) NOT NULL REFERENCES personnel(Matricule),
    type VARCHAR(20) NOT NULL
);
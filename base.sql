PRAGMA foreign_keys = ON;



CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'ADMIN',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (nom, username, password)
VALUES (
    'Administrateur',
    'admin',
    '1234567890'
);



CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefix TEXT NOT NULL UNIQUE
);

INSERT INTO prefixes(prefix) VALUES
('033'),
('037');


CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT NOT NULL UNIQUE,
    solde REAL NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO clients (telephone, solde) VALUES
('0331234567',500000),
('0339876543',150000),
('0371111111',80000),
('0379999999',250000);



CREATE TABLE operation_types (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL UNIQUE
);

INSERT INTO operation_types(nom)
VALUES
('Depot'),
('Retrait'),
('Transfert');


CREATE TABLE baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operation_type_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    frais REAL NOT NULL,

    FOREIGN KEY(operation_type_id)
        REFERENCES operation_types(id)
);

-- Dépôt : gratuit
INSERT INTO baremes(operation_type_id,montant_min,montant_max,frais)
VALUES
(1,0,999999999,0);

-- Retrait
INSERT INTO baremes(operation_type_id,montant_min,montant_max,frais)
VALUES
(2,100,1000,50),
(2,1001,5000,50),
(2,5001,10000,100),
(2,10001,25000,200),
(2,25001,50000,400),
(2,50001,100000,800),
(2,100001,250000,1500),
(2,250001,500000,1500),
(2,500001,1000000,2500),
(2,1000001,2000000,3000);

-- Transfert
INSERT INTO baremes(operation_type_id,montant_min,montant_max,frais)
VALUES
(3,100,1000,50),
(3,1001,5000,50),
(3,5001,10000,100),
(3,10001,25000,200),
(3,25001,50000,400),
(3,50001,100000,800),
(3,100001,250000,1500),
(3,250001,500000,1500),
(3,500001,1000000,2500),
(3,1000001,2000000,3000);


CREATE TABLE operations (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    operation_type_id INTEGER NOT NULL,

    expediteur_id INTEGER,

    destinataire_id INTEGER,

    montant REAL NOT NULL,

    frais REAL NOT NULL DEFAULT 0,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(operation_type_id)
        REFERENCES operation_types(id),

    FOREIGN KEY(expediteur_id)
        REFERENCES clients(id),

    FOREIGN KEY(destinataire_id)
        REFERENCES clients(id)
);

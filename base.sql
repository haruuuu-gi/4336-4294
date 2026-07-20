PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    nom         VARCHAR(100) NOT NULL,
    login       VARCHAR(50) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    role        VARCHAR(20) NOT NULL DEFAULT 'admin',
    actif       INTEGER NOT NULL DEFAULT 1,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_users_login ON users(login);


DROP TABLE IF EXISTS clients;
CREATE TABLE clients (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone   VARCHAR(15) NOT NULL UNIQUE,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX idx_clients_telephone ON clients(telephone);

DROP TABLE IF EXISTS prefixes;
CREATE TABLE prefixes (
    id                  INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe             VARCHAR(3) NOT NULL UNIQUE,
    actif               INTEGER NOT NULL DEFAULT 1,
    commission_percent  DECIMAL(5,2) NOT NULL DEFAULT 1.00,
    created_at          DATETIME DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS operation_types;
CREATE TABLE operation_types (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    code        VARCHAR(20) NOT NULL UNIQUE,
    libelle     VARCHAR(50) NOT NULL,
    actif       INTEGER NOT NULL DEFAULT 1
);

DROP TABLE IF EXISTS baremes;
CREATE TABLE baremes (
    id                  INTEGER PRIMARY KEY AUTOINCREMENT,
    operation_type_id   INTEGER NOT NULL,
    montant_min         DECIMAL(15,2) NOT NULL,
    montant_max         DECIMAL(15,2) NOT NULL,
    frais               DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (operation_type_id) REFERENCES operation_types(id) ON DELETE CASCADE
);
CREATE INDEX idx_baremes_type ON baremes(operation_type_id);

DROP TABLE IF EXISTS comptes;
CREATE TABLE comptes (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id   INTEGER NOT NULL UNIQUE,
    solde       DECIMAL(15,2) NOT NULL DEFAULT 0,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS operations;
CREATE TABLE operations (
    id                  INTEGER PRIMARY KEY AUTOINCREMENT,
    compte_id           INTEGER NOT NULL,
    compte_dest_id      INTEGER NULL,
    telephone_dest      VARCHAR(15) NULL,
    operation_type_id   INTEGER NOT NULL,
    montant             DECIMAL(15,2) NOT NULL,
    frais               DECIMAL(15,2) NOT NULL DEFAULT 0,
    commission          DECIMAL(15,2) NOT NULL DEFAULT 0,
    solde_apres         DECIMAL(15,2) NOT NULL,
    created_at          DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (compte_id) REFERENCES comptes(id),
    FOREIGN KEY (compte_dest_id) REFERENCES comptes(id),
    FOREIGN KEY (operation_type_id) REFERENCES operation_types(id)
);
CREATE INDEX idx_operations_compte ON operations(compte_id);
CREATE INDEX idx_operations_type ON operations(operation_type_id);

DROP VIEW IF EXISTS v_gains_par_type;
CREATE VIEW v_gains_par_type AS
SELECT
    ot.id           AS operation_type_id,
    ot.libelle      AS operation,
    COUNT(o.id)     AS nb_operations,
    COALESCE(SUM(o.frais), 0) AS total_frais
FROM operation_types ot
LEFT JOIN operations o ON o.operation_type_id = ot.id
GROUP BY ot.id, ot.libelle;

DROP VIEW IF EXISTS v_comptes_clients;
CREATE VIEW v_comptes_clients AS
SELECT
    cp.id,
    cl.telephone,
    cp.solde,
    cp.created_at,
    (SELECT COUNT(*) FROM operations o WHERE o.compte_id = cp.id) AS nb_operations
FROM comptes cp
JOIN clients cl ON cl.id = cp.client_id;


INSERT INTO prefixes (prefixe, actif, commission_percent) VALUES ('033', 1, 1.00), ('037', 1, 1.00), ('034', 1, 1.00), ('032', 1, 1.00), ('038', 1, 1.00);

INSERT INTO users (nom, login, password, role, actif) VALUES
    ('Administrateur', 'admin', 'admin123', 'admin', 1);

INSERT INTO operation_types (code, libelle, actif) VALUES
    ('depot', 'Dépôt', 1),
    ('retrait', 'Retrait', 1),
    ('transfert', 'Transfert', 1);

INSERT INTO baremes (operation_type_id, montant_min, montant_max, frais) VALUES
    (2, 100,      1000,    50),
    (2, 1001,     5000,    50),
    (2, 5001,     10000,   100),
    (2, 10001,    25000,   200),
    (2, 25001,    50000,   400),
    (2, 50001,    100000,  800),
    (2, 100001,   250000,  1500),
    (2, 250001,   500000,  1500),
    (2, 500001,   1000000, 2500),
    (2, 1000001,  2000000, 3000),

    (3, 100,      1000,    50),
    (3, 1001,     5000,    50),
    (3, 5001,     10000,   100),
    (3, 10001,    25000,   200),
    (3, 25001,    50000,   400),
    (3, 50001,    100000,  800),
    (3, 100001,   250000,  1500),
    (3, 250001,   500000,  1500),
    (3, 500001,   1000000, 2500),
    (3, 1000001,  2000000, 3000);

INSERT INTO clients (telephone) VALUES ('0331234567'), ('0337654321');
INSERT INTO comptes (client_id, solde) VALUES (1, 50000), (2, 10000);

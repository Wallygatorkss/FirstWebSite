CREATE DATABASE if NOT EXISTS database_quiz
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE database_quiz;

CREATE TABLE categories (
    id int primary key auto_increment,
    nom varchar(100) not null unique
);

CREATE TABLE questions (
    id int primary key auto_increment,
    categorie_id int not null,
    question TEXT not null,
    reponse_correcte varchar(255) not null,
    reponse_2 varchar(255) not null,
    reponse_3 varchar(255) not null,
    reponse_4 varchar(255) not null,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE cascade
);

INSERT INTO categories (nom) VALUES
('Histoire'),
('Géographie'),
('Sciences'),
('Cinéma'),
('Sport');

INSERT INTO questions (categorie_id, question, reponse_correcte, reponse_2, reponse_3, reponse_4) VALUES
(1, 'En quelle année a eu lieu la Révolution française ?', '1789', '1799', '1776', '1804'),
(1, 'Quel empereur a été couronné en 1804 ?', 'Napoléon Bonaparte', 'Louis XVI', 'Charles de Gaulle', 'Henri IV'),
(1, 'Qui a découvert l''Amérique en 1492 ?', 'Christophe Colomb', 'Vasco de Gama', 'Ferdinand Magellan', 'Marco Polo'),
(1, 'En quelle année a commencé la Première Guerre mondiale ?', '1914', '1918', '1939', '1945'),
(1, 'Quel roi de France était surnommé le Roi Soleil ?', 'Louis XIV', 'Louis XVI', 'François Ier', 'Henri IV');

INSERT INTO questions (categorie_id, question, reponse_correcte, reponse_2, reponse_3, reponse_4) VALUES 
(2, 'Quelle est la capitale de l''Australie ?', 'Canberra', 'Sydney', 'Melbourne', 'Brisbane'),
(2, 'Quel est le plus grand océan du monde ?', 'Océan Pacifique', 'Océan Atlantique', 'Océan Indien', 'Océan Arctique'),
(2, 'Combien de continents y a-t-il sur Terre ?', '7', '5', '6', '8'),
(2, 'Quel est le plus long fleuve du monde ?', 'Amazone', 'Nil', 'Mississippi', 'Yangtsé'),
(2, 'Dans quel pays se trouve la tour Eiffel ?', 'France', 'Italie', 'Belgique', 'Suisse');

INSERT INTO questions (categorie_id, question, reponse_correcte, reponse_2, reponse_3, reponse_4) VALUES 
(3, 'Quelle est la formule chimique de l''eau ?', 'H2O', 'CO2', 'O2', 'H2SO4'),
(3, 'Quelle planète est surnommée la planète rouge ?', 'Mars', 'Vénus', 'Jupiter', 'Saturne'),
(3, 'Combien d''os possède un humain adulte ?', '206', '198', '215', '182'),
(3, 'À quelle vitesse se déplace la lumière ?', '300 000 km/s', '150 000 km/s', '500 000 km/s', '100 000 km/s'),
(3, 'Qui a développé la théorie de la relativité ?', 'Albert Einstein', 'Isaac Newton', 'Galilée', 'Stephen Hawking');

INSERT INTO questions (categorie_id, question, reponse_correcte, reponse_2, reponse_3, reponse_4) VALUES 
(4, 'Quel film a remporté l''Oscar du meilleur film en 1998 ?', 'Titanic', 'Gladiator', 'Forrest Gump', 'Le Seigneur des Anneaux'),
(4, 'Qui a réalisé le film Inception ?', 'Christopher Nolan', 'Steven Spielberg', 'Quentin Tarantino', 'Martin Scorsese'),
(4, 'Dans quel film trouve-t-on la réplique "Que la Force soit avec toi" ?', 'Star Wars', 'Star Trek', 'Avatar', 'Matrix'),
(4, 'Quel acteur joue Iron Man dans l''univers Marvel ?', 'Robert Downey Jr.', 'Chris Evans', 'Chris Hemsworth', 'Mark Ruffalo'),
(4, 'Quel film d''animation Pixar raconte l''histoire d''un rat cuisinier ?', 'Ratatouille', 'Le Monde de Nemo', 'Toy Story', 'Monstres et Cie');

INSERT INTO questions (categorie_id, question, reponse_correcte, reponse_2, reponse_3, reponse_4) VALUES 
(5, 'Combien de joueurs composent une équipe de football sur le terrain ?', '11', '10', '9', '12'),
(5, 'Quel pays a remporté la Coupe du Monde de football en 2018 ?', 'France', 'Brésil', 'Allemagne', 'Argentine'),
(5, 'Quel sport pratique Rafael Nadal ?', 'Tennis', 'Football', 'Basketball', 'Golf'),
(5, 'Tous les combien d''années ont lieu les Jeux Olympiques d''été ?', '4 ans', '2 ans', '5 ans', '3 ans'),
(5, 'Dans quel sport peut-on réaliser un "strike" ?', 'Bowling', 'Baseball', 'Golf', 'Tennis');
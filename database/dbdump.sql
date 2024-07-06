-- Creating the player_info table
CREATE TABLE player_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(255) NOT NULL,
    age INT,
    country VARCHAR(255),
    club VARCHAR(255),
    profile_picture VARCHAR(255)
);

-- Inserting data into the player_info table
INSERT INTO player_info (player_name, age, country, club, profile_picture) VALUES
('Lionel Messi', 36, 'Argentina', 'Inter Miami', 'http://example.com/messi.jpg'),
('Cristiano Ronaldo', 39, 'Portugal', 'Al Nassr', 'http://example.com/ronaldo.jpg'),
('Kylian Mbappe', 25, 'France', 'PSG', 'http://example.com/mbappe.jpg'),
('Neymar Jr', 32, 'Brazil', 'Al Hilal', 'http://example.com/neymar.jpg'),
('Kevin De Bruyne', 33, 'Belgium', 'Manchester City', 'http://example.com/debruyne.jpg'),
('Robert Lewandowski', 35, 'Poland', 'Barcelona', 'http://example.com/lewandowski.jpg'),
('Mohamed Salah', 32, 'Egypt', 'Liverpool', 'http://example.com/salah.jpg');

-- Creating the player_stats table
CREATE TABLE player_stats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_id INT,
    appearances INT,
    goals INT,
    assists INT,
    yellow_cards INT,
    red_cards INT,
    FOREIGN KEY (player_id) REFERENCES player_info(id)
);

-- Inserting data into the player_stats table
INSERT INTO player_stats (player_id, appearances, goals, assists, yellow_cards, red_cards) VALUES
(1, 778, 672, 250, 85, 3),
(2, 925, 701, 220, 100, 4),
(3, 238, 142, 60, 20, 1),
(4, 308, 168, 90, 40, 2),
(5, 300, 60, 100, 30, 0),
(6, 405, 311, 50, 20, 1),
(7, 240, 135, 70, 25, 1);

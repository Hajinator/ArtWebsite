CREATE TABLE Artists ( 
    ArtistID INT PRIMARY KEY AUTO_INCREMENT, 
    Name VARCHAR(100) NOT NULL 
); 


CREATE TABLE Paintings ( 
    PaintingID INT PRIMARY KEY AUTO_INCREMENT, 
    Title VARCHAR(100) NOT NULL,
    Finished INT NOT NULL, 
    Media VARCHAR(30) NOT NULL, 
    Style VARCHAR (30) NOT NULL, 
    ArtistID INT NOT NULL,
    Image MEDIUMBLOB,
    FOREIGN KEY (ArtistID) REFERENCES Artists(ArtistID) ON DELETE CASCADE 
);


INSERT INTO Artists (Name) VALUES 
('August Renoir'), 
('Michelangelo'),
('Vincent Van Gogh'), 
('Leonardo da Vinci'), 
('Claude Monet'), 
('Pablo Picasso'), 
('Salvador Dali'), 
('Paul Cezanne'); 


INSERT INTO Paintings (Title, Finished, Media, Style, ArtistID, Image) VALUES
('Bal du moulin de la Galette', 1876, 'Oil', 'Impressionism', 1, NULL),
('Doni Tondo (Doni Madonna)', 1507, 'Oil', 'Mannerism', 2, NULL),
('Vase with Twelve Sunflowers', 1888, 'Oil', 'Still-life', 3, NULL),
('Mona Lisa', 1503, 'Oil', 'Portrait', 4, NULL),
('The Potato Eaters', 1885, 'Oil', 'Realism', 3, NULL), 
('Sunrise', 1872, 'Oil', 'Impressionism', 5, NULL),
('Weaver', 1884, 'Oil', 'Realism', 3, NULL), 
('Nature morte au compotier', 1914, 'Oil', 'Cubism', 6, NULL), 
('Houses of Parliament', 1899, 'Oil', 'Impressionism', 5, NULL), 
('Cafe Terrace at Night', 1888, 'Oil', 'Impressionism', 3, NULL),
('At the Lapin Agile', 1905, 'Oil', 'Impressionism', 6, NULL), 
('The Persistence of Memory', 1931, 'Oil', 'Surrealism', 7, NULL), 
('The Hallucinogenic Toreador', 1970, 'Oil', 'Surrealism', 7, NULL),
('Jaz de Bouffan', 1877, 'Oil', 'Impressionism', 8, NULL), 
('Vitruvian Man', 1490, 'Pen-ink', 'Realism', 4, NULL), 
('The Kingfisher', 1495, 'Pen-ink', 'Realism', 3, NULL);
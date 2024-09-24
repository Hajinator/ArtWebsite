CREATE TABLE Artists ( 
    ArtistID INT PRIMARY KEY AUTO_INCREMENT, 
    Name VARCHAR(100) NOT NULL 
); 

CREATE TABLE Paintings ( 
    PaintingID INT PRIMARY KEY AUTO_INCREMENT, 
    Title VARCHAR(100) NOT NULL,
    Finished INT NOT NULL, 
    Media VARCHAR(30), 
    Style VARCHAR(30), 
    ArtistID INT NOT NULL,
    ImagePath VARCHAR(255), 
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

INSERT INTO Paintings (Title, Finished, Media, Style, ArtistID) VALUES
('Bal du moulin de la Galette', 1876, 'oil', 'Impressionism', 1),
('Doni Tondo (Doni Madonna)', 1507, 'oil', 'Mannerism', 2),
('Vase with Twelve Sunflowers', 1888, 'oil', 'Still-life', 3),
('Mona Lisa', 1503, 'oil', 'Portrait', 4),
('The Potato Eaters', 1885, 'oil', 'Realism', 3), 
('Sunrise', 1872, 'oil', 'Impressionism', 5),
('Weaver', 1884, 'oil', 'Realism', 3), 
('Nature morte au compotier', 1914, 'oil', 'Cubism', 6), 
('Houses of Parliament', 1899, 'oil', 'Impressionism', 5), 
('Cafe Terrace at Night', 1888, 'oil', 'Impressionism', 3),
('At the Lapin Agile', 1905, 'oil', 'Impressionism', 6), 
('The Persistence of Memory', 1931, 'oil', 'Surrealism', 7), 
('The Hallucinogenic Toreador', 1970, 'oil', 'Surrealism', 7),
('Jaz de Bouffan', 1877, 'oil', 'Impressionism', 8), 
('Vitruvian Man', 1490, 'pen-ink', 'Realism', 4), 
('The Kingfisher', 1495, 'pen-ink', 'Realism', 3);

UPDATE Paintings SET ImagePath = 'images/500_wide/baldumoulindelagalette.png' WHERE PaintingID = 1;
UPDATE Paintings SET ImagePath = 'images/500_wide/donitondo.png' WHERE PaintingID = 2;
UPDATE Paintings SET ImagePath = 'images/500_wide/vasewithtwelvesunflowers.png' WHERE PaintingID = 3;
UPDATE Paintings SET ImagePath = 'images/500_wide/monalisa.png' WHERE PaintingID = 4;
UPDATE Paintings SET ImagePath = 'images/500_wide/thepotatoeaters.png' WHERE PaintingID = 5;
UPDATE Paintings SET ImagePath = 'images/500_wide/sunrise.png' WHERE PaintingID = 6;
UPDATE Paintings SET ImagePath = 'images/500_wide/weaver.png' WHERE PaintingID = 7;
UPDATE Paintings SET ImagePath = 'images/500_wide/naturemorteaucompotier.png' WHERE PaintingID = 8;
UPDATE Paintings SET ImagePath = 'images/500_wide/housesofparliament.png' WHERE PaintingID = 9;
UPDATE Paintings SET ImagePath = 'images/500_wide/cafeterraceatnight.png' WHERE PaintingID = 10;
UPDATE Paintings SET ImagePath = 'images/500_wide/atthelapinagile.png' WHERE PaintingID = 11;
UPDATE Paintings SET ImagePath = 'images/500_wide/thepersistenceofmemory.png' WHERE PaintingID = 12;
UPDATE Paintings SET ImagePath = 'images/500_wide/thehallucinogenictoreador.png' WHERE PaintingID = 13;
UPDATE Paintings SET ImagePath = 'images/500_wide/jazdebouffan.png' WHERE PaintingID = 14;
UPDATE Paintings SET ImagePath = 'images/500_wide/vitruvianman.png' WHERE PaintingID = 15;
UPDATE Paintings SET ImagePath = 'images/500_wide/thekingfisher.png' WHERE PaintingID = 16;
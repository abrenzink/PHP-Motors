-- 1. Insert new client 

INSERT INTO clients
	(clientFirstname, clientLastname, clientEmail, clientPassword, clientLevel, comment)
VALUES	
	('Tony', 'Stark', 'tony@starkent.com', 'IamIronM@n', 1, 'I am the real Ironman');

-- 2. update client level

UPDATE 
	clients
SET 
	clientLevel = 3
WHERE 
	clientFirstname = 'Tony';

-- 3. replacing strings

-- SELECT 
--     invDescription
-- FROM 
--     inventory
-- WHERE 
--     invModel='Hummer';

UPDATE
	inventory
SET 
	invDescription=REPLACE(invDescription,'small','spacious');


-- 4. nner join

SELECT 
	invModel, classificationName
FROM 
	inventory
INNER JOIN carclassification ON 
	inventory.classificationId=carclassification.classificationId
WHERE
	classificationName = 'SUV';

-- 5. deleting

DELETE FROM 
    inventory
WHERE 
    invModel='Wrangler';

-- 6. updating inventory table

UPDATE
	inventory
SET 
	invImage=CONCAT('/phpmotors',invImage), invThumbnail=CONCAT('/phpmotors',invThumbnail);

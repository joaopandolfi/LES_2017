-- -----------------------------------------------------
-- Registra usuario e retorna o ID
-- @receives name,email,pass
-- @returns id_user
-- -----------------------------------------------------
DELIMITER //
CREATE FUNCTION new_user(name_p VARCHAR(45), 
				email_p VARCHAR(45), 
				pass_p VARCHAR(45), 
				hash_p VARCHAR(45))  
RETURNS INT
  BEGIN

  INSERT INTO user (name,email,password,hash) VALUES(
    name_p,
    email_p,
    pass_p,
    hash_p
  );
  
  SELECT LAST_INSERT_ID() INTO @id_user;

  RETURN @id_user;
  END //
DELIMITER ;

-- -----------------------------------------------------
-- Cria Trip e retorna ID
-- @receives user_id,title,short_route,description
-- @returns id_route
-- -----------------------------------------------------
DELIMITER //
CREATE FUNCTION new_trip(user_id_p INT, 
				title_p VARCHAR(45), 
				short_route_p VARCHAR(45), 
				description_p VARCHAR(45),
        url_image_p TEXT) 
RETURNS INT
  BEGIN

  INSERT INTO route (fk_user,description,title,main_picture) VALUES(
    user_id_p,
    description_p,
    title_p,
    url_image_p
  );
  
  SELECT LAST_INSERT_ID() INTO @id_route;

  RETURN @id_route;
  END //
DELIMITER ;




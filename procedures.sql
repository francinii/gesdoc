-- ----------------Procedimientos almacenados----------------------------------
-- ----------------------------
-- PROCEDURE insert a new department
-- return 0 success, 1 or 2 error in database, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_department`;
DELIMITER ;;
CREATE   PROCEDURE `insert_department`(IN `p_description` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                    INSERT INTO `departments`(description,created_at,updated_at) VALUES (p_description, NOW(),NOW());
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_department('sede',@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE delete a department
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_department`;
DELIMITER ;;
CREATE   PROCEDURE `delete_department`(IN `p_id` int, OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                   
                  DELETE FROM `departments` WHERE `id`=p_id; 
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_department(1,@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE delete a department
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_department`;
DELIMITER ;;
CREATE   PROCEDURE `update_department`(IN `p_id` int, IN `p_description` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                  UPDATE `departments` SET `description`= p_description, updated_at=NOW()  WHERE `id`= p_id; 
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call update_department(1,'sedes',@res);
-- SELECT @res as res;


-- ----------------------------
-- PROCEDURE insert a new role
-- return 0 success, 1 or 2 error in database, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_role`;
DELIMITER ;;
CREATE   PROCEDURE `insert_role`(IN `p_description` varchar(500),IN `p_permissions` varchar(500),
OUT `res` TINYINT  UNSIGNED)
BEGIN
DECLARE _next TEXT DEFAULT NULL;
DECLARE _nextlen INT DEFAULT NULL;
DECLARE _value TEXT DEFAULT NULL;
DECLARE p_id Integer;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                    INSERT INTO `roles`(description,created_at,updated_at) VALUES (p_description, NOW(),NOW());
                    SET p_id = LAST_INSERT_ID();
                    iterator:
                    LOOP
                        IF LENGTH(TRIM(p_permissions)) = 0 OR p_permissions IS NULL THEN
                        LEAVE iterator;
                        END IF;
                        SET _next = SUBSTRING_INDEX(p_permissions,',',1);
                        SET _nextlen = LENGTH(_next);
                        SET _value = CAST(TRIM(_next) AS UNSIGNED);
                        INSERT INTO `permission_role`(role_id,permission_id,created_at,updated_at) VALUES (p_id,_value,NOW(),NOW());
                        SET p_permissions = INSERT(p_permissions,1,_nextlen + 1,'');
                    END LOOP;
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_role('leector','1,2',@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE delete a role
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_role`;
DELIMITER ;;
CREATE   PROCEDURE `delete_role`(IN `p_id` int, OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;                   
                  DELETE FROM `roles` WHERE `id`=p_id; 
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_role(1,@res);
-- SELECT @res as res;


-- ----------------------------
-- PROCEDURE update a new role
-- return 0 success, 1 or 2 error in database, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_role`;
DELIMITER ;;
CREATE   PROCEDURE `update_role`(IN `p_id` int,IN `p_description` varchar(500),IN `p_permissions` varchar(500),
OUT `res` TINYINT  UNSIGNED)
BEGIN
DECLARE _next TEXT DEFAULT NULL;
DECLARE _nextlen INT DEFAULT NULL;
DECLARE _value TEXT DEFAULT NULL;
DECLARE p_role_id Integer;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                    UPDATE `roles` SET `description`= p_description, updated_at=NOW()  WHERE `id`= p_id;
                    DELETE FROM `permission_role` WHERE `role_id`=p_id;
                    iterator:
                    LOOP
                        IF LENGTH(TRIM(p_permissions)) = 0 OR p_permissions IS NULL THEN
                        LEAVE iterator;
                        END IF;
                        SET _next = SUBSTRING_INDEX(p_permissions,',',1);
                        SET _nextlen = LENGTH(_next);
                        SET _value = CAST(TRIM(_next) AS UNSIGNED);
                        INSERT INTO `permission_role`(role_id,permission_id,created_at,updated_at) VALUES (p_id,_value,NOW(),NOW());
                        SET p_permissions = INSERT(p_permissions,1,_nextlen + 1,'');
                    END LOOP;
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call update_role('leector','1,2',@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE insert a new user
-- return 0 success, 1 or 2 error in database, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_user`;
DELIMITER ;;
CREATE   PROCEDURE `insert_user`(IN `p_role_id` int,IN `p_department_id` int,IN `p_name` varchar(500),IN `p_username` varchar(500),IN `p_email` varchar(500),IN `p_password` varchar(500),IN `p_api_token` varchar(500),IN `p_classification` varchar(500),IN `p_share_classification` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
 
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN

		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN

		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                    INSERT INTO `users`(role_id,department_id,name,username,email,password,api_token,created_at,updated_at) VALUES (p_role_id,p_department_id,p_name,p_username,p_email,p_password,p_api_token, NOW(),NOW());
                    INSERT INTO `classifications`(username, description, type, created_at, updated_at) VALUES (p_username,p_classification,1, NOW(),NOW());
                    INSERT INTO `classifications`(username, description, type, created_at, updated_at) VALUES (p_username,p_share_classification,2, NOW(),NOW());
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_user(1,1,'Danny','402340421','user@gmail.com','created with ldap','Sin clasificacion',@res);
-- call insert_user(4,2,'Juan Sanchez','402340421','juanS@gmail.com','$2y$10$cSntRLLcUKwPNE0Jo4ccmuUMNMsRecG0djvwT7KMez5DmNBT3eS1G','Principal','Compartido conmigo',@res)
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE update a user
-- return 0 success, 1 or 2 error in database, 3 the user already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_user`;
DELIMITER ;;
CREATE   PROCEDURE `update_user`(IN `p_role_id` int,IN `p_department_id` int,IN `p_name` varchar(500),IN `p_username` varchar(500),IN `p_email` varchar(500),IN `p_password` varchar(500),IN `p_update_password` boolean, OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;                  
            IF p_update_password and p_role_id=-1 then            
              UPDATE `users` SET `department_id`=p_department_id,`name`=p_name,`email`=p_email,`password`=p_password,`updated_at`=NOW() WHERE `username`=p_username;
            
            ELSEIF p_update_password then            
              UPDATE `users` SET `role_id`=p_role_id,`department_id`=p_department_id,`name`=p_name,`email`=p_email,`password`=p_password,`updated_at`=NOW() WHERE `username`=p_username;
            
            ELSEIF p_role_id=-1 then 
              UPDATE `users` SET `department_id`=p_department_id,`name`=p_name,`email`=p_email,`updated_at`=NOW() WHERE `username`=p_username;
            
            ELSE        
              UPDATE `users` SET `role_id`=p_role_id,`department_id`=p_department_id,`name`=p_name,`email`=p_email,`updated_at`=NOW() WHERE `username`=p_username;
            END IF;
           
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call update_user(1,1,'Danny Valerio','402340421','danny.valerio.ramirez@est.una.ac.cr','12345678',false,@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE delete a user
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_user`;
DELIMITER ;;
CREATE   PROCEDURE `delete_user`(IN `p_username` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;                   
                  DELETE FROM `users` WHERE `username`=p_username; 
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_user('402340421',@res);
-- SELECT @res as res;










-- ----------------------------
-- PROCEDURE insert a new classification
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_classification`;
DELIMITER ;;
CREATE  PROCEDURE `insert_classification`(IN `p_description` varchar(500),IN `p_username` varchar(500),OUT `res` TINYINT  UNSIGNED)
BEGIN
 	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                   
                    INSERT INTO `classifications`(username, description, type, created_at, updated_at) VALUES (p_username,p_description,3, NOW(),NOW());
                    
                    
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_classification('mi clasificacion','402340421',@res);
-- SELECT @res as res;


-- ----------------------------
-- PROCEDURE update a classification
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_classification`;
DELIMITER ;;
CREATE   PROCEDURE `update_classification`( IN `p_description` varchar(500),IN `p_id` int, OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                  UPDATE `classifications` SET `description`=p_description,`updated_at`=NOW() WHERE `id`=p_id;
                  
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call update_classification('mis documentos',5,@res);
-- SELECT @res as res;




-- -------------------------------------- AGREGAR HISTORIAL ------------------------------------
-- ----------------------------
-- PROCEDURE delete user for a classification
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_Share_Classification`;
DELIMITER ;;
CREATE  PROCEDURE `delete_Share_Classification`(IN `p_id` int,IN `p_username` varchar(500),IN `p_documents` LONGTEXT,IN `p_classification_owner` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _classification_owner varchar(500) DEFAULT NULL;
  DECLARE _principal_classification INT DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _value TEXT DEFAULT NULL;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN

		-- ERROR
    SET res = -1;
  
    ROLLBACK;
	END;
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN

		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;

            START TRANSACTION;
            
                SELECT `username` into _classification_owner FROM `classifications` WHERE `id`=p_id;
                IF _classification_owner=p_username and p_classification_owner!='' THEN
                  UPDATE `classifications` SET `username`=p_classification_Owner,`updated_at`=Now() WHERE `id`=p_id;
                ELSE    
                  IF p_classification_owner!='' THEN
                    DELETE FROM `action_classification_user` WHERE `classification_id`=p_id  and `username`=p_username;
                  ELSE
                    DELETE FROM `classifications` WHERE `id`=p_id;
                  END IF;             
                  iterator:
                    LOOP
                        IF LENGTH(TRIM(p_documents)) = 0 OR p_documents IS NULL THEN
                        LEAVE iterator;
                        END IF;
                        SET _next = SUBSTRING_INDEX(p_documents,',',1);
                        SET _nextlen = LENGTH(_next);
                        SET _value = CAST(TRIM(_next) AS UNSIGNED);
                        
                        IF p_classification_owner!='' THEN
                          DELETE FROM `action_document_user` WHERE `document_id`=_value and `username`=p_username;
                        ELSE
                          DELETE FROM `documents` WHERE `id`=_value;
                          DELETE FROM `action_document_user` WHERE `document_id`=_value;                          
                        END IF;  
                        SET p_documents = INSERT(p_documents,1,_nextlen + 1,'');
                      END LOOP;  
                END IF;       
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_Share_Classification(5,'402340420','1','',@res)
-- call delete_Share_Classification(5,'402340420','2,4,9,10,11,12,13','',@res)
-- SELECT @res as res;



-- -------------------------------------- AGREGAR HISTORIAL ------------------------------------
-- ---------------------------------------
-- procedura remove a share clasification 
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `remove_Classification`;
DELIMITER ;;
CREATE  PROCEDURE `remove_Classification`(IN `p_id` int,IN `p_username` varchar(500),IN `p_documents` LONGTEXT, OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _classification_owner varchar(500) DEFAULT NULL;
  DECLARE _principal_classification INT DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _value TEXT DEFAULT NULL;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;  
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
      START TRANSACTION;                                  
        DELETE FROM `action_classification_user` WHERE `username` =p_username and `classification_id`=p_id;          
        iterator:
          LOOP
              IF LENGTH(TRIM(p_documents)) = 0 OR p_documents IS NULL THEN
                LEAVE iterator;
              END IF;
              SET _next = SUBSTRING_INDEX(p_documents,',',1);
              SET _nextlen = LENGTH(_next);
              SET _value = CAST(TRIM(_next) AS UNSIGNED);
              DELETE FROM `action_document_user` WHERE `document_id`=_value and `username` =p_username;
              SET p_documents = INSERT(p_documents,1,_nextlen + 1,'');
          END LOOP;  
                
      COMMIT;
      -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call remove_Classification(5,'402340420','1','',@res)
-- SELECT @res as res;



-- -------------------------------------- AGREGAR HISTORIAL ------------------------------------
-- ----------------------------
-- PROCEDURE add user for a classification
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_Share_Classification`;
DELIMITER ;;
CREATE  PROCEDURE `add_Share_Classification`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification_owner` varchar(500),IN `p_documents` LONGTEXT,IN `p_actions` varchar(500), IN `p_current_user` varchar(500),IN `p_current_user_name` varchar(500),OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _classification INT DEFAULT NULL;
  DECLARE _classification_description TEXT DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _action TEXT DEFAULT NULL;
  DECLARE _nextDoc TEXT DEFAULT NULL;
  DECLARE _nextlenDoc INT DEFAULT NULL;
  DECLARE _document TEXT DEFAULT NULL;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN

		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;
      
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN

		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;

            START TRANSACTION;
              IF p_classification_owner!=p_username THEN
              SELECT `id` into _classification FROM `classifications` WHERE `type`=2 and `username`=p_username;    
              SELECT `description` into _classification_description FROM `classifications` WHERE `id`=p_id;            
              INSERT INTO `notifications`(`username`, `description`,`source`, `created_at`, `updated_at`) VALUES (p_username, CONCAT('El usuario ', p_current_user ,'con identificación',p_current_user,', le compartio la clasificacion: ',_classification_description),"document",NOW(),NOW());
              iterator:
                LOOP
                    IF LENGTH(TRIM(p_actions)) = 0 OR p_actions IS NULL THEN
                    LEAVE iterator;
                    END IF;
                    SET _next = SUBSTRING_INDEX(p_actions,',',1);
                    SET _nextlen = LENGTH(_next);
                    SET _action = CAST(TRIM(_next) AS UNSIGNED);                            
                    INSERT INTO `action_classification_user`(`action_id`, `classification_id`, `username`, `created_at`, `updated_at`) VALUES (_action,p_id,p_username,NOW(),NOW());
                    SET p_actions = INSERT(p_actions,1,_nextlen + 1,'');
                END LOOP;
              iterator:
                LOOP
                    IF LENGTH(TRIM(p_documents)) = 0 OR p_documents IS NULL THEN
                    LEAVE iterator;
                    END IF;
                    SET _nextDoc = SUBSTRING_INDEX(p_documents,',',1);
                    SET _nextlenDoc = LENGTH(_nextDoc);
                    SET _document = CAST(TRIM(_nextDoc) AS UNSIGNED);
                    REPLACE  INTO `action_document_user`(`action_id`, `document_id`, `username`, `created_at`, `updated_at`) VALUES (4,_document,p_username,NOW(),NOW());
                    DELETE FROM `classification_document` WHERE `classification_id`=_classification and `document_id`=_document;                  
                  SET p_documents = INSERT(p_documents,1,_nextlenDoc + 1,'');
                END LOOP;
              END IF;
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call add_Share_Classification(7,'402340420','116650288','1','4',@res)
-- SELECT @res as res;




-- -------------------------------------- AGREGAR HISTORIAL ------------------------------------
-- ----------------------------
-- PROCEDURE update a user share a classification
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_Share_Classification`;
DELIMITER ;;
CREATE  PROCEDURE `update_Share_Classification`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification_owner` varchar(500),IN `p_actions` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _classification_owner varchar(500) DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _action TEXT DEFAULT NULL;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;
      
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
  
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;

            START TRANSACTION;
              SELECT `username` into _classification_owner FROM `classifications` WHERE `id`=p_id;
              DELETE FROM `action_classification_user` WHERE `classification_id`=p_id and `username`=p_username;
              IF _classification_owner=p_username and p_classification_owner!=p_username THEN
                UPDATE `classifications` SET `username`=p_classification_Owner,`updated_at`=Now() WHERE `id`=p_id;
              END IF;
              IF p_classification_owner!=p_username THEN
                iterator:
                  LOOP
                      IF LENGTH(TRIM(p_actions)) = 0 OR p_actions IS NULL THEN
                      LEAVE iterator;
                      END IF;
                      SET _next = SUBSTRING_INDEX(p_actions,',',1);
                      SET _nextlen = LENGTH(_next);
                      SET _action = CAST(TRIM(_next) AS UNSIGNED);
                      INSERT INTO `action_classification_user`(`action_id`, `classification_id`, `username`, `created_at`, `updated_at`) VALUES (_action,p_id,p_username,NOW(),NOW());
                      SET p_actions = INSERT(p_actions,1,_nextlen + 1,'');
                    END LOOP;
              END IF;
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;

-- call update_Share_Classification(9,'402340420','402340420','',@res)
-- SELECT @res as res;


-- PROCEDURE insert a new flow
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_flow`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_flow`(IN `p_username` varchar(500), IN `p_description` varchar(500), IN `p_state` boolean, OUT `res` TINYINT  UNSIGNED, OUT `id_flow` INT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                   INSERT INTO `flows`(username, description,state, created_at,updated_at) VALUES (p_username, p_description,p_state, NOW(),NOW());
           COMMIT;
            SET id_flow = LAST_INSERT_ID();
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;




-- PROCEDURE update a new flow
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_flow`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_flow`(IN `p_idFlow` int, IN `p_username` varchar(500), IN `p_description` varchar(500),IN `p_state` boolean, OUT `res` TINYINT  UNSIGNED, OUT `id_flow` INT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
            UPDATE `flows` SET username = p_username, description = p_description, state = p_state, updated_at = NOW() where id =  p_idFlow;
                --  DELETE FROM `flows` WHERE id = p_idFlow;
               --   INSERT INTO `flows`(username, description,created_at,updated_at) VALUES (p_username, p_description, NOW(),NOW());
           COMMIT;
          --  SET id_flow = LAST_INSERT_ID();
            SET id_flow = p_idFlow;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;


-- PROCEDURE insert a new step to a flow
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_step`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_step`(IN `p_identifier` varchar(500), IN `p_idFlow` int,  IN `p_description` varchar(500), IN `p_axisx` int,  IN `p_axisy` int,  OUT `res` TINYINT  UNSIGNED)
                                               
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
               -- SET cursor = (SELECT * FROM versions WHERE flow_id = p_idFlow, identifier = p_identifier);
               --  DELETE FROM `steps` WHERE flow_id = p_idFlow ;
                 INSERT INTO `steps`(flow_id, id, description, axisX, axisY, created_at,updated_at) VALUES (p_idFlow, p_identifier, p_description, p_axisx, p_axisy, NOW(),NOW());
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;


-- PROCEDURE insert a new step step  to step_step table
-- return 0 success, 1 or 2 database error, 3 the department already exists
DROP PROCEDURE IF EXISTS `insert_step_step`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_step_step`(IN `p_id_initial` varchar(500), IN `p_id_final` varchar(500),IN `p_id_flow` int, IN p_action int, OUT `res` TINYINT  UNSIGNED)
                                               
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                 INSERT INTO `step_step`(prev_step_id, 	next_step_id, 	prev_flow_id,	next_flow_id, 	id_action, 	created_at, 	updated_at ) VALUES (p_id_initial,p_id_final,p_id_flow,p_id_flow, p_action, NOW(),NOW());
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_step_step('draggable_inicio','draggable2',14,3,@res);
-- SELECT @res as res;




-- PROCEDURE insert a new row to the step_user table
-- return 0 success, 1 or 2 database error, 3 the row already exists
DROP PROCEDURE IF EXISTS `insert_action_step_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_action_step_user`(IN `p_id` varchar(500),IN `p_id_flow` int, IN `p_username` varchar(500), IN `p_action` int, OUT `res` TINYINT  UNSIGNED)
                                              
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR          
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
                 INSERT INTO `action_step_user`(created_at,updated_at, step_id, flow_id, username, action_id ) VALUES (NOW(),NOW(),p_id, p_id_flow, p_username, p_action);
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;


-- PROCEDURE update the action step user table
-- return 0 success, 1 or 2 database error, 3 the row already exists
DROP PROCEDURE IF EXISTS `update_action_step_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_action_step_user`(IN `p_step_id` varchar(500),IN `p_id_flow` int, IN `p_username` varchar(500), IN `p_action` int, OUT `res` TINYINT  UNSIGNED)
                                              
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;


              UPDATE `action_step_user` SET action_id = p_action, updated_at =NOW()
              WHERE flow_id= p_id_flow and step_id= p_step_id and username= p_username;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;



-- PROCEDURE update the action step user table
-- return 0 success, 1 or 2 database error, 3 the row already exists
DROP PROCEDURE IF EXISTS `insert_update_action_step_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_update_action_step_user`(IN `p_step_id` varchar(500),IN `p_id_flow` int, IN `p_username` varchar(500), IN `p_action` int, OUT `res` TINYINT  UNSIGNED)
                                              
BEGIN
 DECLARE _exist INT DEFAULT NULL;

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;    
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
            SELECT  COUNT(action_id) into _exist FROM `action_step_user`WHERE flow_id= p_id_flow and step_id= p_step_id and username= p_username and action_id = p_action ;   
            IF _exist = 0 THEN
                 CALL insert_action_step_user(p_step_id, p_id_flow, p_username, p_action, @res);            
            -- ELSE
            --     CALL update_action_step_user(p_step_id, p_id_flow, p_username, p_action, @res);
            END IF;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;




-- PROCEDURE  delete_action_step_user_by_user
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_action_step_user_by_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `delete_action_step_user_by_user`(IN p_idFlow int, IN p_identifier varchar(500), IN p_username varchar(500),  OUT `res` TINYINT  UNSIGNED)
                                               
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
               DELETE FROM `action_step_user` WHERE flow_id = p_idFlow and step_id = p_identifier and username = p_username ;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;





-- LISTO CON EL HISTORIAL
-- PROCEDURE insert a cretate a nuew document
-- return 0 success, 1 or 2 database error, 3 the row already exists
DROP PROCEDURE IF EXISTS `insert_document`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_document`(IN `p_classification` int,  IN `p_id_flow` int,IN `p_identifier`varchar(500), IN `p_action_id` int, IN `p_username` varchar(500), IN `p_description` varchar(500), IN `p_type` varchar(500), IN `p_summary` varchar(2500) , IN `p_code` varchar(500), IN `p_languaje` varchar(500),IN `p_others` varchar(500),IN `p_size` varchar(500),IN `p_content` LONGTEXT, IN `p_users` TEXT ,  OUT `res` TINYINT  UNSIGNED )
BEGIN
  DECLARE idFlow INT DEFAULT NULL;
  DECLARE idIdentifier varchar(500) DEFAULT NULL; 
  DECLARE document_id INT DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _user TEXT DEFAULT NULL;


-- VARIABLES NEEDED FOR THE HISTORIAL --
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;
  DECLARE h_status INT DEFAULT NULL;
  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
  -- --

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
    SET res = -2;
    ROLLBACK;
	END;

            START TRANSACTION;
            set idFlow = p_id_flow;
            -- set h_status = 10; -- En flujo
            set idIdentifier = p_identifier;
                IF  p_id_flow = -1 THEN
                  set idFlow = NULL;
                 -- set h_status = 1;
                END IF;
                IF  p_identifier = '-1' THEN
                  set idIdentifier = NULL;
                END IF;

                INSERT INTO `documents`(`flow_id`, `action_id`, `username`, `description`, `type`, `summary`, `code`, `languaje`, `others`, `created_at`, `updated_at`) VALUES (idFlow, p_action_id, p_username, p_description, p_type, p_summary, p_code, p_languaje, p_others,NOW(),NOW());
                SET document_id =  LAST_INSERT_ID(); 
                INSERT INTO `classification_document`(classification_id, document_id, created_at, updated_at ) VALUES (p_classification, document_id, NOW(), NOW());
                INSERT INTO `versions`(document_id, flow_id, identifier, content,size, status, version, created_at, updated_at) VALUES (document_id, idFlow, idIdentifier,p_content,p_size,1,1, NOW(),NOW());
                
                -- NECESARY FOR THE HISTORIAL -- 
                SET h_version_id =  LAST_INSERT_ID();              
                set h_username = p_username;
                set h_document_id = document_id;
                set h_id_flow =NULL;
                set h_name_flow = NULL; 
                select description into h_document_name from documents where id = document_id;
                select name into h_user_name from users where username = p_username;

                IF  p_id_flow != -1 THEN                 
                    select id, description into h_id_flow, h_name_flow from flows where id = p_id_flow;
                    set h_description =   CONCAT_WS(' ','El usuario', h_user_name, 'con identificación', h_username, 'ha agreado al flujo',h_name_flow, 'con identificación', p_id_flow,', el documento llamado', p_description,'cuya identificación es',h_document_id, 'correspondiente a la versión 1.0' );
                    INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
                    VALUES ('En flujo', h_username, 	h_user_name, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, 	h_id_flow, 	h_name_flow, NOW(),NOW());
                END IF;              

                set h_description =   CONCAT_WS(' ','El usuario', h_user_name, 'con identificación', h_username, 'ha creado el documento con id',h_document_id,'llamado',p_description, 'correspondiente a la versión 1.0' );
                INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
                VALUES ('Crear', h_username, 	h_user_name, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, 	h_id_flow, 	h_name_flow, NOW(),NOW());
               -- CALL insert_historial(h_action, h_username , h_user_name, h_description , h_document_id ,h_document_name, h_version_id, h_id_flow,	h_name_flow, @res);
               -- call insert_historial(3,'116650288','FRANCINI CORRALES GARRO', 'eSTO ES UNA PRUEBA',1,'Tell me', 1,NULL,NULL, @res);    
               
               
               -- END OF NECESARY FOR THE HISTORIAL --   
                 set h_description = '';
                  iterator:
                    LOOP
                        IF LENGTH(TRIM(p_users)) = 0 OR p_users IS NULL THEN
                        LEAVE iterator;
                        END IF;
                        SET _next = SUBSTRING_INDEX(p_users,',',1);
                        SET _nextlen = LENGTH(_next);
                        SET _user = CAST(TRIM(_next) AS UNSIGNED);
                        INSERT INTO `action_document_user`(`action_id`, `document_id`, `username`, `created_at`, `updated_at`) VALUES (4,document_id,_user,NOW(),NOW());
                        SET p_users = INSERT(p_users,1,_nextlen + 1,'');

                        SET h_description =   CONCAT_WS('Se asoció la accion ',h_description, 'al usuario', h_user_name, 'con identificación', h_username, 'en el documento con identificación',h_document_id,'llamado',p_description);
             
                    END LOOP;
           
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_document('1',-1,-1,3,'402340420', 'doc1', 'docx', 'doc1', 'doc1','doc1','','0KB','', @res);
-- call insert_document('6',6,'draggable1',3,'402340420', 'prueba', 'docx', 'ad', 'doc1','doc1','asd','0KB','', @res);
-- SELECT @res as res;





-- LISTO CON EL HISTORIAL
-- PROCEDURE update a documents
-- return 0 success, 1 or 2 database error, 3 the row already exists
DROP PROCEDURE IF EXISTS `update_document`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_document`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification` int,IN `p_currentClassification` int,   IN `p_id_flow` int,IN `p_identifier` varchar(500), IN `p_description` varchar(500),  IN `p_summary` varchar(2500) , IN `p_code` varchar(500), IN `p_languaje` varchar(500),IN `p_others` varchar(500),IN `p_user_Flow` Text, OUT `res` TINYINT  UNSIGNED )
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE _document_owner INT DEFAULT NULL;
  DECLARE idFlow INTEGER ; 
  DECLARE idIdentifier varchar(500);
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _user TEXT DEFAULT NULL;

  --  VARIABLES NEEDED FOR THE  HISTORIAL -- 
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_action int DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;

  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_version_num decimal(3,1) DEFAULT NULL;
  -- END OF THE VARIABLES NEEDED IN THE HISTORIAL --


	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
    SET res = -2;
    ROLLBACK;
	END;

      START TRANSACTION;
            set idFlow = p_id_flow;
            set h_action = 10;
            set idIdentifier = p_identifier;
                IF  p_id_flow = -1 THEN
                  set idFlow = NULL;
                END IF;
                IF  p_identifier = '-1' THEN
                  set idIdentifier = NULL;
                  set h_action = 3;
                END IF;
                SELECT `username` into _document_owner FROM `documents` WHERE `id`=p_id;   
                UPDATE `documents` SET `flow_id`=idFlow,`description`=p_description,`action_id`= h_action, `summary`=p_summary,`code`=p_code,`languaje`=p_languaje,`others`=p_others,`updated_at`=NOW() WHERE `id`=p_id;
                IF _document_owner=p_username THEN
                  DELETE FROM `classification_document` WHERE `document_id`=p_id and `classification_id`=p_currentClassification;
                  INSERT INTO `classification_document`(classification_id, document_id, created_at, updated_at ) VALUES (p_classification, p_id, NOW(), NOW());                
                END IF;
                UPDATE `versions` SET `flow_id`=idFlow,`identifier`=idIdentifier,`updated_at`=NOW() WHERE `document_id`=p_id ORDER BY `version` DESC LIMIT 1;               
                  
                -- NECESARY FOR THE HISTORIAL --   
                select id, version into h_version_id, h_version_num from versions where document_id = p_id  ORDER BY `version` DESC LIMIT 1;           
                set h_action = 5;
                set h_username = p_username;
                set h_document_id = p_id;
                set h_id_flow = NULL;
                set h_name_flow = NULL; 

                -- SELECT THE DESCRIPTION OF a Document              
                select description into h_document_name from documents where id = p_id;

                -- SELECT THE name OF an user   
                select name into h_user_name from users where username = p_username;

                IF  p_id_flow != -1 THEN 

                    iterator:
                    LOOP
                        IF LENGTH(TRIM(p_user_Flow)) = 0 OR p_user_Flow IS NULL THEN
                        LEAVE iterator;
                        END IF;
                        SET _next = SUBSTRING_INDEX(p_user_Flow,',',1);
                        SET _nextlen = LENGTH(_next);
                        SET _user = CAST(TRIM(_next) AS UNSIGNED);
                        INSERT INTO `notifications`(`username`, `description`,`source`, `created_at`, `updated_at`) VALUES (_user, CONCAT('Tienes un documento en flujo pendiente'),"flow",NOW(),NOW());
                        SET p_user_Flow = INSERT(p_user_Flow,1,_nextlen + 1,'');
             
                    END LOOP;




                    -- SELECT THE ID AND DESCRIPTION OF THE FLOW IF A FLOW IS NOT NULL               
                    select id, description into h_id_flow, h_name_flow from flows where id = p_id_flow;

                    -- INSERT INTO THE HISTORIAL --
                    set h_description =   CONCAT_WS(' ','El usuario ', h_user_name, ' con identificación: ', h_username, ', ha agregado al flujo',h_name_flow,'con id', p_id_flow, 'el documento ',h_document_name,  'con identificación ', h_document_id);
                    INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, updated_at, created_at) 
                    VALUES ('En flujo', h_username, 	h_user_name, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, 	h_id_flow, 	h_name_flow, NOW(), NOW());
                END IF;      

                set h_description =   CONCAT_WS(' ','El usuario ', h_user_name, ' con identificación: ', h_username, 'ha actualizado los metadatos del documento con identificación:',h_document_id,'llamado',p_description, 'correspondiente a la versión', h_version_num, '.');
                INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, updated_at, created_at) 
                    VALUES ('Editar', h_username, 	h_user_name, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, 	h_id_flow, 	h_name_flow, NOW(), NOW());
                -- CALL insert_historial(h_action, h_username , h_user_name, h_description , h_document_id ,h_document_name,h_version_id, h_id_flow,	h_name_flow, @res);
                -- END OF NECESARY FOR THE HISTORIAL --
            
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call update_document(1,'402340420','1', 1,1,'draggable1','doc1', 'doc1', 'doc2','doc2','','402340420',@res)
-- SELECT @res as res;






-- ----------------------------
-- PROCEDURE remove a share documento 
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `remove_document`;
DELIMITER ;;
CREATE   PROCEDURE `remove_document`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification` int,IN `p_user_logged` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
    --  VARIABLES NEEDED FOR THE  HISTORIAL -- 
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_action int DEFAULT NULL;
  DECLARE h_action_name varchar(500) DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;
  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_version_num decimal(3,1) DEFAULT NULL;
  -- END OF THE VARIABLES NEEDED IN THE HISTORIAL --

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;  

  -- NECESARY FOR THE HISTORIAL -- 
          SET h_version_id =  NULL;              
          set h_username = p_username;
          set h_document_id = p_id;
          set h_id_flow =NULL;
          set h_name_flow = NULL; 
          select description into h_document_name from documents where id = p_id;
          select name into h_user_name from users where username = p_username;          

        set h_description =   CONCAT_WS(' ','El usuario con identificación', p_user_logged, 'ha removido los permisos del documento con id',h_document_id,'llamado',h_document_name, 'al usuario con identificación', p_username);
        INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
        VALUES ('Elminiar', h_username, 	h_user_name, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, 	h_id_flow, 	h_name_flow, NOW(),NOW());

  -- END OF NECESARY FOR THE HISTORIAL -- 
          DELETE FROM `classification_document` WHERE `classification_id`=p_classification and `document_id`=p_id;                  
          DELETE FROM `action_document_user` WHERE `document_id`=p_id and `username`=p_username;
      COMMIT;
      -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call remove_document(25,'116650288',2,'116650288',@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE save time of documento  edit
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `save_document`;
DELIMITER ;;
CREATE   PROCEDURE `save_document`(IN `p_id` int,IN `p_username` varchar(500),OUT `res` TINYINT  UNSIGNED)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;                   
                  UPDATE `documents` SET `updated_at`=NOW() WHERE `id`=p_id;
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call save_document(2,'402340421','2020-08-03 16:02:41',@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE clone documento 
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `clone_document`;
DELIMITER ;;
CREATE   PROCEDURE `clone_document`(IN `p_id` int,IN `p_classification` int,IN `p_content` LONGTEXT,IN `p_users` TEXT , OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _document_id INT DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _user TEXT DEFAULT NULL;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION; 

            INSERT INTO `documents`(`flow_id`, `action_id`, `username`, `description`, `type`, `summary`, `code`, `languaje`, `others`, `created_at`, `updated_at`)            
            SELECT  Null, `action_id`, `username`, CONCAT('copy-',`description`), `type`, `summary`, `code`, `languaje`, `others`, NOW() , NOW() FROM `documents` WHERE `id` =p_id;
            SET _document_id =  LAST_INSERT_ID(); 
            INSERT INTO `versions`(`document_id`, `flow_id`, `identifier`, `content`, `size`, `status`, `version`, `created_at`, `updated_at`)
            SELECT _document_id, Null, Null, p_content, `size`, `status`,1, now() , NOW() FROM `versions` 
            WHERE `document_id`=p_id and `version`=(SELECT max(`version`) FROM `versions` where `document_id`= p_id );
            INSERT INTO `classification_document`(classification_id, document_id, created_at, updated_at ) VALUES (p_classification, _document_id, NOW(), NOW());
            iterator:
                  LOOP
                      IF LENGTH(TRIM(p_users)) = 0 OR p_users IS NULL THEN
                      LEAVE iterator;
                      END IF;
                      SET _next = SUBSTRING_INDEX(p_users,',',1);
                      SET _nextlen = LENGTH(_next);
                      SET _user = CAST(TRIM(_next) AS UNSIGNED);
                      INSERT INTO `action_document_user`(`action_id`, `document_id`, `username`, `created_at`, `updated_at`) VALUES (4,_document_id,_user,NOW(),NOW());
                      SET p_users = INSERT(p_users,1,_nextlen + 1,'');
                    END LOOP;
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call clone_document(1,1,'',@res);
-- SELECT @res as res;


-- LISTO HISTORIAL
-- ----------------------------
-- PROCEDURE remove a share document 
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_Share_document`;
DELIMITER ;;
CREATE   PROCEDURE `delete_Share_document`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification` int,IN `p_owner` varchar(500), IN `p_user_logged` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _document_owner INT DEFAULT NULL;
  DECLARE _classification INT DEFAULT NULL;
      --  VARIABLES NEEDED FOR THE  HISTORIAL -- 
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_action int DEFAULT NULL;
   DECLARE h_action_name varchar(500) DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;
  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
   DECLARE h_user_logged VARCHAR(500) DEFAULT NULL;
  DECLARE h_version_num decimal(3,1) DEFAULT NULL;
  DECLARE h_owner_name VARCHAR(500) DEFAULT NULL;
  -- END OF THE VARIABLES NEEDED IN THE HISTORIAL --


	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
            		
                -- NECESARY FOR THE HISTORIAL --   
          -- select id, version into h_version_id, h_version_num from versions where document_id = p_id  ORDER BY `version` DESC LIMIT 1;           
                set h_action = 9;
                select description into h_action_name from actions where id = h_action;
                set h_user_name = NULL; 
                set h_version_id = NULL;
                set h_document_id = p_id; 
                set h_id_flow = NULL;
                set h_name_flow = NULL; 
                set h_document_name = NULL;
                set h_username = p_username;

               select description, flow_id into h_document_name, h_id_flow from documents where id = p_id LIMIT 1; -- listo
				      IF  h_id_flow != NULL THEN
               			 select description into h_name_flow from flows where id =  h_id_flow;
              END IF;
              select name into h_user_name from users where username = p_username LIMIT 1;
              select name into h_user_logged from users where username = p_user_logged LIMIT 1;
              set h_description =   CONCAT_WS(' ','El usuario ', h_user_logged ,'con identificación',p_user_logged, ' ha eliminado los permisos de acceso al usuario ', h_user_name,' sobre el  documento:',h_document_name,'con id',h_document_id );
                      
            -- END OF NECESARY FOR THE HISTORIAL --     

                SELECT `username` into _document_owner FROM `documents` WHERE `id`=p_id;
                IF _document_owner=p_username and p_owner!='' THEN
                  UPDATE `documents` SET `username`=p_owner,`updated_at`=Now() WHERE `id`=p_id;
                  SELECT name into h_owner_name from users where username = p_owner;
                  INSERT INTO `notifications`(`username`, `description`,`source`, `created_at`, `updated_at`) VALUES (_user, CONCAT('Se le entrego la propiedad del documento: ',h_document_name,', por el  usuario ',h_user_logged,' con identificación ',p_user_logged),"document",NOW(),NOW());
                  SET h_description =  CONCAT_WS(' ','Se actualizó el propietario del documento. El nuevo propietario es: ', h_owner_name,'con identificación', p_owner);


                ELSE 
                IF p_owner!='' THEN
                    SELECT `id` into _classification FROM `classifications` WHERE `type`=2 and `username`=p_username;
                    DELETE FROM `classification_document` WHERE `classification_id`=_classification and `document_id`=p_id;
                    DELETE FROM `action_document_user` WHERE `document_id`=p_id and `username`=p_username;
                  ELSE 

                    DELETE FROM `documents` WHERE `id`=p_id;
                    DELETE FROM `classification_document` WHERE `classification_id`=p_classification and `document_id`=p_id;
                  END IF;
                END IF;
                
                
                INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
                VALUES (h_action_name, p_user_logged, 	h_user_logged, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, h_id_flow, 	h_name_flow, NOW(),NOW());
              --  CALL insert_historial(h_action, h_username , h_user_name, h_description , h_document_id, h_document_name, h_version_id, h_id_flow,h_name_flow, @res);

            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_Share_document(1,'402340421',1,'402340421',@res);
-- SELECT @res as res;




-- ----------------------------------AGREGAR HISTORIAL
-- ----------------------------
-- PROCEDURE add  a usar fro share documento 
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_Share_document`;
DELIMITER ;;
CREATE  PROCEDURE `add_Share_document`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification` varchar(500),IN `p_owner` varchar(500),IN `p_actions` varchar(500),IN `p_user_logged` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _classification INT DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _action TEXT DEFAULT NULL;

      --  VARIABLES NEEDED FOR THE  HISTORIAL -- 
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_action int DEFAULT NULL;
  DECLARE h_action_name varchar(500) DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;
  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_logged VARCHAR(500) DEFAULT NULL;  
  DECLARE h_version_num decimal(3,1) DEFAULT NULL;
  DECLARE  h_description_2 text DEFAULT NULL;

  -- END OF THE VARIABLES NEEDED IN THE HISTORIAL --


	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
  GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;
      
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
  GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;

    START TRANSACTION; 

     -- NECESARY FOR THE HISTORIAL --   
          -- select id, version into h_version_id, h_version_num from versions where document_id = p_id  ORDER BY `version` DESC LIMIT 1;           
                set h_action = 3;
                select description into h_action_name from actions where id = h_action;
                set h_user_name = NULL; 
                set h_version_id = NULL;
                set h_document_id = p_id; 
                set h_id_flow = NULL;
                set h_name_flow = NULL; 
                set h_document_name = NULL;
                set h_username = p_username;

               select description, flow_id into h_document_name, h_id_flow from documents where id = p_id LIMIT 1; -- listo
				      IF  h_id_flow != NULL THEN
               			  select description into h_name_flow from flows where id =  h_id_flow;
              END IF;
                      select name into h_user_name from users where username = p_username LIMIT 1;
                      select name into h_user_logged from users where username = p_user_logged LIMIT 1;
   
              
            -- END OF NECESARY FOR THE HISTORIAL --   

              IF p_owner!=p_username THEN
                  IF p_classification='' THEN
                    SELECT `id` into _classification FROM `classifications` WHERE `type`=2 and `username`=p_username;
                    INSERT INTO `classification_document`(`classification_id`, `document_id`, `created_at`, `updated_at`) VALUES (_classification,p_id,NOW(),NOW());  
                  END IF;        
                  iterator:
                  LOOP
                        IF LENGTH(TRIM(p_actions)) = 0 OR p_actions IS NULL THEN
                        LEAVE iterator;
                        END IF;
                        SET _next = SUBSTRING_INDEX(p_actions,',',1);
                        SET _nextlen = LENGTH(_next);
                        SET _action = CAST(TRIM(_next) AS UNSIGNED);
                        INSERT INTO `action_document_user`(`action_id`, `document_id`, `username`, `created_at`, `updated_at`) VALUES (_action,p_id,p_username,NOW(),NOW());
                        SET p_actions = INSERT(p_actions,1,_nextlen + 1,'');
                        select description into h_action_name from actions where id = _action;
                        set h_description_2 =   CONCAT_WS(', ', h_description_2, h_action_name);
                      
                  END LOOP;
                  
                  SET h_description =   CONCAT_WS(' ','El usuario ',h_user_logged, 'con identificación',p_user_logged,' otorgó los siguientes permisos',  h_description_2, ' sobre el documento:',h_document_name ,'con id',h_document_id, 'al usuario:',  h_user_name, ' con identificación: ', h_username);
                  INSERT INTO `notifications`(`username`, `description`,`source`, `created_at`, `updated_at`) VALUES (p_username, CONCAT('El usuario ', h_user_logged ,' con identificación ',p_user_logged,', le compartio el documento: ',h_document_name),"document",NOW(),NOW());
              ELSE
                  SELECT `id` into _classification FROM `classifications` WHERE `type`=1 and `username`=p_username;
                  INSERT INTO `classification_document`(`classification_id`, `document_id`, `created_at`, `updated_at`) VALUES (_classification,p_id,NOW(),NOW());  
                  SET h_description =   CONCAT_WS(' ','El usuario ', h_user_logged, ' con identificación: ', p_user_logged, 'ha asociado el documento:',h_document_name,'con id',h_document_id , 'a la clasificación con id', _classification);
              END IF;

              INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
              VALUES (h_action_name, p_user_logged, 	h_user_logged, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, h_id_flow, 	h_name_flow, NOW(),NOW());

            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call add_Share_document(5,'116650288','','402340420','4',@res);
-- SELECT @res as res;





-- ----------------------------
-- PROCEDURE update a user share a document
-- return 0 success, 1 or 2 error in database, 3 the document already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_Share_document`;
DELIMITER ;;
CREATE  PROCEDURE `update_Share_document`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification` varchar(500),IN `p_owner` varchar(500),IN `p_actions` varchar(500), IN `p_user_logged` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _main_classification INT DEFAULT NULL; 
  DECLARE _share_classification INT DEFAULT NULL; 
  DECLARE _owner varchar(500) DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _action TEXT DEFAULT NULL;

  --  VARIABLES NEEDED FOR THE  HISTORIAL -- 
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_action int DEFAULT NULL;
  DECLARE h_action_name varchar(500) DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;
  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_owner_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_logged VARCHAR(500) DEFAULT NULL;   
  DECLARE h_version_num decimal(3,1) DEFAULT NULL;
  DECLARE h_description_2 text DEFAULT NULL;
  
  -- END OF THE VARIABLES NEEDED IN THE HISTORIAL --

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;
      
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;

  START TRANSACTION;
  -- NECESARY FOR THE HISTORIAL --   
      -- select id, version into h_version_id, h_version_num from versions where document_id = p_id  ORDER BY `version` DESC LIMIT 1;           
              set h_action = 5;
               select description into h_action_name from actions where id = h_action;
              set h_user_name = NULL; 
              set h_version_id = NULL;
              set h_document_id = p_id; 
              set h_id_flow = NULL;
              set h_name_flow = NULL; 
              set h_document_name = NULL;
              set h_username = p_username;

              select description, flow_id into h_document_name, h_id_flow from documents where id = p_id LIMIT 1; -- listo
				      IF  h_id_flow != NULL THEN
               		select description into h_name_flow from flows where id =  h_id_flow;
              END IF;
              select name into h_user_name from users where username = p_username LIMIT 1;
              select name into h_user_logged from users where username = p_user_logged LIMIT 1;
          -- END OF NECESARY FOR THE HISTORIAL --   

              SELECT `username` into _owner FROM `documents` WHERE `id`=p_id;
              DELETE FROM `action_document_user` WHERE `document_id`=p_id and `username`=p_username;
              IF _owner=p_username and p_owner!=p_username THEN

              SELECT `id` into _main_classification FROM `classifications` WHERE `type`=1 and `username`=p_username;
              IF _main_classification=p_classification THEN
                SELECT `id` into _share_classification FROM `classifications` WHERE `type`=2 and `username`=p_username;
                DELETE FROM `classification_document` WHERE `classification_id`=_main_classification and `document_id`=p_id;
                INSERT INTO `classification_document`(`classification_id`, `document_id`, `created_at`, `updated_at`) VALUES (_share_classification,p_id,NOW(),NOW()); 
              END IF;
                UPDATE `documents` SET `username`=p_owner,`updated_at`=Now() WHERE `id`=p_id;
                
                --  ----- historial actualizar propietario -----
                SELECT name into h_owner_name from users where username = p_owner;
                INSERT INTO `notifications`(`username`, `description`,`source`, `created_at`, `updated_at`) VALUES (_user, CONCAT('Se le entrego la propiedad del documento: ',h_document_name,', por el  usuario ',h_user_logged,' con identificación ',p_user_logged),"document",NOW(),NOW());
                SET h_description =  CONCAT_WS(' ','Se actualizó el propietario del documento. El nuevo propietario es: ', h_owner_name,'con identificación', p_owner);
                INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, flow_id, 	flow_name, 	created_at, 	updated_at) 
                VALUES (h_action_name, p_user_logged, 	h_user_logged, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, h_id_flow, 	h_name_flow, NOW(),NOW());
                
              END IF;
              IF p_owner!=p_username THEN
                iterator:
                  LOOP
                      IF LENGTH(TRIM(p_actions)) = 0 OR p_actions IS NULL THEN
                      LEAVE iterator;
                      END IF;
                      SET _next = SUBSTRING_INDEX(p_actions,',',1);
                      SET _nextlen = LENGTH(_next);
                      SET _action = CAST(TRIM(_next) AS UNSIGNED);
                      INSERT INTO `action_document_user`(`action_id`, `document_id`, `username`, `created_at`, `updated_at`) VALUES (_action,p_id,p_username,NOW(),NOW());
                      SET p_actions = INSERT(p_actions,1,_nextlen + 1,'');

                      select description into h_action_name from actions where id = _action;
                      set h_description_2 =   CONCAT_WS(', ', h_description_2, h_action_name);
                  END LOOP;

                SET h_description =   CONCAT_WS(' ','El usuario ',h_user_logged,'con identificación',p_user_logged,'Otorgó los siguientes permisos',  h_description_2, ' sobre el documento:',h_document_name ,'con id',h_document_id, 'al usuario:',  h_user_name, ' con identificación: ', h_username);
                INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
                VALUES (h_action_name, p_user_logged, 	h_user_logged, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, h_id_flow, 	h_name_flow, NOW(),NOW());

              END IF;
           COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call update_Share_document(2,'116650288','402340420','4,5,9',@res)
-- call update_Share_document(1,'402340420','116650288','4,5,9',@res)
-- SELECT @res as res;







-- PROCEDURE delete all of the steps
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_steps`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `delete_steps`(IN `p_idFlow` int,  OUT `res` TINYINT  UNSIGNED)
                                               
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
               DELETE FROM `steps` WHERE flow_id = p_idFlow ;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;



-- PROCEDURE insert a new step to a flow
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_steps_steps`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `delete_steps_steps`(IN `p_idFlow` int,  OUT `res` TINYINT  UNSIGNED)
                                               
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN

		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
               DELETE FROM `step_step` WHERE prev_flow_id = p_idFlow ;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_steps_steps(3,@res);





-- PROCEDURE delete all of the actions step users by flow
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_action_step_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `delete_action_step_user`(IN `p_idFlow` int,  OUT `res` TINYINT  UNSIGNED)
                                               
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
               DELETE FROM `action_step_user` WHERE flow_id = p_idFlow ;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;





-- PROCEDURE delete an action step users 
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_an_action_step_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `delete_an_action_step_user`(IN `p_idFlow` int, IN `p_idStep` varchar(500), IN `p_user` varchar(500),IN `p_action` int, OUT `res` TINYINT  UNSIGNED)
                                               
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
               DELETE FROM `action_step_user` WHERE flow_id = p_idFlow and  username = p_user and step_id = p_idStep and action_id = p_action ;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;



-- return 0 success, 1 or 2 database error, 3 the row already exists
DROP PROCEDURE IF EXISTS `insert_version`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_version`(IN `p_document_id` int,  IN `p_id_flow` int,IN `p_identifier` varchar(500), IN `p_size` varchar(500),IN `p_content` LONGTEXT,  IN `p_version` double,  IN `p_status` boolean, IN `p_user_logged` varchar(500),IN `p_user_Flow` text, OUT `res` TINYINT  UNSIGNED )
BEGIN                                                                -- document_id, flow_id, identifier, content,size, status, version, created_at, updated_at
  DECLARE idFlow INT DEFAULT NULL;
  DECLARE idIdentifier varchar(500) DEFAULT NULL; 
  DECLARE document_id INT DEFAULT NULL;

  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _user TEXT DEFAULT NULL;
  
  --  VARIABLES NEEDED FOR THE  HISTORIAL -- 
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_action int DEFAULT NULL;
  DECLARE h_action_name varchar(500) DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;
  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_owner_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_version_num decimal(3,1) DEFAULT NULL;
  DECLARE h_description_2 text DEFAULT NULL;

  -- END OF THE VARIABLES NEEDED IN THE HISTORIAL --


	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;
              SET idFlow = p_id_flow;
              SET idIdentifier = p_identifier;
              SET document_id =p_document_id;

                IF  p_id_flow = -1 THEN
                  set idFlow = NULL;
                END IF;
                IF  p_identifier = '-1' THEN
                  set idIdentifier = NULL;
                END IF;               

              INSERT INTO `versions`(document_id, flow_id, identifier, content,size, status, version, created_at, updated_at) VALUES (p_document_id, idFlow, idIdentifier, p_content, p_size, p_status, p_version, NOW(),NOW());
              SET h_version_id = LAST_INSERT_ID();
             -- NECESARY FOR THE HISTORIAL --   
              set h_action = 3;
               select description into h_action_name from actions where id = h_action;
              select name into h_user_name from users where username = p_user_logged LIMIT 1;        
              set h_document_id = p_document_id; 
              set h_id_flow = NULL;
              set h_name_flow = NULL; 
              set h_document_name = NULL;
            --  set h_username = p_username;
              set h_version_num = p_version;

              select description, flow_id into h_document_name, h_id_flow from documents where id = h_document_id LIMIT 1; -- listo
				      IF  h_id_flow != NULL THEN
               		select description into h_name_flow from flows where id =  h_id_flow;
              END IF;
              -- Cuando se agregue el usuario logueado habilitar esto
            --  select name into h_user_name from users where username = p_username LIMIT 1;
          
            iterator:
                LOOP
                    IF LENGTH(TRIM(p_user_Flow)) = 0 OR p_user_Flow IS NULL THEN
                    LEAVE iterator;
                    END IF;
                    SET _next = SUBSTRING_INDEX(p_user_Flow,',',1);
                    SET _nextlen = LENGTH(_next);
                    SET _user = CAST(TRIM(_next) AS UNSIGNED);
                    INSERT INTO `notifications`(`username`, `description`, `source`,`created_at`, `updated_at`) VALUES (_user, CONCAT('Tienes un documento en flujo pendiente'),"flow",NOW(),NOW());
                    SET p_user_Flow = INSERT(p_user_Flow,1,_nextlen + 1,'');

                END LOOP;


            SET h_description =   CONCAT_WS(' ','El usuario',h_user_name,'con identificación', p_user_logged,',agregó la versión ',h_version_num,'con id ', h_version_id, 'al documento ', h_document_name, 'con id', h_document_id);
            INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
            VALUES (h_action_name, p_user_logged, 	h_user_name, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, h_id_flow, 	h_name_flow, NOW(),NOW());
         --  END OF NECESARY FOR THE HISTORIAL --            
           
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
 --  call insert_version(21,15,'draggable1', '100', 'dfaddas', 2, true, @res);
 -- select @res as res




-- PROCEDURE update the doc when the next step is the final step
DROP PROCEDURE IF EXISTS `update_version_final`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_version_final`(IN `p_id_doc` int, IN `p_id_version` int, IN `p_user_logged` varchar(500), OUT `res` TINYINT  UNSIGNED )
BEGIN
  DECLARE idFlow INTEGER ; 
  DECLARE idIdentifier varchar(500);
  DECLARE n_owner_doc VARCHAR(500) DEFAULT NULL;

  --  VARIABLES NEEDED FOR THE  HISTORIAL -- 
  DECLARE h_version_id INT DEFAULT NULL;
  DECLARE h_action int DEFAULT NULL;
  DECLARE h_action_name varchar(500) DEFAULT NULL;
  DECLARE h_username varchar(500) DEFAULT NULL;
  DECLARE h_description text DEFAULT NULL;
  DECLARE h_document_id INT DEFAULT NULL;
  DECLARE h_document_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_id_flow INT DEFAULT NULL;
  DECLARE h_name_flow VARCHAR(500) DEFAULT NULL;
  DECLARE h_user_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_owner_name VARCHAR(500) DEFAULT NULL;
  DECLARE h_version_num decimal(3,1) DEFAULT NULL;
  DECLARE h_description_2 text DEFAULT NULL;

  -- END OF THE VARIABLES NEEDED IN THE HISTORIAL --


	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
  GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
  GET DIAGNOSTICS CONDITION 1
@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT;
SELECT @p1 as RETURNED_SQLSTATE  , @p2 as MESSAGE_TEXT;
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
          START TRANSACTION;
              UPDATE `documents` SET `flow_id`=NULL,`updated_at`=NOW() WHERE `id`=p_id_doc;
              UPDATE `versions` SET `status`=false,`updated_at`=NOW() WHERE `id`=p_id_version;


      -- NECESARY FOR THE HISTORIAL --   
              set h_action = 3;
               select description into h_action_name from actions where id = h_action;
              select name into h_user_name from users where username = p_user_logged LIMIT 1;              
              set h_document_id = p_id_doc; 
              set h_id_flow = NULL;
              set h_name_flow = NULL; 
              set h_document_name = NULL;
            --  set h_username = p_username;
           --   set h_version_num = p_version;
              set h_version_id =  p_id_version;
              select version into   h_version_num from versions where id = p_id_version ;

              select description, flow_id,username into h_document_name, h_id_flow,n_owner_doc from documents where id = h_document_id LIMIT 1; -- listo
				      IF  h_id_flow != NULL THEN
               		select description into h_name_flow from flows where id =  h_id_flow;
              END IF;
              -- Cuando se agregue el usuario logueado habilitar esto
            --  select name into h_user_name from users where username = p_username LIMIT 1;
          
           INSERT INTO `notifications`(`username`, `description`,`source`, `created_at`, `updated_at`) VALUES (n_owner_doc, CONCAT_WS('el documento ', h_document_name,' a salido del flujo ',h_name_flow  ),"document",NOW(),NOW());
            SET h_description =   CONCAT_WS(' ','El usuario',h_user_name,'con identificación', p_user_logged,', ha sacado del flujo',h_name_flow ,'con id',h_id_flow,'el documento ', h_document_name, 'con id', h_document_id, '.' );
            INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) 
            VALUES (h_action_name, p_user_logged, 	h_user_name, 	h_description, 	h_document_id, 	h_document_name, 	h_version_id, h_id_flow, 	h_name_flow, NOW(),NOW());      

            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
 --  call update_version_final(22,22, @res);
 -- select @res as res




-- PROCEDURE update the doc when the next step is the final step
DROP PROCEDURE IF EXISTS `update_version_status`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_version_status`(IN `p_id_version` int, IN `p_status` boolean, OUT `res` TINYINT  UNSIGNED )
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;              
              UPDATE `versions` SET `status`=p_status,`updated_at`=NOW() WHERE `id`=p_id_version;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;




-- PROCEDURE update the doc when the next step is the final step
DROP PROCEDURE IF EXISTS `update_document_status`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_document_status`(IN `p_id_document` int, IN `p_status` int, OUT `res` TINYINT  UNSIGNED )
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;              
              UPDATE `documents` SET `action_id`=p_status,`updated_at`=NOW() WHERE `id`=p_id_document;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;

-- PROCEDURE update the doc when the next step is the final step
DROP PROCEDURE IF EXISTS `insert_note`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_note`(IN version int,IN content text, OUT `res` TINYINT  UNSIGNED )
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;              
                INSERT INTO `notes`(version_id, content, created_at, updated_at) VALUES (version, content, NOW(),NOW());
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;




-- PROCEDURE change the active flow status 
DROP PROCEDURE IF EXISTS `active_flow`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `active_flow`(IN `p_id_flow` int, IN `p_status` TINYINT, OUT `res` TINYINT  UNSIGNED )
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION;              
              UPDATE `flows` SET `state`=p_status, `updated_at`=NOW() WHERE `id`=p_id_flow;
            IF p_status = 0 THEN
              UPDATE `documents` SET `flow_id`=NULL, `updated_at`=NOW() WHERE `flow_id`=p_id_flow;           
            END IF;
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;

-- ----------------------------
-- PROCEDURE clone a flow
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `clone_flow`;
DELIMITER ;;
CREATE   PROCEDURE `clone_flow`(IN `p_id` int,IN `p_user_logged` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _flow_id INT DEFAULT NULL;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
            START TRANSACTION; 

            INSERT INTO `flows`(`username`, `description`, `state`, `created_at`, `updated_at`)
            SELECT `username`, CONCAT('copy-',`description`), 0,NOW(),NOW() FROM `flows` WHERE `id`=p_id;
            SET _flow_id =  LAST_INSERT_ID(); 

            INSERT INTO `steps`(`id`, `flow_id`, `description`, `axisX`, `axisY`, `created_at`, `updated_at`)
            SELECT `id`, _flow_id, `description`, `axisX`, `axisY`, NOW(), NOW() FROM `steps` WHERE `flow_id`=p_id;

            INSERT INTO `step_step`(`prev_step_id`, `next_step_id`, `prev_flow_id`, `next_flow_id`, `id_action`, `created_at`, `updated_at`) 
            SELECT `prev_step_id`, `next_step_id`, _flow_id, _flow_id, `id_action`, NOW(), NOW() FROM `step_step` WHERE `next_flow_id`=p_id;

            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;



-- PROCEDURE update the doc when the next step is the final step
DROP PROCEDURE IF EXISTS `insert_historial`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_historial`(IN p_action int, IN p_username varchar(500), IN p_name_user varchar(500), IN	p_description text, IN p_document_id int, 	IN p_document_name varchar(500), IN p_version_id int, IN	p_flow_id int, IN	p_flow_name varchar(500), OUT `res` TINYINT  UNSIGNED )
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
        START TRANSACTION;     
            INSERT INTO `historials`(action, username, 	name_user, 	description, 	document_id, 	document_name, 	version_id, 	flow_id, 	flow_name, 	created_at, 	updated_at) VALUES (p_action, p_username, 	p_name_user, 	p_description, 	p_document_id, 	p_document_name, 	p_version_id, 	p_flow_id, 	p_flow_name, NOW(),NOW());
        COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_historial(1,'116650288','FRANCINI CORRALES GARRO', 'eSTO ES UNA PRUEBA',4,'Tell me', 3,NULL,NULL, @res);
-- select @res as res

DROP PROCEDURE IF EXISTS `clear_notifications`;
DELIMITER ;; 
CREATE DEFINER=`root`@`localhost`  PROCEDURE `clear_notifications`(IN p_username varchar(500), OUT `res` TINYINT  UNSIGNED )
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;                                        
  DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		-- ERROR
    SET res = -2;
    ROLLBACK;
	END;
        START TRANSACTION;     
            DELETE FROM `notifications` WHERE  `username`=p_username;
        COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call clear_notifications('116650288', @res);
-- select @res as res








-- DROP VIEW IF EXISTS view_document_version ;
-- CREATE VIEW view_document_version AS 
-- SELECT  doc.id as document_id, doc.flow_id, doc.action_id, doc.username, doc.description as document_description, doc.summary, doc.code, doc.created_at as document_create, doc.updated_at document_update,
--  ver.id as version_id, ver.document_id as doc_ver_id, ver.identifier, ver.content, ver.size, ver.type, ver.version, ver.created_at as version_create, ver.updated_at as version_update,
-- user.name, act.color, act.state, act.description as action_description
--     FROM documents doc, versions ver, users user, actions act
-- where doc.id =  ver.document_id
    



    
-- DROP VIEW IF EXISTS view_document_version ;
--  CREATE VIEW view_document_version AS 
-- SELECT ver.id as version_id, ver.document_id, ver.identifier, ver.content, ver.size, ver.type, ver.version, ver.created_at as version_create, ver.updated_at as version_update,
 -- doc.flow_id, doc.action_id, doc.username, doc.description as document_description, doc.summary, doc.code, doc.created_at as document_create, doc.updated_at document_update, user.name
-- FROM versions ver 
-- INNER JOIN 
-- documents doc ON ver.document_id=doc.id
-- INNER JOIN
--     users user ON user.username = doc.username





-- INSERT INTO `historials`(`action`, `username`, `user_id`, `description`, `document_id`, `document_name`, `version_id`, `flow_id`, `flow_name`, `created_at`, `updated_at`) VALUES (1,'DANNY VALERIO','402340420','El usuario Danny Valerio no trabajo el día de hoy en la tesis',1,'Prueba',1,1,'PFESA', NOW(),NOW())
-- INSERT INTO `notes`(`version_id`, `content`, `created_at`, `updated_at`) VALUES (1,'NO vamos a terminar esto',NOW(),NOW())



-- VISTAS 

DROP VIEW IF EXISTS view_flow_user ;
CREATE VIEW view_flow_user AS 
 SELECT DISTINCT  asu.username, asu.flow_id, f.description, f.state,f.num_doc
    FROM `action_step_user` asu, 
	 (SELECT id,description,state, num_doc from flows
		RIGHT JOIN (SELECT flow_id ,COUNT(id) num_doc  FROM documents WHERE flow_id IS NOT NULL GROUP BY flow_id) doc
		ON doc.flow_id=flows.id) f
    WHERE f.id = asu.flow_id and f.state = 1
;;
DELIMITER ;


DROP VIEW IF EXISTS view_action_step_step_user ;
CREATE VIEW view_action_step_step_user AS 
SELECT ss.id_action,asu.step_id, asu.flow_id, asu.username, ac.description
from step_step ss, action_step_user asu, actions ac
WHERE ss.id_action = asu.action_id 
AND  ss.prev_step_id =  asu.step_id 
AND asu.flow_id = ss.prev_flow_id
AND ac.id = ss.id_action
;;
DELIMITER ;
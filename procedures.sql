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
CREATE   PROCEDURE `insert_user`(IN `p_role_id` int,IN `p_department_id` int,IN `p_name` varchar(500),IN `p_username` varchar(500),IN `p_email` varchar(500),IN `p_password` varchar(500),IN `p_classification` varchar(500),IN `p_share_classification` varchar(500), OUT `res` TINYINT  UNSIGNED)
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
                    INSERT INTO `users`(role_id,department_id,name,username,email,password,created_at,updated_at) VALUES (p_role_id,p_department_id,p_name,p_username,p_email,p_password, NOW(),NOW());
                    INSERT INTO `classifications`(username, description, is_Start, created_at, updated_at) VALUES (p_username,p_classification,1, NOW(),NOW());
                    INSERT INTO `classifications`(username, description, is_Start, created_at, updated_at) VALUES (p_username,p_share_classification,2, NOW(),NOW());
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_user(1,1,'Danny','402340421','user@gmail.com','created with ldap','Sin clasificacion',@res);
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
            IF p_update_password then
            
              UPDATE `users` SET `role_id`=p_role_id,`department_id`=p_department_id,`name`=p_name,`email`=p_email,`password`=p_password,`updated_at`=NOW() WHERE `username`=p_username;
            ELSE
        
              UPDATE `users` SET `role_id`=p_role_id,`department_id`=p_department_id,`name`=p_name,`email`=p_email,`password`=p_password,`updated_at`=NOW() WHERE `username`=p_username;
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
CREATE  PROCEDURE `insert_classification`(IN `p_description` varchar(500),IN `p_current_classification` int,IN `p_username` varchar(500),OUT `res` TINYINT  UNSIGNED)
BEGIN
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
                   
                    INSERT INTO `classifications`(username, description, type, created_at, updated_at) VALUES (p_username,p_description,3, NOW(),NOW());
                    SET p_id = LAST_INSERT_ID();
                    INSERT INTO `classification_classification`(`first_id`, `second_id`, `created_at`, `updated_at`) VALUES (p_current_classification,p_id,NOW(),NOW());
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_classification('mi clasificacion',1,'402340421',@res);
-- SELECT @res as res;


-- ----------------------------
-- PROCEDURE delete a classification
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_classification`;
DELIMITER ;;
CREATE   PROCEDURE `update_classification`( IN `p_description` varchar(500),IN `p_current_classification` int,IN `p_id` int, OUT `res` TINYINT  UNSIGNED)
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
                  DELETE FROM `classification_classification` WHERE `second_id`=p_id;
                  INSERT INTO `classification_classification`(`first_id`, `second_id`, `created_at`, `updated_at`) VALUES (p_current_classification,p_id,NOW(),NOW());
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call update_classification(2,'mis documentos',1,@res);
-- SELECT @res as res;


-- ----------------------------
-- PROCEDURE delete a classification
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_classification`;
DELIMITER ;;
CREATE   PROCEDURE `delete_classification`(IN `p_id` int,IN `p_username` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE owner_username varchar(500);
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
                  select username into owner_username  from `classifications` WHERE `id`=p_id; 
                  IF owner_username=p_username then
                    DELETE FROM `classifications` WHERE `id`=p_id;
                    DELETE FROM `documents` WHERE NOT EXISTS (SELECT null from `classification_document` WHERE classification_document.document_id=documents.id) and documents.flow_id IS NULL;                    
                  ELSE
                    DELETE FROM `classification_classification` WHERE `second_id`=p_id;
                  END IF;
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_classification(2,'402340420',@res);
-- SELECT @res as res;


-- ----------------------------
-- PROCEDURE delete user for a classification
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `delete_Share_Classification`;
DELIMITER ;;
CREATE  PROCEDURE `delete_Share_Classification`(IN `p_id` int,In `p_id_parent` int,IN `p_username` varchar(500),IN `p_classification_owner` varchar(500),IN `p_documents` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
  DECLARE _classification_owner varchar(500) DEFAULT NULL;
  DECLARE _principal_classification INT DEFAULT NULL;
  DECLARE _document_owner varchar(500) DEFAULT NULL;
  DECLARE _next TEXT DEFAULT NULL;
  DECLARE _nextlen INT DEFAULT NULL;
  DECLARE _document TEXT DEFAULT NULL;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		-- ERROR
    SET res = -1;
    ROLLBACK;
	END;

            START TRANSACTION;
            
                SELECT `username` into _classification_owner FROM `classifications` WHERE `id`=p_id;
                IF _classification_owner=p_username THEN
                   UPDATE `classifications` SET `username`=p_classification_Owner,`updated_at`=Now() WHERE `id`=p_id;
                END IF;
                DELETE FROM `classification_classification` WHERE `first_id`=p_id_parent and `second_id`=p_id;
                DELETE FROM `action_classification_user` WHERE `classification_id`=p_id and `username`=p_username;
              iterator:
                LOOP
                    IF LENGTH(TRIM(p_documents)) = 0 OR p_documents IS NULL THEN
                    LEAVE iterator;
                    END IF;
                    SET _next = SUBSTRING_INDEX(p_documents,',',1);
                    SET _nextlen = LENGTH(_next);
                    SET _document = CAST(TRIM(_next) AS UNSIGNED);
                    SELECT `username` into _document_owner FROM `documents` WHERE `id`=_document;
                    IF _document_owner=p_username THEN
                      select `id` into _principal_classification FROM `classifications` where `type`=1 and `username`=p_username;
                      INSERT INTO `classification_classification`(`first_id`, `second_id`, `created_at`, `updated_at`) VALUES (_principal_classification,p_id,NOW(),NOW());
                    ELSE
                      DELETE FROM `action_document_user` WHERE `document_id`=_document and `username`=p_username;

                    END IF;
                    SET p_documents = INSERT(p_documents,1,_nextlen + 1,'');
                  END LOOP;
            
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call delete_Share_Classification(5, 4,'116650288','1','402340420',@res);
-- SELECT @res as res;


-- ----------------------------
-- PROCEDURE add user for a classification
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `add_Share_Classification`;
DELIMITER ;;
CREATE  PROCEDURE `add_Share_Classification`(IN `p_id` int,In `p_id_parent` int,IN `p_username` varchar(500),IN `p_classification_owner` varchar(500),IN `p_actions` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN

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
                INSERT INTO `classification_classification`(`first_id`, `second_id`, `created_at`, `updated_at`) VALUES (p_id_parent,p_id,NOW(),NOW());
                IF p_classification_owner=p_username THEN
                  UPDATE `classifications` SET `username`=p_classification_Owner,`updated_at`=Now() WHERE `id`=p_id;
                ELSE
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
-- call add_Share_Classification(5, 4,'116650288','4',@res);
-- SELECT @res as res;



-- ----------------------------
-- PROCEDURE add user for a classification
-- return 0 success, 1 or 2 error in database, 3 the classification already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_Share_Classification`;
DELIMITER ;;
CREATE  PROCEDURE `update_Share_Classification`(IN `p_id` int,IN `p_username` varchar(500),IN `p_classification_owner` varchar(500),IN `p_actions` varchar(500), OUT `res` TINYINT  UNSIGNED)
BEGIN
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
              DELETE FROM `action_classification_user` WHERE `classification_id`=p_id and `username`=p_username;
              IF p_classification_owner=p_username THEN
                UPDATE `classifications` SET `username`=p_classification_Owner,`updated_at`=Now() WHERE `id`=p_id;
              ELSE
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
-- call update_Share_Classification(5,'116650288','4',@res);
-- SELECT @res as res;

-- PROCEDURE insert a new flow
-- return 0 success, 1 or 2 database error, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_flow`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_flow`(IN `p_username` varchar(500), IN `p_description` varchar(500), OUT `res` TINYINT  UNSIGNED, OUT `id_flow` INT  UNSIGNED)
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
                   INSERT INTO `flows`(username, description,created_at,updated_at) VALUES (p_username, p_description, NOW(),NOW());
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
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_flow`(IN `p_idFlow` int, IN `p_username` varchar(500), IN `p_description` varchar(500), OUT `res` TINYINT  UNSIGNED, OUT `id_flow` INT  UNSIGNED)
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
                  DELETE FROM `flows` WHERE id = p_idFlow;
                  INSERT INTO `flows`(username, description,created_at,updated_at) VALUES (p_username, p_description, NOW(),NOW());
           COMMIT;
            SET id_flow = LAST_INSERT_ID();
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
                 INSERT INTO `action_step_user`(created_at, 	updated_at, step_id, flow_id, username, action_id ) VALUES (NOW(),NOW(),p_id, p_id_flow, p_username, p_action);
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;

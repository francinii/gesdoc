-- ----------------Procedimientos almacenados----------------------------------
-- ----------------------------
-- PROCEDURE insert a new department
-- return 0 success, 1 or 2 error in database, 3 the department already exists
-- ----------------------------
DROP PROCEDURE IF EXISTS `insert_department`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_department`(IN `p_description` varchar(500), OUT `res` TINYINT  UNSIGNED)
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
CREATE DEFINER=`root`@`localhost`  PROCEDURE `delete_department`(IN `p_id` int, OUT `res` TINYINT  UNSIGNED)
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
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_department`(IN `p_id` int, IN `p_description` varchar(500), OUT `res` TINYINT  UNSIGNED)
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
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_role`(IN `p_description` varchar(500),IN `p_permissions` varchar(500),
OUT `res` TINYINT  UNSIGNED)
BEGIN
DECLARE _next TEXT DEFAULT NULL;
DECLARE _nextlen INT DEFAULT NULL;
DECLARE _value TEXT DEFAULT NULL;
declare p_id Integer;
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
CREATE DEFINER=`root`@`localhost`  PROCEDURE `delete_role`(IN `p_id` int, OUT `res` TINYINT  UNSIGNED)
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
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_role`(IN `p_id` int,IN `p_description` varchar(500),IN `p_permissions` varchar(500),
OUT `res` TINYINT  UNSIGNED)
BEGIN
DECLARE _next TEXT DEFAULT NULL;
DECLARE _nextlen INT DEFAULT NULL;
DECLARE _value TEXT DEFAULT NULL;
declare p_role_id Integer;
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
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_user`(IN `p_role_id` int,IN `p_department_id` int,IN `p_name` varchar(500),IN `p_username` int,IN `p_email` varchar(500),IN `p_password` varchar(500),IN `p_classification` varchar(500), OUT `res` TINYINT  UNSIGNED)
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
                    INSERT INTO `classifications`(username, description, is_Start, created_at, updated_at) VALUES (p_username,p_classification,true, NOW(),NOW());
            COMMIT;
            -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
-- call insert_user(1,1,'Danny',406750539,'user@gmail.com','created with ldap',@res);
-- SELECT @res as res;

-- ----------------------------
-- PROCEDURE delete a department
-- return 0 success, 1 or 2 error in database
-- ----------------------------
DROP PROCEDURE IF EXISTS `update_department`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `update_department`(IN `p_id` int, IN `p_description` varchar(500), OUT `res` TINYINT  UNSIGNED)
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
DROP PROCEDURE IF EXISTS `insert_step_user`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost`  PROCEDURE `insert_step_user`(IN `p_id` varchar(500), IN `p_username` varchar(500),IN `p_id_flow` int, OUT `res` TINYINT  UNSIGNED)
                                               
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
                 INSERT INTO `step_user`(step_id,	flow_id, username, 	created_at, 	updated_at ) VALUES (p_id, p_username, p_id_flow, NOW(),NOW());
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
                 INSERT INTO `action_step_user`(step_id, flow_id, username, action_id,	created_at, 	updated_at ) VALUES (p_id, p_id_flow, p_username, p_action, NOW(),NOW());
            COMMIT;
          -- SUCCESS
SET res = 0;
END
;;
DELIMITER ;
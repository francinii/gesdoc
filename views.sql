DROP VIEW IF EXISTS view_flow_user ;
CREATE VIEW view_flow_user AS 
    SELECT DISTINCT  asu.username, asu.flow_id, f.description
    FROM `action_step_user` asu, flows f
    WHERE f.id = asu.flow_id
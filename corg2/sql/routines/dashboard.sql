--
-- DASHBOARD
--

DELIMITER ;;

-- GETTERS

CREATE PROCEDURE get_all_activities_for_dashboard
()
BEGIN
    SELECT activity.id, activity.mtime, customer.org, activity.name
    FROM customer, activity
    WHERE customer.id = activity.customer_id
    ORDER BY activity.mtime DESC
    LIMIT 25;
END;;

CREATE PROCEDURE get_all_customers_for_dashboard
()
BEGIN
    SELECT id, rev, org
    FROM customer
    ORDER BY rev DESC, LENGTH(org) ASC, org ASC
    LIMIT 25;
END;;

CREATE PROCEDURE get_all_files_for_dashboard
()
BEGIN
    SELECT file.id, file.mtime, file.name, activity.name AS activity_name
    FROM reference, file, activity
    WHERE reference.file_id = file.id
        AND reference.activity_id = activity.id
    ORDER BY file.mtime DESC, activity_name ASC, file.name ASC
    LIMIT 25;
END;;

-- SETTERS
-- UNSETTERS
-- MISC

DELIMITER ;

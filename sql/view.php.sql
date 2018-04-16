/*
* Query for view.php
*/

-- information teams and training
SELECT e.first_name, 
	e.last_name, 
    e.email_address, 
    e.city, 
    e.country, 
	CONCAT(m.first_name, ' ', m.last_name) AS manager_name,
    mt.team,
    mt.team_name,
    mt.role,
    tec.status, 
    tec.course_name, 
    tec.course_code, 
    tec.trainer,
	tec.dates
FROM employees e
LEFT OUTER JOIN employees m ON e.managers_nbr = m.employee_nbr
LEFT OUTER JOIN (
	SELECT employee_nbr,
		CASE
			WHEN type = 'AT' THEN 'Agile Team'
			WHEN type = 'ART' THEN 'Agile Release Train'
			WHEN type = 'ST' THEN 'Solution Train'
		END AS Team,
		name AS 'team_name',
		role
	FROM trains_and_teams t
	JOIN membership m
	ON t.team_id = m.team_id
    ) mt ON e.employee_nbr = mt.employee_nbr
LEFT OUTER JOIN (
	SELECT te.first_name, te.last_name, tc.status, tc.course_name, tc.course_code, CONCAT(tc.trainer_first_name, ' ', tc.trainer_last_name) AS trainer,
		CONCAT(DATE_FORMAT(tc.start_date, '%m/%d/%Y'), ' - ', DATE_FORMAT(tc.end_date, '%m/%d/%Y')) AS dates
	FROM training_calendar tc
	JOIN training_enrollment te ON tc.training_id = te.training_id
    ) tec ON (e.first_name = tec.first_name AND e.last_name = tec.last_name)
WHERE e.employee_nbr LIKE '%70043'
AND mt.role LIKE '%';

/*
* Separated queries
*/ 
-- Employees
SELECT e.employee_nbr,
	e.first_name, 
	e.last_name, 
    e.email_address, 
    e.city, 
    e.country, 
	CONCAT(m.first_name, ' ', m.last_name) AS manager_name
FROM employees e
LEFT OUTER JOIN employees m ON e.managers_nbr = m.employee_nbr
WHERE e.email_address LIKE '%' LIMIT 1; -- This is to be parameterized. Email as ID?

-- Membership and trains
SELECT employee_nbr,
	CASE
		WHEN type = 'AT' THEN 'Agile Team'
		WHEN type = 'ART' THEN 'Agile Release Train'
		WHEN type = 'ST' THEN 'Solution Train'
	END AS Team,
	name AS 'team_name',
	role
FROM trains_and_teams t
JOIN membership m
ON t.team_id = m.team_id;
-- Get the employee nbr and compare with the membership table
-- will need to bring up data in 3 cases but the membership table 
-- only has members that are in an agile team

SELECT m.employee_nbr,
	m.role, 
    tt_at.name AS at_name, 
    tt_art.name AS art_name, 
    tt_st.name AS st_name
FROM trains_and_teams tt_at
JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
LEFT OUTER JOIN membership m ON tt_at.team_id = m.team_id
WHERE employee_nbr = '3733';

-- Training
SELECT te.first_name, 
	te.last_name, 
    tc.status, 
    tc.course_name, 
    tc.course_code, 
    CONCAT(tc.trainer_first_name, ' ', tc.trainer_last_name) AS trainer,
	CONCAT(DATE_FORMAT(tc.start_date, '%m/%d/%Y'), ' - ', DATE_FORMAT(tc.end_date, '%m/%d/%Y')) AS date_range
FROM training_calendar tc
JOIN training_enrollment te ON tc.training_id = te.training_id
JOIN employees e ON (
	e.first_name = te.first_name AND
    e.last_name = te.last_name AND
    e.email_address = te.email)
WHERE e.first_name LIKE '%'
AND e.last_name LIKE '%'
AND e.email_address LIKE '%';
-- Going to need the employees first and last name and email address to identify enrollment


-- Single query
SELECT e.employee_nbr,
	e.first_name, 
	e.last_name, 
    e.email_address, 
    e.city, 
    e.country, 
	CONCAT(m.first_name, ' ', m.last_name) AS manager_name,
    mt.role,
    mt.at_name,
    mt.art_name,
    mt.st_name,
    tec.status,
    tec.course_name,
    tec.course_code,
    tec.trainer,
    tec.dates
FROM employees e
LEFT OUTER JOIN employees m ON e.managers_nbr = m.employee_nbr
LEFT OUTER JOIN (
	SELECT m.employee_nbr,
		m.role, 
		tt_at.name AS at_name, 
		tt_art.name AS art_name, 
		tt_st.name AS st_name
	FROM trains_and_teams tt_at
	JOIN trains_and_teams tt_art ON tt_at.parent = tt_art.team_id
	JOIN trains_and_teams tt_st ON tt_art.parent = tt_st.team_id
	LEFT OUTER JOIN membership m ON tt_at.team_id = m.team_id) mt
    ON e.employee_nbr = mt.employee_nbr
LEFT OUTER JOIN (
	SELECT te.first_name, 
		te.last_name,
        te.email AS email_address,
		tc.status, 
		tc.course_name, 
		tc.course_code, 
		CONCAT(tc.trainer_first_name, ' ', tc.trainer_last_name) AS trainer,
		CONCAT(DATE_FORMAT(tc.start_date, '%m/%d/%Y'), ' - ', DATE_FORMAT(tc.end_date, '%m/%d/%Y')) AS dates
	FROM training_calendar tc
	JOIN training_enrollment te ON tc.training_id = te.training_id) tec
	ON (e.first_name = tec.first_name
		AND e.last_name = tec.last_name
        AND e.email_address = tec.email_address
        )
WHERE e.employee_nbr LIKE '%';

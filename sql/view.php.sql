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
WHERE e.employee_nbr LIKE '%';

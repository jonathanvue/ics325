USE safe_explorer;
SET FOREIGN_KEY_CHECKS=0;
INSERT INTO employees
VALUES (1000000, 'last', 'first', 'City A', 'ZA', NULL, 'first.last@gmail.com', 1, 'Trainer', 'Team Z'),
(1000001, 'last1', 'first1', 'City B', 'ZA', NULL, 'first1.last1@gmail.com', 1, 'Trainer', 'Team Z'),
(1000002, 'last2', 'first2', 'City C', 'ZA', NULL, 'first2.last2@gmail.com', 1, 'Trainer', 'Team Z'),
(1000003, 'last3', 'first3', 'City D', 'ZA', NULL, 'first3.last3@gmail.com', 1, 'Trainer', 'Team Z')
;
SET FOREIGN_KEY_CHECKS=1;
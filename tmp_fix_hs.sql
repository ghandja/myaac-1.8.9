UPDATE myaac_settings SET value = '8,23,24,25,26,39' WHERE name = 'core' AND `key` = 'highscores_ids_hidden';
DELETE FROM myaac_settings WHERE name = 'core' AND `key` = 'highscores_groups_hidden';
INSERT INTO myaac_settings (name, `key`, value) VALUES ('core', 'highscores_groups_hidden', '2');

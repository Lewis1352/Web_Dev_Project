  DROP DATABASE IF EXISTS coursework;

  CREATE DATABASE coursework COLLATE `utf8_unicode_ci`;

  CREATE TABLE coursework.messages (id INT NOT NULL AUTO_INCREMENT, received_date datetime, bearer VARCHAR(50), soursemsisdn VARCHAR(252), destinationmsisdn VARCHAR(252), fan VARCHAR(252), heater VARCHAR(252), keypad varchar(1), switch_1 VARCHAR(10), switch_2 VARCHAR(10), switch_3 VARCHAR(10), switch_4 VARCHAR(10),PRIMARY KEY (id));

  GRANT SELECT, INSERT, UPDATE ON coursework.* TO 'coursework_user'@'localhost' IDENTIFIED BY 'coursework_user_pass';

  INSERT INTO coursework.messages (received_date, bearer, soursemsisdn, destinationmsisdn, fan, heater, keypad, switch_1, switch_2, switch_3, switch_4)
  VALUES ('2020-01-13 19:23:56', 'SMS', '447817814149', '447817814149', 'forward', 21, 5, 'on', 'on', 'on', 'on');

  INSERT INTO coursework.messages (received_date, bearer, soursemsisdn, destinationmsisdn, fan, heater, keypad, switch_1, switch_2, switch_3, switch_4)
  VALUES ('2020-11-01 17:12:02', 'SMS', '447817814149', '447817814149', 'reverse', 24, 2, 'on', 'off', 'on', 'on');

  INSERT INTO coursework.messages (received_date, bearer, soursemsisdn, destinationmsisdn, fan, heater, keypad, switch_1, switch_2, switch_3, switch_4)
  VALUES ('2020-09-01 15:43:23', 'SMS', '447817814149', '447817814149', 'forward', 19, 5, 'off', 'on', 'on', 'on');

  INSERT INTO coursework.messages (received_date, bearer, soursemsisdn, destinationmsisdn, fan, heater, keypad, switch_1, switch_2, switch_3, switch_4)
  VALUES ('2020-02-01 14:24:30', 'SMS', '447817814149', '447817814149', 'reverse', 25, 9, 'on', 'off', 'on', 'on');

  INSERT INTO coursework.messages (received_date, bearer, soursemsisdn, destinationmsisdn, fan, heater, keypad, switch_1, switch_2, switch_3, switch_4)
  VALUES ('2020-09-01 14:20:58', 'SMS', '447817814149', '447817814149', 'forward', 17, 4, 'on', 'on', 'on', 'off');


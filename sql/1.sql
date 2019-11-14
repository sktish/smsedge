create schema smsedge;

create table countries
(
	cnt_id char(36) NOT null,
	cnt_code char(2) NOT null,
	cnt_title varchar(255) NOT null,
	cnt_created datetime NOT null
);

create table numbers
(
	num_id char(36) NOT null,
	cnt_id char(36) NOT null,
	num_number varchar(255) NOT null,
	num_created datetime NOT null
);

create table send_log
(
	log_id char(36) NOT null,
	usr_id char(36) NOT null,
	num_id char(36) NOT null,
	log_message varchar(255) NOT null,
	log_success tinyint(1) NOT null,
	log_created datetime NOT null
);

create table send_log_aggregated
(
	aggregation_date date null,
	log_total_count int not null,
	log_success_count int not null,
	usr_id char(36) not null,
	num_id char(36) not null
);

create table users
(
	usr_id char(36) NOT null,
	usr_name varchar(255) NOT null,
	usr_active tinyint(1) NOT null,
	usr_created datetime NOT null
);


INSERT into send_log_aggregated (aggregation_date, log_total_count, log_success_count, usr_id, num_id)
  SELECT
  DATE(send_log.log_created),
  COUNT(send_log.log_id) as total,
  COUNT(CASE WHEN send_log.log_success = 1 THEN TRUE ELSE NULL END) as success,
  usr_id,
  num_id
  FROM send_log
  GROUP BY DATE(send_log.log_created),send_log.usr_id, send_log.num_id;

DELETE from send_log;

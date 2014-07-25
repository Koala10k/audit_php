use pengd;
-- drop table audit_transaction;
-- drop table audit_session;

create table audit_session (
id int not null auto_increment,
bill_script varchar(255) not null,
trans_date timestamp not null default NOW(),
fare_amount decimal(6, 2) not null default 0,

constraint pk_session_id primary key (id)
);

create table audit_transaction (
id int not null auto_increment,
`name` varchar(50) not null,
datefrom date not null,
dateto date not null,
ex_weeks int not null,
sessionID int,
shared_fare varchar(25) not null default 0,
unit_cost decimal(6, 2) not null default 0,

constraint pk_transaction_id primary key (id),
constraint fk_sessionID foreign key (sessionID) references audit_session(id)
);

select * from audit_session;

insert into audit_session (bill_script, fare_amount) value (CONCAT('./trans_scripts/',DATE_FORMAT(NOW(), '%y%m%d%H%i%s')), 1035.66);
insert into audit_session (bill_script, fare_amount) value (CONCAT('./trans_scripts/',DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 DAY), '%y%m%d%H%i%s')), 234.54);
insert into audit_transaction (`name`, datefrom, dateto, ex_weeks, sessionID, unit_cost) 
values ('abc', '2014-1-1', '2014-2-2', 1, (select id from audit_session limit 0, 1), 34.5),
	('bcd', '2014-3-4', '2014-5-6', 0, (select id from audit_session limit 0, 1), 56.3),
	('abc', '2014-1-1', '2014-2-2', 1, (select id from audit_session limit 1, 1), 44.13),
	('bcd', '2014-3-4', '2014-5-6', 0, (select id from audit_session limit 1, 1), 66.43);


SELECT * FROM `audit_transaction` as t inner join `audit_session` as s on t.sessionID = s.id order by s.trans_date desc;

update audit_session set trans_date = '2014-07-24 00:00:00' where id = 2;
alter table audit_transaction drop column shared_fare;
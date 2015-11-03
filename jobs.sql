DROP TABLE IF EXISTS categories; 
CREATE TABLE categories (
cat_id int(11) NOT NULL AUTO_INCREMENT,
cat_name varchar(25) NOT NULL,
PRIMARY KEY (cat_id)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO categories VALUES (1,'IT'),(2,'Legal'),(3,'Management'),(4,'Purchasing');

DROP TABLE IF EXISTS ci_sessions; 
CREATE TABLE ci_sessions (
session_id varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
ip_address varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
user_agent varchar(120) COLLATE utf8_bin DEFAULT NULL,
last_activity int(10) unsigned NOT NULL DEFAULT '0',
user_data text COLLATE utf8_bin NOT NULL 
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS jobs;
CREATE TABLE jobs (
	job_id int(11) NOT NULL AUTO_INCREMENT,
    job_title varchar(50) NOT NULL,
    job_desc text NOT NULL, 
    cat_id int(11) NOT NULL,
    type_id int(11) NOT NULL,
    loc_id int(11) NOT NULL,
    job_start_date datetime NOT NULL,
    job_rate int(5) NOT NULL,
    job_advertiser_name varchar(50) NOT NULL,
    job_advertiser_email varchar(50) NOT NULL,
    job_advertiser_phone varchar(20) NOT NULL,
    job_sunset_date datetime NOT NULL,
    job_created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (job_id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO jobs VALUES (1,'PHP Developer','PHP Developer required for a large agency based in London. Must have MVC experience\n', 1,1,1,'2014-09-24 00:00:00', 400,'Rob Foster','rob@bluesuncreative.com','01234123456','2015-09-26 00:00:00','2014-09-17 09:00:18'),(2,'CodeIgniter Developer','Small London agency urgently requires a CodeIgniter developer to work on small eCommerce project.', 1,1,1,'0000-00-00 00:00:00', 350,'Lucy','lucy@londonagencycomain.com','01234123456','2015-09-26 00:00:00','2014-09-17 11:22:19'),(3,'Flash Developer','Paris based agency requires Flash Developer to work on new built project', 1,1,2,'0000-00-00 00:00:00', 350,'Brian','brian@frenchdesignagenct.fr','01234123456','2015-09-26 00:00:00',' 2014-09-17 11:23:39'); 

DROP TABLE IF EXISTS locations; 

CREATE TABLE locations (
	loc_id int(11) NOT NULL AUTO_INCREMENT,
	loc_name varchar(25) NOT NULL,
	PRIMARY KEY (loc_id)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO locations VALUES (1,'England'),(2,'France'),(3,'Germany'),(4,'Spain');

DROP TABLE IF EXISTS types;

CREATE TABLE types (
	type_id int(11) NOT NULL AUTO_INCREMENT,
	type_name varchar(25) NOT NULL,
	PRIMARY KEY (type_id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO types VALUES (1,'Contract'),(2,'Full Time'),(3,'Part Time');


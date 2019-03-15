# Don't commit to master
Web App Dev Project Repo


Have a look at the project board for current progress:
<a href="https://github.com/braydend/cois-3420-group4-project/projects/2">Check-in Two</a>


# SQL Database
Use the following query to create the database locally. Feel free to improve on the query
```
CREATE TABLE `movies` (
 `id` int(5) NOT NULL AUTO_INCREMENT,
 `title` varchar(20) DEFAULT NULL,
 `stars` int(11) DEFAULT NULL,
 `genre` varchar(40) DEFAULT NULL,
 `m_rating` varchar(5) DEFAULT NULL,
 `year` varchar(4) DEFAULT NULL,
 `runtime` varchar(40) DEFAULT NULL,
 `theatre_release` varchar(10) DEFAULT NULL,
 `dvd_release` varchar(10) DEFAULT NULL,
 `actors` varchar(20) DEFAULT NULL,
 `studio` varchar(10) DEFAULT NULL,
 `summary` varchar(20) DEFAULT NULL,
 `format` varchar(10) DEFAULT NULL,
 `bluray` char(2) DEFAULT NULL,
 `4kdisk` char(2) DEFAULT NULL,
 `sd` char(2) DEFAULT NULL,
 `hd` char(2) DEFAULT NULL,
 `4kdig` char(2) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1
```

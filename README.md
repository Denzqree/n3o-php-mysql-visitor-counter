# n3o-php-mysql-visitor-counter
A PHP &amp; MySQL Visitor Counter by n3o_

I am delighted to bring you this Visitor Counter, based on PHP &amp; MYSQL.

It works by allowing the website owner to count the visits, where every visit
has a persisting duration of 12 hours, so it doesn't flood the count.

The rest is pretty much self-explanatory ^.^


--------------------------------------------------------------------------------------------------

Notes :

This is how you should create the table in your database :
CREATE TABLE visitors( ip INT(10) UNSIGNED PRIMARY KEY, visit INT(15) DEFAULT 0 , timestamp TIME);

Current version supports only IPv4.
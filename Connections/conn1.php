<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conn1 = "localhost";
$database_conn1 = "casterly_rock";
$username_conn1 = "root";
$password_conn1 = "";
$conn1 = mysql_pconnect($hostname_conn1, $username_conn1, $password_conn1) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
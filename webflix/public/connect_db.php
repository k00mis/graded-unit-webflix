<?php # CONNECT TO MySQL DATABASE.
# The arguments for mysqli_connect are in the following format:
# '[server name]','[username for database]','[password for database]','[name of database]'
# Connect to college server's db with:
# 'localhost','HNDSOFTS2A8','BSoEExqxv9','HNDSOFTS2A8'
# Connect to db for my private MAMP server with:
# 'localhost','root','root','webflix'
$link = mysqli_connect('localhost','root','root','webflix');
if (!$link){ 
	# Otherwise will fail and explain the error
	die('Could not connect to MySQL: ' . mysqli_error());
}

?>
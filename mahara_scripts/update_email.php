<?php
/**
* Place this script in MAHARA_DIR/htdocs/admin/cli
* Access via browser is not allowed
**/
define('INTERNAL', 1);
define('CLI', 1);
if (!isset($argv[1]) || !isset($argv[2]))
{
	printf("Missing arguments. Use of this script:\n\t php mahara/htdocs/admin/cli/update_email.php currentemail@example.com newemail@example.com\n") ;
	exit(1);
}
require(dirname(dirname(dirname(__FILE__))) . '/init.php');
$email='Helloworld@email.dfg';
$newemail = "Helloworld@email.dfg";

$user = get_record('usr', 'email', $email);
if (!$user)
{
	echo 'User does not exist';
}else {
	echo $user->email;
	db_begin();
	if(update_record('usr', $user))
	{
		//set_user_primary_email($user->id, $values['email']);
		set_user_primary_email($user->id, $newemail);
		db_commit();
	}
}

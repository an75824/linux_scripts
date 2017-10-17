<?php
/**
* Place this script in MAHARA_DIR/htdocs/admin/cli
* Access via browser is not allowed
**/

define('INTERNAL', 1);
define('CLI', 1);
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

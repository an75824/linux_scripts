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

$current_email = $argv[1];
$new_email = sanitize_email($argv[2]);

$user = get_record('usr', 'email', $current_email);
if (!$user)
{
	exit("User with email '$current_email' does not exist.\nNothing to update.\n");
}

$user_id = $user->id;
remove_user_sessions($user_id); //log out user

if (!check_usr_new_email($new_email,$user_id))
{
	exit( "$new_email already exists in the 'usr' table\n");
}
if (!check_artefact_internal_email($new_email,$user_id))
{
	exit("$email already exists in the 'artefact_internal_profile_email' table\n");
}

update_email($new_email, $user);

function check_usr_new_email($email, $id)
{
	$result = record_exists_sql('SELECT id FROM usr WHERE deleted != 1 AND email = ? AND id != ?', array($email, $id));
	if (!$result)
	{
		return true; //this means that the there is not any user with this email
	} else {
		return false;
	}
}

function check_artefact_internal_email($email, $id)
{
	$result = record_exists_sql('SELECT owner FROM artefact_internal_profile_email WHERE email = ? AND owner != ?', array($email, $id));
	if (!$result)
	{
		return true; //this means that the there is not any user with this email
	} else {
		return false;
	}
}

function update_email($newemail,$userObj)
{
	db_begin();
	if(update_record('usr', $userObj))
	{
		set_user_primary_email($userObj->id, $newemail);
		db_commit();
		echo "User email successfully updated!\n";
	}
}

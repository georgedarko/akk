<?php
/**************************
 *
 * Database Configuration
 *
 * ********************************************************************/
/*$db_server_name="";
$db_user="";
$db_pass="";
$db_name = "";*/
$db_server_name="localhost";
$db_user="root";
$db_pass="";
$db_name = "akk";

define("entity","akk");
$encrypt_key="olympus";


/*************************
 *
 * Web Address
 *
* **********************************************************************/
$default_root="http://localhost/akk/";
//$default_root="http://www.creativehubonline.com/appraisal2";


/*************************
 *
 * Time Zone Set
 *
* **********************************************************************/
date_default_timezone_set("Africa/Accra");



/**************************
 *
 * Email Addresses Configuration
 *
 * ********************************************************************/
/*$mail_server="mail.sci-ficloud.com";
$developer_team_email="kofi.manful@sci-fiwebtech.com, delali.tsegah@sci-fiwebtech.com";
$sender_from="Creative Hub Appraisal System";
$sender_email="info@sci-ficloud.com";
$mail_user="info@sci-ficloud.com";
$mail_password="info";*/
$mail_server="127.0.0.1";
$developer_team_email="testaccount@localhost";
$sender_email="postmaster@localhost";
$sender_from="Creative Hub Appraisal System";
$mail_user="postmaster@localhost";
$mail_password="";



/**************************
 *
 * Page Names
 *
 * ********************************************************************/

$pt['query_icnirp']="Query Icnirp Values";



/**************************
 *
 * Error Messages
 *
 * ********************************************************************/


$messages['3']="Account has been disabled. Contact administrators for details";
$messages['5']="Error occured during login. Try again later";
$messages['6']="Email or password incorrect. Check and try again";
$messages['12']="Error uploading file. Contact site administrators";
$messages['15']="Error changing password. Contact site administrators";
$messages['16']="Old password incorrect. Check and try again";
$messages['17']="Password successfully changed.";
$messages['24']="An account with that email already exits. Use a different email address";
$messages['25a']="An error occured while processing request. Try again later";
$messages['25b']="An error occured while processing request. Contact site administrators";
$messages['27']="Signup Successful. Administrators will contact you soon.";
$messages['35a']="Error occured while confirm account. Try again later";
$messages['35b']="Error occured while confirm account. Contact site administrators";
$messages['36']="No account found. Contact Admin to create an account";
$messages['47']="New password has been emailed. Check your account and login.";
$messages['166']="You are not authorized to view this page.";
$messages['174']="Entry already exists";
$messages['175a']="Error adding data. Try again later";
$messages['175b']="Error adding data. Contact site administrators";
$messages['177']="Data added successfully";
$messages['185a']="Error saving changes. Try again later";
$messages['185b']="Error saving changes. Contact site administrators";
$messages['187']="Changes saved successfully";
$messages['194']="You cannot delete this record until you remove all the dependencies";
$messages['195a']="Error deleting data. Try again later";
$messages['195b']="Error deleting data. Contact site administrators";
$messages['197']="Data deleted successfully";
$messages['207']="Sign up successful. Administrators will contact you soon.";





/*$messages['3']="Account has been blocked. Contact Administrators for assistance.";
$messages['2']="Confirm your account to continue.";
$messages['5a']="Error while reading user info. Administrators have been notified.";
$messages['5b']="Error while reading user info. Contact Administrators for assistance.";
$messages['6']="Wrong email or password. Try again.";
$messages['12']="Error occured while uploading file. Contact Administrators if this happens again.";
$messages['15a']="Error while updating password. Administrators have been notified.";
$messages['15b']="Error while updating password. Contact Administrator for assistance.";
$messages['16']="Wrong old password. Try again.";
$messages['17']="Password successfully changed.";
$messages['120']="Missing record in database. Contact Administators for assistance.";
$messages['125a']="Error while reading from database. Administrators have been notified.";
$messages['125b']="Error while reading from database. Contact Administrators for assistance.";
$messages['165']="Session has expired. Login to continue.";
$messages['166']="You do not have permissions to access that page.";
$messages['174']="A record with that #-field-# already exists.";
$messages['177']="Data was successfully added.";
$messages['175a']="An error occured while trying to add. Administrators have been notified.";
$messages['175b']="An error occured while trying to add. Contact Administrators for assistance.";
$messages['184']="A record with that #-field-# already exists.";
$messages['187']="Changes were successfully saved.";
$messages['185a']="An error occured while saving changes. Administrators have been notified.";
$messages['185b']="An error occured while saving changes. Contact Administrators for assistance.";
$messages['197']="Data was successfully deleted.";
$messages['195a']="An error occured while trying to delete. Administrators have been notified.";
$messages['195b']="An error occured while trying to delete. Contact Administrators for assistance.";
$messages['48']="Error occured while trying to add admins to group. Try again later.";
$messages['48']="Error occured while trying to join group. Try again later.";
$messages['47']="Group successfully created!  Now invite your friends and family to join and play.";
$messages['46']="You are now a member of \"{$_SESSION['join_group']['group_name']}\"! The more members your group has the more points you can accumulate!  Invite your friends!";
$messages['45a']="System Error. Group not created. Try again later.";
$messages['45b']="System Error. Group not created. Please contact quizzinn at <a href='mailto:helpdesk@quizzinn.com'>helpdesk@quizzinn.com</a>.";
$messages['44']="Group not created because group name already exists!  Please contact quizzinn at <a href='mailto:helpdesk@quizzinn.com'>helpdesk@quizzinn.com</a>";
$messages['43']="You are no longer a member of this group";
$messages['42']="Group has been deleted.";
$messages['41']="Error occured while trying to delete group. Try again later.";
$messages['40']="Admins have been successfully added.";
$messages['37']="Password reset successful. An email with the password has been sent.";
$messages['35']="Password reset error. Try again later.";

$messages['775']="Your Message has been sent.";
$messages['776']="Errory trying to send message. Try again.";
$messages['255']="Congratulations {$_SESSION['sign_up']['first_name']} {$_SESSION['sign_up']['first_name']}, a message has been sent to your email. Confirm your account to start playing!";
$messages['355']="Welcome {$_SESSION['quizzinn_user']['first_name']} {$_SESSION['quizzinn_user']['last_name']}.";
$messages['455']="Go on start playing to begin <a href=''>earning points</a>!";
$messages['337']="Password reset successful. An email with your new password has been sent to your address.";
$messages['335']="Password reset error. Your information is incorrect.";
$messages['347']="Password successfully changed.";
$messages['345']="Error changing password. Administrators have been informed.";*/
?>
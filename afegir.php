<?php
session_start(); 

if (isset($_SESSION['username']))
{
	include "afegir.html";

}else{
	header('Location: login.php'); 	
}
// Log OUT
if(isset($_GET['logout']))	{
	session_destroy();
	header('Location: login.php');
}
if(isset($_POST['submit'])){

	$uid=$_POST['uid'];
	$ou = $_POST['ou'];
	$cn = $_POST['givenname']." ".$_POST['sn'];
	$sn = $_POST['sn'];
	$givenName = $_POST['givenname'];
	$title=$_POST['title'];
	$telephoneNumber=$_POST['telephonenumber'];
	$mobile = $_POST['mobile'];
	$postalAddress = $_POST['adres'];
	$description=$_POST['description'];
	$password=$_POST['password'];

	$ldaphost = "ldap://127.0.0.1";

	$ldapconn = ldap_connect($ldaphost);
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

	$bind = ldap_bind($ldapconn, "cn=admin,dc=fjeclot,dc=net", "fjeclot");

	$dn = 'uid='.$_POST['uid'].',ou='.$_POST['ou'].',dc=fjeclot,dc=net';
	
	
		$newUser['objectClass'][0] = 'top';
		$newUser['objectClass'][1] = 'person';
		$newUser['objectClass'][2]='organizationalPerson';
		$newUser['objectClass'][3]='inetOrgPerson';
		$newUser['objectClass'][4]='posixAccount';
		$newUser['objectClass'][5]='shadowAccount';
		$newUser['uid']=$uid;
		$newUser['cn']=$cn;
		$newUser['sn']=$sn;
		$newUser['givenName']=$givenName;
		$newUser['title']=$title;
		$newUser['telephoneNumber']=$telephoneNumber;
		$newUser['mobile']=$mobile;
		$newUser['postalAddress']=$postalAddress;
		$newUser['loginShell']="/bin/bash";
		$newUser['gidNumber']=$_POST['gidnumber'];
		$newUser['uidNumber']=$_POST['uidnumber'];
		$newUser['homeDirectory']="/home/$uid/";
		$newUser['description']=$description;
		$newUser['userPassword']=$password;
		
		if (!(ldap_add($ldapconn, $dn, $newUser))) {
			
			 header('Location: error.php?m=<div class="alert alert-danger" role="alert">ERROR EN LA INSERCIÓ DEL USUARI </div>');
	 }else{
		  header('Location: error.php?m=<div class="alert alert-success" role="alert">Inserció d\'usuari satisfactòria </div>');
		
	 }
	 // Tancant connexió
	ldap_close($ldaphost);
	}

?>

<?php
session_start(); 

if (isset($_SESSION['username']))
{
		include"borra.html";
	if(isset($_POST['eliminar'])){
	$ldaphost = "ldap://127.0.0.1";
	$ldapconn = ldap_connect($ldaphost)or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");

	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	$bind = ldap_bind($ldapconn, "cn=admin,dc=fjeclot,dc=net", "fjeclot");

	$ldapadmin= "cn=admin,dc=fjeclot,dc=net";  

	$dn = 'uid='.$_POST['uid'].',ou='.$_POST['ou'].',dc=fjeclot,dc=net';
	if (!(ldap_delete($ldapconn, "$dn"))) {
		header('Location: error.php?m=<div class="alert alert-danger" role="alert">Errr en l\'esborrament </div>');
	}else{
		header('Location: error.php?m=<div class="alert alert-success" role="alert">Esborrat correctament </div>');

	}}
}else{
	header('Location: login.php'); 	
}
// Log OUT
if(isset($_GET['logout']))	{
	session_destroy();
	header('Location: login.php');
}
?>

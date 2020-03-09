
<?php
session_start(); 
if( $_POST['login'] == 'admin' && isset($_POST['password']) )
{
	$ou = 'administrador';
	$uid='sysadmin';
	$ldaphost = "ldap://127.0.0.1";
	$ldaprdn  = 'uid='.trim($uid).',ou='.trim($ou).',dc=fjeclot,dc=net';
	$ldappass = trim($_POST['password']); 
	$ldapadmin= "cn=admin,dc=fjeclot,dc=net";  

	// Connectant-se al servidor openLDAP
	
	$ldapconn = ldap_connect($ldaphost) or die("No s'ha pogut establir una connexió amb el servidor openLDAP.");

	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	

	if ($ldapconn) {
		// Autenticant-se en el servidor openLDAP
		$ldapbind = ldap_bind($ldapconn, $ldapadmin, $ldappass);

		// Accedint a home.php
		if ($ldapbind) {
			$_SESSION['username'] = trim($_POST['login']);
			header('Location: home.php'); 		
		} else {
			 header('Location: error.php?m=<div class="alert alert-danger" role="alert">Error Contrasenya o usuari  </div>');
		}
	}
}else if($_POST['login'] != 'admin' && isset($_POST['password'])) {
	 header('Location: error.php?m=<div class="alert alert-danger" role="alert">Error Contrasenya o usuari  </div>');
	
}
include "login.html";
?>

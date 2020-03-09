<?php
session_start(); 

if (isset($_SESSION['username']))
{
	include"modifica.html";
}else{
	header('Location: login.php'); 	
}

if(isset($_GET['logout']))	{
	session_destroy();
	header('Location: login.php');
}

if(isset($_POST['submit'])){
    $ldaphost = "ldap://127.0.0.1";

	$ldapconn = ldap_connect($ldaphost);
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

    $bind = ldap_bind($ldapconn, "cn=admin,dc=fjeclot,dc=net", "fjeclot");
    $dn = 'uid='.$_POST['uid'].',ou='.$_POST['ou'].',dc=fjeclot,dc=net';

    if($_POST['gidnumber']!=null && $_POST['uidnumber']!=null){

        $newUser['gidNumber']=$_POST['gidnumber'];
		$newUser['uidNumber']=$_POST['uidnumber'];


        $result = ldap_modify($ldapconn, $dn,$newUser );
        if (true === $result) {
			
				 header('Location: error.php?m=<div class="alert alert-success" role="alert">Modificat correctamente!!  </div>');
            
        } else {
			
          header('Location: error.php?m=<div class="alert alert-danger" role="alert">ERROR! No s\'ha modificat correctament </div>');
        }

    }
    // Tancant connexió
	ldap_close($ldaphost);
}

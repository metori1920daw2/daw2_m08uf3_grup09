<?php
session_start(); 

if (isset($_SESSION['username']))
{
include"mostra.html";
}else{
	header('Location: login.php'); 	
}
// Log OUT
if(isset($_GET['logout']))	{
	session_destroy();
	header('Location: login.php');
}

?>

<?php
if (isset($_POST['login']))
{
	// Connexió amb el servidor openLDAP
	$ldaphost = "ldap://127.0.0.1";
	$ldapconn = ldap_connect($ldaphost) or die("Could not connect to LDAP server.");
	ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
	if ($ldapconn) {
		// Autenticació anònima al servidor openLDAP
		$ldapbind = ldap_bind($ldapconn);
		// Accedint a les dades
		if ($ldapbind) {
			$search = ldap_search($ldapconn, "dc=fjeclot,dc=net", "uid=".$_POST['login']);
			$info = ldap_get_entries($ldapconn, $search);
			if($info['count']==0){
				 header('Location: error.php?m=<div class="alert alert-danger" role="alert">ERROR! No es troba cap registra  amb aquestes </div>');

			}else{
			//Ara, visualitzarem algunes de les dades de l'usuari:
			for ($i=0; $i<$info["count"]; $i++)
			{
				echo " <div class='main'>";
					echo "<div  class='mx-auto' style='width: 500px; margin-top: 3%;'>";
					echo "uid: ".$info[$i]['uid'][0]."<br />";
					echo "Nom: ".$info[$i]["cn"][0]. "<br />";
					echo "Títol: ".$info[$i]["title"][0]. "<br />";
					echo "Telèfon fixe: ".$info[$i]["telephonenumber"][0]. "<br />";
					echo "Adreça postal: ".$info[$i]["postaladdress"][0]. "<br />";
					echo "Telèfon mòbil: ".$info[$i]["mobile"][0]. "<br />";
					echo "Descripció: ".$info[$i]["description"][0]. "<br />";
					echo "Home Directory: ".$info[$i]["homedirectory"][0]. "<br />";
					echo "Login Shell: ".$info[$i]["loginshell"][0]. "<br />";
					echo "GID Number: ".$info[$i]["gidnumber"][0]. "<br />";
					echo "UID Number: ".$info[$i]["uidnumber"][0]. "<br />";
					echo "</div>";
				echo "</div>";
			} 
		}
		} 
		else {
		
			 header('Location: error.php?m=<div class="alert alert-danger" role="alert">Error d\'autenticació!</div>');
		}
    }
  
 

}
  ?>

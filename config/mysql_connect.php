<?php
define('BDD_USER', 'obysky'); // Utilisateur accŽdant ˆ votre BDD
define('BDD_NAME', 'obysky'); // Le nom de votre BDD
define('BDD_HOST', 'mysql51-75.perso');
define('BDD_PASS', 'Gi4AwguP');

try {
// CONNECTION BBD
mysql_connect(BDD_HOST, BDD_USER, BDD_PASS);
mysql_select_db(BDD_NAME);
}catch (String $e) {
echo 'error : '.e;
}


?>
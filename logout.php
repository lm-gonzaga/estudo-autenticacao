<?php

session_start();
$token = md5(session_id());
if(isset($_GET['token']) && $_GET['token'] === $token) {
   // limpe tudo que for necessário na saída.
   // Eu geralmente não destruo a seção, mas invalido os dados da mesma
   // para evitar algum "necromancer" recuperar dados. Mas simplifiquemos:
   unset($_COOKIE['remember_user']); 
   setcookie('remember_user', null, -1, '/');
   session_destroy();
   header("location: index.php");
   exit();
} else {
   echo '<a href="logout.php?token='.$token.'>Confirmar logout</a>';
}
?>
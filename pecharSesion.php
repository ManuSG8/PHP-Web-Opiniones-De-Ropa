<?php

    session_start();
    
    if(!isset($_SESSION['marcadecontrol'])){
        session_regenerate_id(true);
        $_SESSION['marcadecontrol']= true;
    }

    $_SESSION = array();
    session_destroy();

    setcookie('idioma','', time() - 1800);

    header('Location: login.php');

?>
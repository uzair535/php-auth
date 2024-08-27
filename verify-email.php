<?php

session_start();
include 'include/database.php';
include 'include/constant.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = $conn->prepare("SELECT * FROM user WHERE token = ?");
    $query->bind_param("s", $token);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    if($user){

        $query = $conn->prepare("UPDATE user SET verify = 1 WHERE token = ?");
        $query->bind_param("s", $token);
        $query->execute();

        $_SESSION['user_id'] = $user['user_id'];

        redirect(SITEURL.'/profile.php');
    }else{
        redirect(SITEURL.'/index.php?action=sign-up&error=try-to-login-again');
    }
}

function redirect($url) {
    header('Location: '.$url);
    die();
}

?>
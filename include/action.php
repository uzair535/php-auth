<?php

session_start();
include 'database.php';
include 'constant.php';

if ($_POST['action'] == 'sign-up') {
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $address = $_POST['address'];
    $mobile = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if($_POST['password'] !== $_POST['confirm_password']){
        redirect(SITEURL.'/index.php?action=sign-up&error=confirm-password-does-not-match');
    }

    // check the user is exists or not
    $query = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    if($user){

        $query = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
        $query->bind_param("s", $user['user_id']);
        $query->execute();
        $result = $query->get_result();
        $detail = $result->fetch_assoc();

        if($detail['email'] == $_POST['email']){
            redirect(SITEURL.'/index.php?action=sign-up&error=email-already-exists');
        }

        redirect(SITEURL.'/index.php?action=sign-up&error=username-already-exists');
    }

    $token = md5(rand());

    $query = $conn->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $user_id = $query->insert_id;

    $query = $conn->prepare("INSERT INTO user (user_id, firstname, lastname, address, mobile, email, token) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param("issssss", $user_id, $firstname, $lastname, $address, $mobile, $email, $token);
    $query->execute();

    // Send email verification link
    $verification_link = SITEURL."/verify-email.php?token=$token";
    mail($email, "Verify Your Email", "Click this link to verify your email: $verification_link");

    redirect(SITEURL.'/index.php?action=sign-up&success=verification-email-send-successfully');

}else if($_POST['action'] == 'login'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    if($user){
        $query = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
        $query->bind_param("s", $user['user_id']);
        $query->execute();
        $result = $query->get_result();
        $details = $result->fetch_assoc();

        if($details && $details['verify'] == 0){
            redirect(SITEURL.'/index.php?action=login&error=verify-email-first');
        }else{
            $passcode = rand(100000, 999999);
            $_SESSION['passcode'] = $passcode;
            $_SESSION['user'] = $user['user_id'];
            mail($user['email'], "Your 2FA Code", "Your code is $passcode");

            redirect(SITEURL.'/index.php?action=2fa');
        }

    }else{
        redirect(SITEURL.'/index.php?action=login&error=user-not-found');
    }

}else if($_POST['action'] == '2fa'){
    if($_POST['code'] == $_SESSION['passcode']){
        $_SESSION['user_id'] = $_SESSION['user'];
        redirect(SITEURL.'/profile.php');
    }else{
        redirect(SITEURL.'/index.php?action=2fa&error=wrong-verification-code');
    }
}else if($_POST['action'] == 'logout'){
    session_destroy();
    redirect(SITEURL);
}

function redirect($url) {
    header('Location: '.$url);
    die();
}

?>
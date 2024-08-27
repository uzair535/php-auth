<?php

session_start();
include 'include/constant.php';
include 'include/database.php';

if(!isset($_SESSION['user_id'])){
	header('Location: '.SITEURL);
    die();
}

// get user data
$query = $conn->prepare("SELECT * FROM login WHERE user_id = ?");
$query->bind_param("s", $_SESSION['user_id']);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

$query = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$query->bind_param("s", $_SESSION['user_id']);
$query->execute();
$result = $query->get_result();
$detail = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login/Signup Form</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'>
  <link rel="stylesheet" href="assets/style.css">

</head>
<body>
	<div class="container" id="container" style="padding: 20px;">
		<h2>Hi <b><?php echo $user['username']; ?></b></h2>

        <table>
            <tr>
                <td>First Name</td>
                <td><?php echo isset($detail['firstname'])? $detail['firstname']: '---' ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo isset($detail['lastname'])? $detail['lastname']: '---' ?></td>
            </tr>
            <tr>
                <td>Mobile Number</td>
                <td><?php echo isset($detail['mobile'])? $detail['mobile']: '---' ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo isset($detail['email'])? $detail['email']: '---' ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><?php echo isset($detail['address'])? $detail['address']: '---' ?></td>
            </tr>
        </table>

        <form action="include/action.php" method="POST" class="logout">
            <input type="hidden" name="action" value="logout">
            <button>Logout</button>
        </form>
	</div>


	<script src="assets/script.js"></script>

</body>
</html>


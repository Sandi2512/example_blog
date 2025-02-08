<?php

require '../config/config.php';
$stmt=$pdo->prepare("DELETE FROM users Where id=".$_GET['id']);
$stmt->execute();
header('Location: user_details.php');
?> 
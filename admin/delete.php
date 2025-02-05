<?php

require '../config/config.php';
$stmt=$pdo->prepare("DELETE FROM posts Where id=".$_GET['id']);
$stmt->execute();
header('Location: index.php');
?> 
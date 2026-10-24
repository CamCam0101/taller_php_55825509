<?php
session_start();
unset($_SESSION['historial']);
unset($_SESSION['ultimo']);
header("Location: index.php");
exit;
<?php

session_start();
unset($_SESSION['user_id']);
unset($_SESSION['user_auth']);
session_destroy();
header('Location: login.php');
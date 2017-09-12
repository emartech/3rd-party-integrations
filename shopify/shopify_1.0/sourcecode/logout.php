<?php
require_once 'config.php';
unset($_SESSION['shop']);
session_destroy();
header('Location: ' . REDIRECT_URI);
<?php
session_start ();
if (!isset($_SESSION['inventory_refrig']))  {

include "login.php";
exit;
}
?>
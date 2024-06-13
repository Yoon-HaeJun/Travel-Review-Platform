<?php
session_start();
$_SESSION = array();
session_unset();
echo "<script>
        window.location.href = 'Main.php';
      </script>";
?>
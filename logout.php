<?php
session_start();
session_destroy();
setcookie("fullname", "", time() - 3600);
setcookie("id", "", time() - 3600);
setcookie("type", "", time() - 3600);
echo "<script>window.location.href='index.php'</script>";
?>
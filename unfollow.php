<html>
 <head>
 </head>
 <?php
   require("style/header.php");
   require("database.php");
   $con = connect();
   $stmt = $con->prepare("DELETE FROM UserFollows WHERE User1=? AND User2=?;");
   $stmt->bind_param('si', $_SESSION["id"], $_POST["id"]);
   $stmt->execute();
   header("Location: user.php?id='".$_SESSION["id"]."'"); 
 ?>
</html>

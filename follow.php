<html>
 <head>
 </head>
 <?php
   require("style/header.php");
   require("database.php");
   $con = connect();
   $stmt = $con->prepare("INSERT INTO UserFollows (`userID`, `eventID`) VALUES (?,?);");
   $stmt->bind_param('si', $_SESSION["id"], $_POST["id"]);
   $stmt->execute();
   header("Location: user.php?id='".$_GET["id"]."'"); 
 ?>
</html>

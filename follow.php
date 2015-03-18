<html>
 <head>
 </head>
 <?php
   require("style/header.php");
   require("database.php");
   $con = connect();
   echo $_POST['id'];
   $stmt = $con->prepare("INSERT INTO UserFollows (`user1`, `user2`) VALUES (?,?);");
   $stmt->bind_param('ss', $_SESSION["id"], $_POST["id"]);
   $stmt->execute();
   echo $_POST["id"];
   header("Location: user.php?id='".$_POST["id"]."'"); 
 ?>
</html>

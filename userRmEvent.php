<html>
 <head>
 </head>
 <?php
   require("style/header.php");
   require("database.php");
   $con = connect();
   $stmt = $con->prepare("DELETE FROM UserEvents WHERE UserID=?
                          AND EventID=?;");
   $stmt->bind_param('si', $_SESSION["id"], $_POST["id"]);
   echo "Hello:" .$_SESSION["id"]. " " . $_POST["id"];
   $stmt->execute();
   echo "It is dun.";
   header("Location: user.php?id='".$_SESSION["id"]."'"); 
 ?>
</html>

<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <!-- Easy import of header -->
  <?php require("style/header.php");
        require("database.php");
  ?>
 <!--Form to allow manual setting of postcode 
     uses POST. I find this strangely satisfying
 -->
 <div class="row">
 <form action="index.php" method="post" name="form" class="eventForm">
  <div class="col s6">
   <div class="input-field">
     <label for="postcode">Your Postcode</label>
     <input type="text" name="postcode"></input>
   </div>
 </div>
 <div class="col s2">
   <button type="button" onclick=subcheckPostcode() class="btn waves-effect waves-light">
     Submit
     <i class="mdi-content-send right"></i>
   </button>
  </div>
 </form>
 </div>
 <?php require("style/footer.php"); ?>
 </body>
 <script src="js/common.js">
 </script>
 <script>
   function subcheckPostcode() {
     if (checkPostcode(document.getElementsByName("postcode")[0].value))
       document.getElementsByName("form")[0].submit();
     else 
       toast("Invalid postcode!", 4000);
   }
 </script>
</html>

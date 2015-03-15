<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <!-- Easy import of header -->
  <?php require("style/header.php"); ?>
  <h1>Logged in!</h1>
  <h2>You will be redirected in <span id="counter">5</span> second(s).</h2>
  <h3>If you don't get redirected, <a href="index.php">Click here</a></h3>
 </body>
 <script type="text/javascript">
function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML)==0) {
        window.location = 'index.php';
    }
    i.innerHTML = parseInt(i.innerHTML)-1;
}
setInterval(function(){ countdown(); },1000);
</script>
</html>

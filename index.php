<!DOCTYPE html>
<html lang="en">
<head>
  <title>Eventify</title>

  <!-- CSS  -->
<?php require ("style/linkcss.php"); 
      require ("database.php"); ?>
</head>
<body>
 <?php require ("style/header.php"); ?>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center blue-text">Welcome to Eventify!</h1>
        <div class="row center">
          <h5 class="header col s12 light">An easy-to-use collection of event from all over UK</h5>
        </div>
        <div class="row center">
          <a href="chooselogin.php" id="download-button" class="btn-large waves-effect waves-light blue">Getting started!</a>
        </div>
        <br>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Liverpool</h4>
            <p class="center light">Liverpool’s famous attractions include the Albert Dock, the UK’s oldest Chinatown, St. George’s Hall, the Walker Art Gallery and a Beatles-themed museum.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=71409503111" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Manchester</h4>

            <p class="center light">There is more to Manchester than football, music and rain. As the world’s first industrial city Manchester has a rich history and had a big impact on shaping the world we live in today.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=71409503111" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Sheffield</h4>

            <p class="center light">The Sheffield Ski Village is one of the largest artificial ski resorts in Europe. The city also has the largest theatre complex outside London and is the home of many electronic rock groups.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=71409503111" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br>
</div>


  </body>
<?php require ("style/footer.php"); ?>
</html>

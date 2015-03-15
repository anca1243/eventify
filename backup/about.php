<html>
  <head>
    <title>About</title>
    <?php require("style/linkcss.php"); ?>
  </head>

  <body>
    <?php require("style/header.php"); ?>
    <h1>About page</h1>
    <h3>What is Eventify?</h3>
    <p>Eventify is a web service for finding and creating events. Currently in operates
       with Manchester City Council data, but technikally it is possible to create 
       an event going anywhere in UK.</p>
    <p>It is also a group progect of group X2</p>
    <h3>How to use Eventify?</h3>
    <p>Eventify is still a work-in-progress web service, but it's main features are already
       available:</p>
    <ul>
      <li>To log into the system using your Facebook account, click on "Log in" button</li>
      <li>To search for events, click on "Search" button. Searching without any parameters
          results in displaying all available events</li>
      <li>To create events, click on the "Add event" button. Only logged-in user can do it,
          though</li>
      <li>To return to the main page, click on the "Home" button or on "Eventify" logo.</li>
      <li>To get back to this page, click "About" link at the bottom of each page.</li>
    </ul>
    <h3>How was this masterpiece created?</h3>
    <h>This site is workin on PHP5, HTML5 and MySQL. Web server is provided by the University
       of Manchester.</p>
    <?php require("style/footer.php"); ?>
  </body>
</html>

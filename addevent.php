<html>
  <head>
   <title> Add Event </title>
   <?php require("style/linkcss.php"); ?>
  </head>
  <body>
   <?php require("style/header.php"); ?>
   <h1>Add event</h1>
   <div id="createEventForm">
    <form id="eventInfo" method="post" action="createEvent.php">
     <div class="input-field">
       <label for="evtitle">Event Title</label>
       <input type="text" id="evtitle" />
     </div>
      
     <div class="input-field">
      <label for="evdescription">Event Description</label>
      <input type="text" id="evdescription" />
     </div>

     <div class="input-field">
      <label for="evlocation">Event Location:</label>
      <input type="text" id="evlocation" />
     </div>

     <div class="input-field">
      <label for="evpostcode">Event Postcode:</label>
      <input type="text" id="evpostcode" /> 
     </div>
   
     <button class="btn waves-effect waves-light"  
             type="submit" name="action">Submit
             <i class="mdi-content-send right"></i>
     </button>
    </form>
   </div>
  </body>
</html>

<html>
  <head>
   <title> Add Event </title>
   <?php require("style/linkcss.php"); ?>

   <script>    
    //Check if all boxes are filled in
    function isFormFilled() {
      var filled = false;
      //Check each part, bit by bit
      if (document.getElementsByName("evtitle")[0].value != "")
        if (document.getElementsByName("evdescription")[0].value != "") 
          if (document.getElementsByName("evlocation")[0].value != "") 
            if (document.getElementsByName("evpostcode")[0].value != "")
              if (document.getElementsByName("evsdate")[0].value != "")
                if (document.getElementsByName("evedate")[0].value != "")
                  filled = true;     
      //Check if the user's input on postcode is valid
      if (!checkPostcode(document.getElementsByName("evpostcode")[0].value)) {
		filled = false;
		toast("Invalid postcode!");
      }
      //if so, submit the form
      if (filled) {
        document.getElementById("eventInfo").action = "createEvent.php"
        document.getElementById("eventInfo").submit();
      } else {
	//Otherwise, alert them to their shortcomings in form-filling 
        toast("Please fill in all boxes to submit",4000);
      }
    }
  
   </script>
   <script src="js/common.js">
 </script>
  </head>
  <body>
   <?php require("style/header.php"); ?>
   <!-- Init the datepicker thingy --> 
   <script>
     $(function() {
      $( ".datepicker" ).pickadate();
     });
   </script>  
  <div id="content">
   <?php
     //Only logged in users can add events
     if (isset($_SESSION['session'])) {
       echo "<h1>Add event</h1>
             <!-- Add event form, posts to createEvent.php -->
             <div id=\"createEventForm\" class=\"eventform\">
              <form id=\"eventInfo\" action=\"#\" method=\"post\">
              <div class=\"input-field\">
               <label for=\"evtitle\">Event Title</label>
               <input type=\"text\" name=\"evtitle\" />
              </div>
      
             <div class=\"input-field\">
              <label for=\"evdescription\">Event Description</label>
              <input type=\"text\" name=\"evdescription\" />
             </div>

             <div class=\"input-field\">
              <label for=\"evsdate\">Start Date</label>
              <input type=\"text\" class=\"datepicker\" name=\"evsdate\" />
             </div>

             <div class=\"input-field\">
              <label for=\"evedate\">End Date</label>
              <input type=\"text\" class=\"datepicker\" name=\"evedate\" />
             </div>

             <div class=\"input-field\">
              <label for=\"evlocation\">Event Location:</label>
              <input type=\"text\" name=\"evlocation\" />
             </div>

            <div class=\"input-field\">
             <label for=\"evpostcode\">Event Postcode:</label>
             <input type=\"text\" name=\"evpostcode\" /> 
            </div>
   
           <button type=\"button\" class=\"btn waves-effect waves-light\"  
            onclick=\"isFormFilled()\">Submit
            <i class=\"mdi-content-send right\"></i>
         </button>
       </form>
      </div>";
     } else {
       echo "<h2>You must be logged in to do that</h2>";
     }
     ?>
  </div>
  <?php require("style/footer.php"); ?>
  </body>
</html>

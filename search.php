<html>
  <head>
    <title>Event search</title>
    <?php require("style/linkcss.php"); ?>
  </head>

  <body>
    <?php require("style/header.php"); ?>
    <div id="content">
      <h1>Search Events</h1>
      <div id="searchForm" class="eventForm">
        <form id="search" action="searchResults.php" method="get">
          <div class="input-field">
            <label for="evtitle">Name of Event</label>
            <input type="text" name="evtitle" />
          </div>
         
         <div class="input-field">
           <label for="evdesc">Additional Search Terms</label>
           <input type="text" name="evdesc" />
         </div>
 
         <div class="input-field">
           <label for="evdate">Date</label>
           <input type="text" class="datepicker" name="evdate" />
         </div>

         <div class="input-field">
           <label for="evpostcode">Event Postcode</label>
           <input type="text" name="evpostcode" /> 
        </div>
   
        <button type="submit" class="btn waves-effect waves-light">
             Search
             <i class="mdi-content-send right"></i>
        </button>
      </form>
      </div>    
    </div>
  </body>

  <script>
     $(function() {
      $( ".datepicker" ).pickadate();
     });
 </script>

</html>

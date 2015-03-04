<html>
  <head>
    <title>Event search</title>
    <?php require("style/linkcss.php"); ?>
  </head>

  <body>
    <?php require("style/header.php");
          require("database.php"); 
    ?>
    <div id="content">
      <div class="row">
        <h1>Search Events</h1>
      </div>
      <div class="row">
       <div class="col s3">
        <div id="searchForm" class="eventForm">
         <form id="search" action="search.php" method="get">
          <div class="input-field">
            <label for="evtitle">Name of Event</label>
            <input type="text" name="evtitle" value='<?php echo $_GET['evtitle'] ?>' />
          </div>
         
          <div class="input-field">
           <label for="evdesc">Additional Search Terms</label>
           <input type="text" name="evdesc" value='<?php echo $_GET['evdesc'] ?>' />
          </div>
 
          <div class="input-field">
           <label for="evdate">Date</label>
           <input type="text" class="datepicker" name="evdate" value='<?php echo $_GET['evdate'] ?>' />
          </div>

          <div class="input-field">
           <label for="evpostcode">Event Postcode</label>
           <input type="text" name="evpostcode" value='<?php echo $_GET['evpostcode'] ?>'/> 
          </div>
	
	  <div class="input-field">
	   <label for="maxdist">Maximum Distance (mi)</label>
	   <input type="text" name="maxdist" value='<?php echo $_GET['maxdist'] ?>'/>
	  </div>
   
          <button type="submit" class="btn waves-effect waves-light">
             Search
             <i class="mdi-content-send right"></i>
          </button>
         </form>
        </div> <!-- End of form div -->
       </div> <!-- End of search terms columns -->
      <div class="col s8">
       <?php
        //Retrieve vars
        $name = $_GET['evtitle'];
        $date  = $_GET['evdate'];
        $post  = $_GET['evpostcode'];
        //For the database
        $description=$_GET['evdesc'];
	$maxdist = $_GET['maxdist'];
        $location="";
        $results = search_events($name, $location, $date, $description, $post,$maxdist, "");
        displayResults($results);
       ?>
      </div>  
     </div> <!-- End of results -->   
    </div>
  <?php require("style/footer.php"); ?>
  </body>

  <script>
     $(function() {
      $( ".datepicker" ).pickadate();
     });
 </script>

</html>

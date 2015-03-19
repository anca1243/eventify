</main>
<footer class="page-footer blue">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">About Us</h5>
          <p class="grey-text text-lighten-4">We are simply the best team in the world.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="about.php">About</a></li>
          </ul>
        </div>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by Group X2
      </div>
    </div>
  </footer>
</body>
   <!--  Scripts-->
   <!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>-->
  <script src="js/jquery-1.11.2.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
  <script>
     $(function() {
      $( ".datepicker" ).pickadate();
     });
      $(document).ready(function() {
       $('select').material_select();
       $("table") 
       .tablesorter({widthFixed: true, widgets: ['zebra']}) 
       .tablesorterPager({container: $(".pager")});
       $('.collapsible').collapsible({
        accordion : false }
       );
     });
 </script>
 <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="js/jquery.browser.js"></script>

  <script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
</html>

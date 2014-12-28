<div id="push"></div>
</div>
    <div id="footer">
      <div class="container">
		<p class="muted credit" id="footerline"></br>This website requires javascript.</p>
      </div>
    </div>

    <script type="text/javascript" src="./static/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="./static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./static/js/jquery.appear.js"></script>
    <script type="text/javascript" src="./static/js/checkSearchBar.js"></script>
    <script src="./static/js/video.js" type="text/javascript"></script>
	<script src="./static/js/jquery.tinyscrollbar.min.js" type="text/javascript"></script>
	<script src="./static/js/magor.js" type="text/javascript"></script>
    <script src="./static/js/magor-player.js" type="text/javascript"></script>
    <script src="./static/js/magor-filter.js" type="text/javascript"></script>        
    

    <script type="text/javascript">
    $(document).ready(function() {
      //activate video player tooltips
      $(".control-btn").tooltip({ 'placement': 'top', 'container': 'body' });

      //handling the affix effect of column1
      var navbarHeight = $('.navbar').height();

      $(document).scroll(function(){
        var startAffixAt = $('.document-title').position().top + $('.document-title').height() + 50;
        var scroll = $(document).scrollTop();
        if (scroll >= startAffixAt) {
          if (!$('.column1').hasClass('affix'))
            $('.column1').addClass('affix').css({ top: $('.navbar').height() + 20 });
          }
          else {
            $('.column1').removeClass('affix');
          }
        });


        <?php	echo "var segments = [" ;
        foreach($printScript as $key => $value){
          foreach ($printScript[$key]['table']  as $line){
            echo 'new magor.Segment('. $line."),\n" ;
          }
        }
        echo "];" 	;
        ?>

        //var matches = [40653, 40654, 40655, 40658, 40659, 40660, 40661, 40663, 40668, 40670, 40672, 40698, ];
        var matches = [0, 4, 6];

        magor.magorPlayer = new magor.MagorPlayer(segments);
        magor.magorPlayer.highlightMatches(matches);


      });
      </script>



</body>
</html>

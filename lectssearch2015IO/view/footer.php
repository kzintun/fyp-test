<!--
 * The MIT License (MIT)
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author Ong Jia Hui (c) 2015
-->
<div id="push"></div>
</div>
    <div id="footer">
      <div class="container">
		<p class="muted credit" id="footerline"></br>This website requires javascript.</p>
      </div>
    </div>
	   <script src="./static/js/jquery-1.8.0.min.js" type='text/javascript'></script>
    <!--<script type="text/javascript" src="./static/js/jquery-1.10.2.min.js"></script>-->
    <script type="text/javascript" src="./static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./static/js/jquery.appear.js"></script>
    <!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>-->
    
    <script type="text/javascript" src="./static/js/jquery.xmltree.plugin.2.0.js"></script>
    
  <script type="text/javascript" src="./static/js/jquery.dotdotdot.min.js"></script>
	<!--<script src="./static/js/jquery.tinyscrollbar.min.js" type="text/javascript"></script>-->
  <script type="text/javascript" src="./static/js/jquery.updatetree.js"></script>
  <!--<script type="text/javascript" src="./static/js/jquery.clearicon.js"></script>-->

  <script type="text/javascript" src="./static/js/jquery-ui.js"></script>
  <script src="./static/js/ajaxSearch.js"></script>
  <script type="text/javascript" src="./static/js/platform.js"></script>
  <script type="text/javascript" src="./static/js/webspeech.js"></script>
  <script>
      if (!('webkitSpeechRecognition' in window)) {
          start_button.style.visibility = 'hidden';
      }
       var listener = new AudioListener();
       function listen() {
         
            listener.listen("en", function(text) {
              console.log(text);
                document.getElementById("userSearchInput").value = text;
                if (text.indexOf("go") !== -1) {

                  if (text.indexOf("signal processing") !== -1) {
                    document.getElementById("db_signalprocessing").click();
                  }
                  else if (text.indexOf("aerospace") !== -1) {
                    document.getElementById("db_aerospace").click();
                  //document.getElementById("searchBtn").click();
                  }
                  else if (text.indexOf("tedtalk") !== -1) {
                    document.getElementById("db_tedtalk").click();
                  }
                }
                if (text.indexOf("search") !== -1) {
                  
                  text = text.replace(/search/, '');
                  text = text.trim();
                  document.getElementById("userSearchInput").value = text;
                  document.getElementById("searchBtn").click();
                }
                console.log("searching".text);
            });
        }
  </script>
  <!-- <script src="./static/js/imgRedirect.js"></script>-->




</body>
</html>

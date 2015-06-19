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
 * @author Benjamin Bigot (c) 2013
 * @author Ong Jia Hui (c) 2015
-->
<?php include_once('header.php'); ?>
<div class="container">
	<div class="rowa">
			<!-- LEFT SIDE-->
			<div class="col-lg-3">
				<div class="well" >
					<div id="xmlMenuTree"></div>
				</div>
			</div>
			<?php if (isset($suggestionMsg)) {?>
			<div class="col-lg-7 col-lg-offset-1 alert alert-warning" role="alert"><?php echo $suggestionMsg?></div>
			<?php } ?>
			<div class="col-lg-7 col-lg-offset-1">
				<p style="color:white"><?php echo $errorMessage  ?></p>
			</div>
	</div>
</div>

<?php include_once('footer.php'); ?>

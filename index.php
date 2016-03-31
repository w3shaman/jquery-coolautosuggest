<!DOCTYPE html>
<html>
<head>
	<title>jQuery Cool Auto-Suggest</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/jquery.coolautosuggest.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.coolautosuggest.css" />
</head>
<body>
	<h1>jQuery Cool Auto-Suggest</h1>
	<br/><br/>
	<fieldset id="fieldset1">
		<legend><b>Classic Style</b></legend>
		<div>
			<form>
				<p>The classic style of auto-suggest. It takes just one parameter, the URL to retrieve the data.</p>
				Public figure name : <input type="text" name="text1" id="text1" />
				<script language="javascript" type="text/javascript">
					$("#text1").coolautosuggest({
						url:"data.php?chars=",
					});
				</script>
				<p>The code :</p>
<pre>
$("#text1").coolautosuggest({
	url:"data.php?chars="
});
</pre>
			</form>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset2">
		<legend><b>Using ID Field</b></legend>
		<div>
			<form>
				<p>The auto-suggest can also return an ID. You just need to prepare the input element for storing it and then pass one additional parameter, <b>idField</b>.</p>
				Public figure name : <input type="text" name="text2" id="text2" /> ID : <input type="text" name="text2_id" id="text2_id" size="5" />
				<script language="javascript" type="text/javascript">
					$("#text2").coolautosuggest({
						url:"data.php?chars=",
						idField:$("#text2_id")
					});
				</script>
				<p>The code :</p>
<pre>
$("#text2").coolautosuggest({
	url:"data.php?chars=",
	idField:$("#text2_id")
});
</pre>
			</form>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset3">
		<legend><b>Image Thumbnail And Additional Description</b></legend>
		<div>
			<form>
				<p>The auto-suggest can also display image thumbnail and additional description. You have to pass two additional parameters, <b>showThumbnail</b>, and <b>showDescription</b> and then set their value to <b>true</b>.</p>
				Public figure name : <input type="text" name="text3" id="text3" />
				<script language="javascript" type="text/javascript">
					$("#text3").coolautosuggest({
						url:"data.php?chars=",
						showThumbnail:true,
						showDescription:true
					});
				</script>
				<p>The code :</p>
<pre>
$("#text3").coolautosuggest({
	url:"data.php?chars=",
	showThumbnail:true,
	showDescription:true
});
</pre>
				<br/>
				<b><i>Note :</i></b>
				<p><i>Image thumbnail's width and height can be set from the CSS file.<br/>For a better appearance, I recommend that all images must have the same width and height.</i></p>
			</form>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset4">
		<legend><b>Other Options</b></legend>
		<div>
			<form>
				<p>These are the other usefull parameters which you can use. Here they are.</p>
				<ul>
					<li><b>width</b>. Basically, the width will be automatically adjusted to textfield's width. By using this parameter, you can customize the auto-suggest width to suit your need.</li>
					<li><b>minChars</b>. By default, the auto-suggest will appear if you type the first letter. You can set the number characters typed to trigger the auto-suggest to appear by using this parameter.</li>
					<li><b>submitOnSelect</b>. By setting this parameter value to <b>true</b>, the form will be submitted once you click one of the item in the auto-suggest list.</li>
				</ul>
				Public figure name : <input type="text" name="text4" id="text4" /> ID : <input type="text" name="text4_id" id="text4_id" size="5" />
				<script language="javascript" type="text/javascript">
					$("#text4").coolautosuggest({
						url:"data.php?chars=",
						showThumbnail:true,
						showDescription:true,
						idField:$("#text4_id"),
						width:300,
						minChars:2,
						submitOnSelect:true
					});
				</script>
				<p>The code :</p>
<pre>
$("#text4").coolautosuggest({
	url:"data.php?chars=",
	showThumbnail:true,
	showDescription:true,
	idField:$("#text4_id"),
	width:300,
	minChars:2,
	submitOnSelect:true
});
</pre>
			</form>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset5">
	  <legend><b>Callback Function</b></legend>
		<div>
			<form>
				<p>For this new version, you can use one callback function which can be used via <b>onSelected</b> parameter. This callback function will be executed when you made a selection on one item (by clicking it or pressing 'Enter'). By using this callback feature you can retrieve the selected object to be used later in your code.</p>
				Public figure name : <input type="text" name="text5" id="text5" /><br/>
				ID : <input type="text" name="text5_id" id="text5_id" size="5" /><br/>
				Profession : <input type="text" name="text5_profession" id="text5_profession" /><br/>
				Picture :
				<div id="picture"></div>
				<script language="javascript" type="text/javascript">
					$("#text5").coolautosuggest({
						url:"data.php?chars=",
						showThumbnail:true,
						showDescription:true,
						onSelected:function(result){
						  // Check if the result is not null
						  if(result!=null){
						    $("#text5_id").val(result.id); // Get the ID field
						    $("#text5_profession").val(result.description); // Get the description
						    $("#picture").html('<img src="' + result.thumbnail + '" alt="" />'); // Get the picture thumbnail
						  }
						  else{
						    $("#text5_id").val(""); // Empty the ID field
						    $("#text5_profession").val(""); // Empty the description
						    $("#picture").html(''); // Empty the picture thumbnail
						  }
						}
					});
				</script>
				<p>Sample code :</p>
<pre>
$("#text5").coolautosuggest({
  url:"data.php?chars=",
  showThumbnail:true,
  showDescription:true,
  <i><b>onSelected</b>:function(result){
    // Check if the result is not null
    if(result!=null){
      $("#text5_id").val(result.id); // Get the ID field
      $("#text5_profession").val(result.description); // Get the description
      $("#picture").html('&lt;img src="' + result.thumbnail + '" alt="" /&gt;'); // Get the picture thumbnail
    }
    else{
      $("#text5_id").val(""); // Empty the ID field
      $("#text5_profession").val(""); // Empty the description
      $("#picture").html(''); // Empty the picture thumbnail
    }
  }</i>
});
</pre>
      <br/>
      <b><i>Note :</i></b>
      <p><i>This callback feature can also be used as the alternative to get the ID of the selected item and also submit the form after you made the selection.</i></p>
			</form>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset6">
		<legend><b>Server Side Script</b></legend>
		<div>
			<p>For the server side script which populate the auto-suggest data, you can use the code below. Please remember that the data is transferred in JSON format.</p>
<pre class="php" style="font-family:monospace;"><span style="color: #0000BB">&lt;?php<br />header</span><span style="color: #007700">(</span><span style="color: #DD0000">"Cache-Control: no-cache, must-revalidate"</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">header</span><span style="color: #007700">(</span><span style="color: #DD0000">"Expires: Mon, 26 Jul 1997 05:00:00 GMT"</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">header</span><span style="color: #007700">(</span><span style="color: #DD0000">"Content-type: application/json"</span><span style="color: #007700">);
<p></p></span><span style="color: #0000BB">$host</span><span style="color: #007700">=</span><span style="color: #DD0000">"localhost"</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$username</span><span style="color: #007700">=</span><span style="color: #DD0000">"test"</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$password</span><span style="color: #007700">=</span><span style="color: #DD0000">"123456"</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$database</span><span style="color: #007700">=</span><span style="color: #DD0000">"test"</span><span style="color: #007700">;
<p></p></span><span style="color: #0000BB">$con</span><span style="color: #007700">=</span><span style="color: #0000BB">mysqli_connect</span><span style="color: #007700">(</span><span style="color: #0000BB">$host</span><span style="color: #007700">,</span><span style="color: #0000BB">$username</span><span style="color: #007700">,</span><span style="color: #0000BB">$password</span><span style="color: #007700">,</span><span style="color: #0000BB">$database</span><span style="color: #007700">);
<p></p></span><span style="color: #0000BB">$arr</span><span style="color: #007700">=array();<br /></span><span style="color: #0000BB">$result</span><span style="color: #007700">=</span><span style="color: #0000BB">mysqli_query</span><span style="color: #007700">(</span><span style="color: #0000BB">$con</span><span style="color: #007700">,</span><span style="color: #DD0000">"SELECT * FROM people WHERE name LIKE '%"</span><span style="color: #007700">.</span><span style="color: #0000BB">mysqli_real_escape_string</span><span style="color: #007700">(</span><span style="color: #0000BB">$con</span><span style="color: #007700">,</span><span style="color: #0000BB">$_GET</span><span style="color: #007700">[</span><span style="color: #DD0000">'chars'</span><span style="color: #007700">]).</span><span style="color: #DD0000">"%' ORDER BY name LIMIT 0, 10"</span><span style="color: #007700">);<br />if(</span><span style="color: #0000BB">mysqli_num_rows</span><span style="color: #007700">(</span><span style="color: #0000BB">$result</span><span style="color: #007700">)&gt;</span><span style="color: #0000BB">0</span><span style="color: #007700">){<br />    while(</span><span style="color: #0000BB">$data</span><span style="color: #007700">=</span><span style="color: #0000BB">mysqli_fetch_row</span><span style="color: #007700">(</span><span style="color: #0000BB">$result</span><span style="color: #007700">)){<br />        </span><span style="color: #FF8000">// Store data in array <br />        // You can add any additional fields to be used by the autosuggest callback function <br />        </span><span style="color: #0000BB">$arr</span><span style="color: #007700">[]=array(<br />            </span><span style="color: #DD0000">"id" </span><span style="color: #007700">=&gt; </span><span style="color: #0000BB">$data</span><span style="color: #007700">[</span><span style="color: #0000BB">0</span><span style="color: #007700">],<br />            </span><span style="color: #DD0000">"data" </span><span style="color: #007700">=&gt; </span><span style="color: #0000BB">$data</span><span style="color: #007700">[</span><span style="color: #0000BB">1</span><span style="color: #007700">],<br />            </span><span style="color: #DD0000">"thumbnail" </span><span style="color: #007700">=&gt; </span><span style="color: #DD0000">'thumbnails/'</span><span style="color: #007700">.</span><span style="color: #0000BB">$data</span><span style="color: #007700">[</span><span style="color: #0000BB">3</span><span style="color: #007700">],<br />            </span><span style="color: #DD0000">"description" </span><span style="color: #007700">=&gt; </span><span style="color: #0000BB">$data</span><span style="color: #007700">[</span><span style="color: #0000BB">2</span><span style="color: #007700">],<br />            </span><span style="color: #FF8000">// Additional fields (if any)...<br />        </span><span style="color: #007700">);<br />    }<br />}
<p></p></span><span style="color: #0000BB">mysqli_close</span><span style="color: #007700">(</span><span style="color: #0000BB">$con</span><span style="color: #007700">);
<p></p></span><span style="color: #FF8000">// Encode it with JSON format<br /></span><span style="color: #007700">echo </span><span style="color: #0000BB">json_encode</span><span style="color: #007700">(</span><span style="color: #0000BB">$arr</span><span style="color: #007700">);<br /></span><span style="color: #0000BB">?&gt;</pre>
		</div>
	</fieldset>
</body>
</html>

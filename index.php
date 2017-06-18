<!DOCTYPE html>
<html>
<head>
	<title>jQuery Cool Auto-Suggest</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
				<table>
					<tr><td>Public figure name : </td><td><input type="text" name="text5" id="text5" /></td></tr>
					<tr><td>ID : </td><td><input type="text" name="text5_id" id="text5_id" size="5" /></td></tr>
					<tr><td>Profession : </td><td><input type="text" name="text5_profession" id="text5_profession" /></td></tr>
					<tr><td>Picture : </td><td><div id="picture"></div></td></tr>
				</table>
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
  <b>onSelected:function(result){
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
  }</b>
});
</pre>
      <br/>
      <b><i>Note :</i></b>
      <p><i>This callback feature can also be used as the alternative to get the ID of the selected item and also submit the form after you made the selection.</i></p>
			</form>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset7">
	  <legend><b>Additional Dynamic Query String</b></legend>
		<div>
			<form>
				<p>We can pass additional dynamic query string to the request URL. For the example, we may need to filter the autocomplete list based on the previously selected profession.</p>
				<table>
					<tr><td>Profession :</td><td>
						<select name="profession">
							<option value="Football player">Football player</option>
							<option value="Musician">Musician</option>
							<option value="Actor">Actor</option>
							<option value="Actress">Actress</option>
						</select></td></tr>
					<tr><td>Public figure name : </td><td><input type="text" name="text6" id="text6" /></td></tr>
					<tr><td>ID : </td><td><input type="text" name="text6_id" id="text6_id" size="5" /></td></tr>
					<tr><td>Picture : </td><td><div id="picture2"></div></td></tr>
				</table>
				<script language="javascript" type="text/javascript">
					$("#text6").coolautosuggest({
						url:"data.php?chars=",
						showThumbnail:true,
						showDescription:true,
						additionalFields:{
							"&profession=" : $("select[name=profession]") // We can use more than one criteria if needed.
						},
						onSelected:function(result){
						  // Check if the result is not null
						  if(result!=null){
						    $("#text6_id").val(result.id); // Get the ID field
						    $("#picture2").html('<img src="' + result.thumbnail + '" alt="" />'); // Get the picture thumbnail
						  }
						  else{
						    $("#text6_id").val(""); // Empty the ID field
						    $("#picture2").html(""); // Empty the picture thumbnail
						  }
						}
					});
				</script>
				<p>Sample code :</p>
<pre>
$("#text6").coolautosuggest({
  url:"data.php?chars=",
  showThumbnail:true,
  showDescription:true,
  <b>additionalFields:{
    "&amp;profession=" : $("select[name=profession]") // We can use more than one criteria if needed.
  }</b>,
  onSelected:function(result){
    // Check if the result is not null
    if(result!=null){
      $("#text6_id").val(result.id); // Get the ID field
      $("#picture").html('&lt;img src="' + result.thumbnail + '" alt="" /&gt;'); // Get the picture thumbnail
    }
    else{
      $("#text6_id").val(""); // Empty the ID field
      $("#picture").html(''); // Empty the picture thumbnail
    }
  }
});
</pre>
			<br/>
			<b><i>Note :</i></b>
			<p><i>The <b>additionalFields</b> should be in key value pair. The string we used for the key is flexible, it can be "&amp;profession=" or "/profession/" or anything depend on our needs.</i></p>
			</form>
		</div>
	</fieldset>
	<br/>
  <fieldset id="fieldset8">
	  <legend><b>Error Callback</b></legend>
		<div>
			<form>
				<p>We can also use custom error callback function to display custom error message when there is something wrong on the autocomplete process.</p>
				Public figure name : <input type="text" name="text7" id="text7" />
				<script language="javascript" type="text/javascript">
					$("#text7").coolautosuggest({
						url:"notfound.php?chars=", // We point to wrong URL to raise error.
						onError:function() {
							alert("Hey, it seems something error has happened.");
						}
					});
				</script>
				<p>Sample code :</p>
<pre>
$("#text7").coolautosuggest({
  url:"notfound.php?chars=", // We point to wrong URL to raise error.
  <b>onError:function() {
    alert("Hey, it seems something error has happened.");
  }</b>
});
</pre>
			</form>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset9">
		<legend><b>Before And After Request Callback</b></legend>
		<div>
			<p>By using this callback, we can display loading image when the autocomplete list is being populated the hide it when the list is completely populated. Of course there are other possibilities we can do using these callback functions.</p>
			<ul>
				<li><b>onRequest</b>. This parameter can be used to call a function before the AJAX request is sent.</li>
				<li><b>onComplete</b>. This parameter can be used to call a function after the AJAX request is completed.</li>
			</ul>
			Public figure name : <input type="text" name="text8" id="text8" /> <img src="images/loader.gif" id="loading8" style="display:none" /><br/>
			<i>* The loading indicator will appear when we are typing some letters.</i>
			<script language="javascript" type="text/javascript">
				$("#text8").coolautosuggest({
					url:"data.php?chars=",
					onRequest:function() {
						$("#loading8").show();
					},
					onComplete:function() {
						$("#loading8").hide();
					}
				});
			</script>
			<p>Sample code :</p>
<pre>
$("#text8").coolautosuggest({
  url:"data.php?chars=",
  <b>onRequest:function() {
    $("#loading8").show();
  },
  onComplete:function() {
    $("#loading8").hide();
  }</b>
});
</pre>
		</div>
	</fieldset>
	<br/>
	<fieldset id="fieldset6">
		<legend><b>Server Side Script</b></legend>
		<div>
			<p>For the server side script which populate the auto-suggest data, you can use the code below. Please remember that the data is transferred in JSON format.</p>
<pre>
&lt;?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: application/json");

$host="localhost";
$username="root";
$password="";
$database="test";

$con=mysqli_connect($host,$username,$password,$database);

$arr=array();

$profession = "";
if (isset($_GET['profession'])) {
    $profession = " AND description = '" . mysqli_real_escape_string($con, $_GET['profession']) . "' ";
}

$result=mysqli_query($con,"SELECT * FROM people WHERE name LIKE '%".mysqli_real_escape_string($con,$_GET['chars'])."%' " . $profession . " ORDER BY name LIMIT 0, 10");
if(mysqli_num_rows($result)&gt;0){
    while($data=mysqli_fetch_row($result)){
        // Store data in array
        // You can add any additional fields to be used by the autosuggest callback function
        $arr[]=array(
            "id" =&gt; $data[0],
            "data" =&gt; $data[1],
            "thumbnail" =&gt; 'thumbnails/'.$data[3],
            "description" =&gt; $data[2],
            // Additional fields (if any)...
        );
    }
}

mysqli_close($con);

// Encode it with JSON format
echo json_encode($arr);

</pre>
		<p>Or, you can use the PDO instead of mysqli_ like following.</p>
<pre>
&lt;?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: application/json");

$host="localhost";
$username="root";
$password="";
$database="test";

$db = new PDO("mysql:host=$host;dbname=$database" , $username , $password);

$arr = array();

$where = array();
$where[':name'] = '%' . $_GET['chars'] . '%';

$profession = "";
if (isset($_GET['profession'])) {
    $profession = " AND description = :description ";
    $where[':description'] = $_GET['profession'];
}

$sql = "SELECT * FROM people WHERE name LIKE :name " . $profession . " ORDER BY name LIMIT 0, 10";

$query = $db-&gt;prepare($sql, array(PDO::ATTR_CURSOR =&gt; PDO::CURSOR_FWDONLY));
$query-&gt;execute($where);

$result = $query-&gt;fetchAll();
if ($query-&gt;rowCount() &gt; 0) {
    foreach ($result as $data) {
        // Store data in array
        // You can add any additional fields to be used by the autosuggest callback function
        $arr[]=array(
            "id" =&gt; $data['id'],
            "data" =&gt; $data['name'],
            "thumbnail" =&gt; 'thumbnails/'.$data['photo'],
            "description" =&gt; $data['description'],
            // Additional fields (if any)...
        );
    }
}

// Close connection.
$db = null;

// Encode it with JSON format
echo json_encode($arr);

</pre>
		</div>
	</fieldset>
</body>
</html>

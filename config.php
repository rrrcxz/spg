<?php
session_start();
?>
<title>Software Process Generator</title>
<h1>Software Process Generator</h1>
<p>
	<b> Here is the configuration page of SPG
		<hr />
		<head>
<script src="js/jquery.js"></script>
		</head>
<?php
$admin = false;
if ($_SESSION["admin"] != true) {
    $_SESSION["admin"] = false;
    echo "<script>alert('Please Sign in!'); window.location.href='admin.html';</script>";
}
?>

<script>
  var paraName = ['func', 'adap', 'invo', 'docu', 'expe', 'tmode', 'sche', 'miti', 'psize', 'prot', 'pcross'];
  $(document).on('change', '#model', function() {
    var name = $("#model").val();
    if(name == "") {
      $("input[type='radio']").prop("checked", false);
      alert("Please select a mode!");
      return false;
    }
    
    $.ajax({
      type: 'POST',
      url: "query.php",
      datatype: 'json',
      data: {modelname: name}, 
      success: function(ret, s) {
        if(!('err' in ret)) {
          for(i = 0; i < paraName.length; i++) {
            if(paraName[i] in ret) {
              var ele = "input[name='" + paraName[i] +"'][value='" + ret[paraName[i]] + "']";
              $(ele).prop("checked", true);
            }
          }
        } else {
          $("input[type='radio']").prop("checked", false);
          alert("Error in DB query!");
        }
      }
    });
    return false;
  })

  function spgSet() {
    var name = $("#model").val();
    $.ajax({
      type: 'POST',
      url: 'update.php',
      data: $("#inputs").serialize(),
      success: function(ret, s) {
        if(ret == 0) {
          alert("Successfully configure " + name);
        } else {
          alert("Configure failed! Please re-check all parameters!");
        }
      }
    });
    return false;
  }

  function spgClearTally() {
    var c = confirm("Confirm to delete surveytally data between the date range");
    var year1 = $('#year1').val();
    var month1 = $('#month1').val();
    var date1 = $('#date1').val();
    var year2 = $('#year2').val();
    var month2 = $('#month2').val();
    var date2 = $('#date2').val();
    var start = year1+"-"+month1+"-"+date1;
	var end = year2+"-"+month2+"-"+date2;
    if(c == false) return;
    $.ajax({
      type: 'POST',
      url: 'statistic.php',
      datatype: 'json',
      data: {op: "clear", start:start, end:end},
      success: function(ret, s) {
         if('err' in ret) {
          alert("Failed!");
        } else {
          alert("Done!");
        }
      }
    });
    return false;
  }

  function spgStatistic() {
	  var year1 = $('#year1').val();
	  var month1 = $('#month1').val();
	  var date1 = $('#date1').val();
	  var year2 = $('#year2').val();
	  var month2 = $('#month2').val();
	  var date2 = $('#date2').val();
	  var start = year1+"-"+month1+"-"+date1;
	  var end = year2+"-"+month2+"-"+date2;
    $.ajax({
      type: 'POST',
      url: 'statistic.php',
      datatype: 'json',
      data: {op: "check", start:start, end:end}, 
      success: function(ret, s) {
        if('err' in ret) {
          alert("Failed!");
          return;
        }
        var text = "";
        $.each(ret, function(key, value) {
          text += "<font color='red'>" + key  
                      + ":</font>&nbsp&nbsp&nbsp&nbsp# of People = " + value['amount']  
                      + "&nbsp&nbsp&nbsp&nbspAverage Understandability = " + value['aver1'].toFixed(1) + "%"
                      + "&nbsp&nbsp&nbsp&nbspAverage Clarity = " + value['aver2'].toFixed(1) + "%<br>"; 
        })
        document.getElementById("statistic").innerHTML = text;
        document.getElementById("statistic").scrollIntoView();
      }
    });
    return false;
  }

  function spgComments(){
	  var year1 = $('#year1').val();
	  var month1 = $('#month1').val();
	  var date1 = $('#date1').val();
	  var year2 = $('#year2').val();
	  var month2 = $('#month2').val();
	  var date2 = $('#date2').val();
	  var start = year1+"-"+month1+"-"+date1;
	  var end = year2+"-"+month2+"-"+date2;
	  window.open("comment.php?page=1&start="+start+"&end="+end);
  }

</script>
		<body>
			<p>
				Range from date1 to date2<br> 
				date1<select name='' id='year1'>
					<option value='<?php echo date("Y"); ?>' selected><?php echo date("Y"); ?></option>
					<option value='<?php echo date("Y")-1; ?>'><?php echo date("Y")-1; ?></option>
					<option value='<?php echo date("Y")-2; ?>'><?php echo date("Y")-2; ?></option>
				</select> <select name='' id='month1'>
					<option value='<?php echo date("m"); ?>' selected><?php echo date("m"); ?></option>
					<option value='01'>1</option>
					<option value='02'>2</option>
					<option value='03'>3</option>
					<option value='04'>4</option>
					<option value='05'>5</option>
					<option value='06'>6</option>
					<option value='07'>7</option>
					<option value='08'>8</option>
					<option value='09'>9</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
				</select> <select name='' id='date1'>
					<option value='<?php echo date("d"); ?>' selected><?php echo date("d"); ?></option>
					<option value='01'>1</option>
					<option value='02'>2</option>
					<option value='03'>3</option>
					<option value='04'>4</option>
					<option value='05'>5</option>
					<option value='06'>6</option>
					<option value='07'>7</option>
					<option value='08'>8</option>
					<option value='09'>9</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
					<option value='13'>13</option>
					<option value='14'>14</option>
					<option value='15'>15</option>
					<option value='16'>16</option>
					<option value='17'>17</option>
					<option value='18'>18</option>
					<option value='19'>19</option>
					<option value='20'>20</option>
					<option value='21'>21</option>
					<option value='22'>22</option>
					<option value='23'>23</option>
					<option value='24'>24</option>
					<option value='25'>25</option>
					<option value='26'>26</option>
					<option value='27'>27</option>
					<option value='28'>28</option>
					<option value='29'>29</option>
					<option value='30'>30</option>
					<option value='31'>31</option>
				</select> <br> 
				date2<select name='' id='year2'>
					<option value='<?php echo date("Y"); ?>' selected><?php echo date("Y"); ?></option>
					<option value='<?php echo date("Y")-1; ?>'><?php echo date("Y")-1; ?></option>
					<option value='<?php echo date("Y")-2; ?>'><?php echo date("Y")-2; ?></option>
				</select> <select name='' id='month2'>
					<option value='<?php echo date("m"); ?>' selected><?php echo date("m"); ?></option>
					<option value='01'>1</option>
					<option value='02'>2</option>
					<option value='03'>3</option>
					<option value='04'>4</option>
					<option value='05'>5</option>
					<option value='06'>6</option>
					<option value='07'>7</option>
					<option value='08'>8</option>
					<option value='09'>9</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
				</select> <select name='' id='date2'>
					<option value='<?php echo date("d"); ?>' selected><?php echo date("d"); ?></option>
					<option value='01'>1</option>
					<option value='02'>2</option>
					<option value='03'>3</option>
					<option value='04'>4</option>
					<option value='05'>5</option>
					<option value='06'>6</option>
					<option value='07'>7</option>
					<option value='08'>8</option>
					<option value='09'>9</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
					<option value='13'>13</option>
					<option value='14'>14</option>
					<option value='15'>15</option>
					<option value='16'>16</option>
					<option value='17'>17</option>
					<option value='18'>18</option>
					<option value='19'>19</option>
					<option value='20'>20</option>
					<option value='21'>21</option>
					<option value='22'>22</option>
					<option value='23'>23</option>
					<option value='24'>24</option>
					<option value='25'>25</option>
					<option value='26'>26</option>
					<option value='27'>27</option>
					<option value='28'>28</option>
					<option value='29'>29</option>
					<option value='30'>30</option>
					<option value='31'>31</option>
				</select> <br><input type="button" value="CheckStatistic"
					alt="stat1" onclick="spgStatistic()" /> <input type="button"
					value="CheckComment" alt="comment1"
					onclick="spgComments()" /> <input
					type="button" value="ClearTallyData" alt="clear1"
					onclick="spgClearTally()" />
			</p>
			<p id="statistic"></p>
			<form id="inputs" onsubmit="return false" action="" method="post"
				enctype="text/plain">
				Choose a model: <select id="model" name="modelname">
					<option value=""></option>
					<option value="waterfall">Waterfall</option>
					<option value="incremental">Incremental</option>
					<option value="spiral">Spiral</option>
					<option value="xp">Extreme Programming</option>
					<option value="scrum">Scrum</option>
					<option value="crossplatform">CrossPlatform</option>
					<option value="sis">sis</option>
				</select>
				<table border="1" cellpadding="10" width="650px">
					<tr>
						<th>Features</th>
						<th>Value</th>
					</tr>
					<tr>
						<td>Early Functionality</td>
						<td><input type=radio name="func" value="0" alt="func1" />
							Iteratively introduce features &nbsp;&nbsp; <input type=radio
							name="func" value="1" alt="func2" /> Only produce final product</td>
					</tr>
					<tr>
						<td>Feature Adaptation</td>
						<td><input type=radio name="adap" value="0" alt="adap1" />
							Impossible &nbsp;&nbsp; <input type=radio name="adap" value="1"
							alt="adap2" /> Flexible</td>
					</tr>
					<tr>
						<td>User Involvement</td>
						<td>(Initially) <input type=radio name="invo" value="0"
							alt="invo0" /> 0% &nbsp;&nbsp; <input type=radio name="invo"
							value="1" alt="invo1" /> 10% &nbsp;&nbsp; <input type=radio
							name="invo" value="2" alt="invo2" /> 20% &nbsp;&nbsp; <input
							type=radio name="invo" value="3" alt="invo3" /> 30% &nbsp;&nbsp;
							<input type=radio name="invo" value="4" alt="invo4" /> 40%
							&nbsp;&nbsp; <input type=radio name="invo" value="5" alt="invo5" />
							50% &nbsp;&nbsp; <input type=radio name="invo" value="6"
							alt="invo6" /> 60% &nbsp;&nbsp; <input type=radio name="invo"
							value="7" alt="invo7" /> 70% &nbsp;&nbsp; <input type=radio
							name="invo" value="8" alt="invo8" /> 80% &nbsp;&nbsp; <input
							type=radio name="invo" value="9" alt="invo9" /> 90% &nbsp;&nbsp;
							<input type=radio name="invo" value="10" alt="invo10" /> 100%
							(Frequent feedback)
						</td>
					</tr>
					<tr>
						<td>Documentation</td>
						<td><input type=radio name="docu" value="0" alt="docu1" /> Not
							produced &nbsp;&nbsp; <input type=radio name="docu" value="1"
							alt="docu2" /> Produced</td>
					</tr>
					<tr>
						<td>Experienced Team</td>
						<td><input type=radio name="expe" value="0" alt="expe1" />
							Requested &nbsp;&nbsp; <input type=radio name="expe" value="1"
							alt="expe2" /> Not Required</td>
					</tr>
					<tr>
						<td>Model Type</td>
						<td>(Linear) <input type=radio name="tmode" value="0" alt="tmode0" />
							0% &nbsp;&nbsp; <input type=radio name="tmode" value="1"
							alt="tmode1" /> 10% &nbsp;&nbsp; <input type=radio name="tmode"
							value="2" alt="tmode2" /> 20% &nbsp;&nbsp; <input type=radio
							name="tmode" value="3" alt="tmode3" /> 30% &nbsp;&nbsp; <input
							type=radio name="tmode" value="4" alt="tmode4" /> 40%
							&nbsp;&nbsp; <input type=radio name="tmode" value="5"
							alt="tmode5" /> 50% &nbsp;&nbsp; <input type=radio name="tmode"
							value="6" alt="tmode6" /> 60% &nbsp;&nbsp; <input type=radio
							name="tmode" value="7" alt="tmode7" /> 70% &nbsp;&nbsp; <input
							type=radio name="tmode" value="8" alt="tmode8" /> 80%
							&nbsp;&nbsp; <input type=radio name="tmode" value="9"
							alt="tmode9" /> 90% &nbsp;&nbsp; <input type=radio name="tmode"
							value="10" alt="tmode10" /> 100% (Iterative)
						</td>
					</tr>
					<tr>
						<td>Planning and Scheduling</td>
						<td><input type=radio name="sche" value="0" alt="sche1" /> Upfront
							&nbsp;&nbsp; <input type=radio name="sche" value="1" alt="sche2" />
							Continuous</td>
					</tr>
					<tr>
						<td>Risk Mitigation</td>
						<td><input type=radio name="miti" value="0" alt="miti1" /> Yes
							&nbsp;&nbsp; <input type=radio name="miti" value="1" alt="miti2" />
							No</td>
					</tr>
					<tr>
						<td>Project Size</td>
						<td>(Small) <input type=radio name="psize" value="0" alt="psize0" />
							0% &nbsp;&nbsp; <input type=radio name="psize" value="1"
							alt="psize1" /> 10% &nbsp;&nbsp; <input type=radio name="psize"
							value="2" alt="psize2" /> 20% &nbsp;&nbsp; <input type=radio
							name="psize" value="3" alt="psize3" /> 30% &nbsp;&nbsp; <input
							type=radio name="psize" value="4" alt="psize4" /> 40%
							&nbsp;&nbsp; <input type=radio name="psize" value="5"
							alt="psize5" /> 50% &nbsp;&nbsp; <input type=radio name="psize"
							value="6" alt="psize6" /> 60% &nbsp;&nbsp; <input type=radio
							name="psize" value="7" alt="psize7" /> 70% &nbsp;&nbsp; <input
							type=radio name="psize" value="8" alt="psize8" /> 80%
							&nbsp;&nbsp; <input type=radio name="psize" value="9"
							alt="psize9" /> 90% &nbsp;&nbsp; <input type=radio name="psize"
							value="10" alt="psize10" /> 100% (Large)
						</td>
					</tr>
					<tr>
						<td>Prototype</td>
						<td><input type=radio name="prot" value="0" alt="prot1" /> Used
							&nbsp;&nbsp; <input type=radio name="prot" value="1" alt="prot2" />
							Not Used</td>
					</tr>
					<tr>
						<td><font color=red>CrossPlatform</font></td>
						<td><input type=radio name="pcross" value="0" alt="pcross1" /> No
							&nbsp;&nbsp; <input type=radio name="pcross" value="1"
							alt="pcross2" /> Yes</td>
					</tr>
				</table>
				<input type="submit" value="SubmitConfiguration" alt="submit1"
					onclick="spgSet()" /> <br />
			</form>
		</body>
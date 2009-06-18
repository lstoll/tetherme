<?
$message = $_GET['message'];
$_GET['manual_apn'] == 'true' ? $manual_apn = true : $manual_apn = false;
?>
<html>
<head>
	<title>Tether me!</title>
	<!-- Framework CSS -->
	<link rel="stylesheet" href="/blueprint/screen.css" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="/blueprint/print.css" type="text/css" media="print">
	<!--[if lt IE 8]><link rel="stylesheet" href="../../blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
</head>
<body>
	<div class="container" style="padding-top: 20px;"><!-- inline CSS is evil -->
	<div class="span-6">&nbsp;</div>
	<div class="span-12">
		<h1 class="center">Tether me!</h1>
		<p>So you want to tether your iPhone 3G running the shiny new firmware 3.0, but your carrier doesnt support it?
			Don't worry! There's an easy way to fix it. Simply choose your carrier from the list below (or enter the APN
			manually if you know what that means) and hit download (if you're on your phone now), or add your email address, hit send, and we'll mail
			you a configuration file right away that you can install on your phone that should get you tethering in no time!.
			If it doesn't work for you please let me know, I don't have access to many of these networks.</p>
			<p><strong>Disclaimer:</strong> While this enables tethering, I don't know for sure if your carrier will be able to
			  detect that you are using it. I assume not, however I may be wrong. Keep an eye on your bill</p>
	<form action="/sendconfig/" method="get">
		<fieldset>
		<? if($message == 'sent') { ?>
			<div class="success">The config file has been sent to your email - check it on your phone</div>
		<? } else if($message == 'failed') { ?>
			<div class="error">Sending the config failed. Please try again</div>
		<? } ?>
		<? if ($manual_apn) { ?>
			<p><a href="/">Choose from a list of carriers?</a></p>
			<p><label for="apn">APN:</label><br><input class="title" type="text" name="apn"/></p>
		<? } else {?>
			<p><a href="/?manual_apn=true">Enter an APN manually?</a></p>
			<p><label for="apn">Carrier:</label><br><select class="title" name="apn">
				<option value="telstra.internet">AU - Telstra</option>
				<option value="3internet">AU - Three</option>
				<option value="internet">AU - Optus</option>
				<option value="vfinternet.au">AU - Vodafone</option>
				<option value="gprs.swisscom.ch">CH - Swisscom</option>
				<option value="three.co.uk">UK - Three</option>
	      <option value="mobile.o2.co.uk">UK - O2 (Pay Monthly)</option>
	      <option value="payandgo.o2.co.uk">UK - O2 (Pay and Go)</option>
	      <option value="internet">US - AT&T</option>
			</select></p>
		<? } ?>
		<p> If you want to download the file direct on your phone, just click download</p>
		<p><input type="submit" name="submit" value="Download"/></p>
		<p> If you want the file e-mailed to your phone, fill in the address and hit send</p>
		<p><label for="to">E-Mail address for your phone:</label><br><input type="text" class="title" name="to"/></p>
		<input type="submit" name="submit" value="Send"/>
		</fieldset>
	</form>
	<p> problems? suggestions? <a href="mailto:lstoll.net?subject=TetherMe Feedback">mail me</a>. Created by <a href="http://lstoll.net">Lincoln Stoll</a></p>
	</div>
	</div>
  <script type="text/javascript">
  var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
  document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
  try {
  var pageTracker = _gat._getTracker("UA-248879-12");
  pageTracker._trackPageview();
  } catch(err) {}</script>
</body>
</html>
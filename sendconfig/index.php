<?php 
require_once('../include/carriers.php');
ob_start(); //Turn on output buffering 

$action = $_GET['submit'];

// if we have a carrier specified, load them
if ($_GET['carrier']) {
  $carrier_name = $_GET['carrier'];
  $carrier = $carriers[$carrier_name];
  $apn = carrier_apn_snippet($carrier);
}
else {
  // get the params
    if ($_GET['apn']) {
    $carrier = array('apn' => $_GET['apn'], 'username' => $_GET['username'],
      'password' => $_GET['password']);
    $apn = carrier_apn_snippet($carrier);
  }
  else {
    header( 'Location: /?message_type=error&manual_apn=true&message='.
      urlencode('You must enter at least an APN.'));
    exit();
  }
}

//define the receiver of the email 
$to = $_GET['to']; 
//define the subject of the email 
$subject = 'Tethering Config'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash 
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n 
$headers = "From: TetherMe <noreply@lstoll.net>\r\nReply-To: noreply@lstoll.net\r\n"; 
//add boundary string and mime type specification 
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"".$random_hash."\"\r\n"; 
 
//define the body of the message. 

?>
<? echo '<'.'?'?>xml version="1.0" encoding="UTF-8"<? echo '?'.'>'?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>PayloadContent</key>
	<array>
		<dict>
			<key>PayloadContent</key>
			<array>
				<dict>
					<key>DefaultsData</key>
					<dict>
						<key>apns</key>
						<array>
							<dict>
<?=$apn?>
								
								<key>type-mask</key>
								<integer>-8</integer>

							</dict>
						</array>
					</dict>
					<key>DefaultsDomainName</key>
					<string>com.apple.managedCarrier</string>
				</dict>
			</array>
			<key>PayloadDescription</key>
			<string>Provides customization of carrier Access Point Name.</string>
			<key>PayloadDisplayName</key>
			<string>Advanced Settings</string>
			<key>PayloadIdentifier</key>
			<string>net.lstoll.tetherme</string>
			<key>PayloadOrganization</key>
			<string>http://tetherme.lstoll.net</string>
			<key>PayloadType</key>
			<string>com.apple.apn.managed</string>
			<key>PayloadUUID</key>
			<string>6F1D509D-A494-444D-9098-F233891019E3</string>
			<key>PayloadVersion</key>
			<integer>1</integer>
		</dict>
	</array>
	<key>PayloadDescription</key>
	<string>Enables Tethering</string>
	<key>PayloadDisplayName</key>
	<string>Enable Tethering</string>
	<key>PayloadIdentifier</key>
	<string>net.lstoll.tetherme</string>
	<key>PayloadOrganization</key>
	<string>http://tetherme.lstoll.net</string>
	<key>PayloadType</key>
	<string>Configuration</string>
	<key>PayloadUUID</key>
	<string>A0670934-C558-42E1-9E80-9B8E079E9AE3</string>
	<key>PayloadVersion</key>
	<integer>1</integer>
</dict>
</plist>
<?
$config = ob_get_clean(); 
ob_start();
//encode it with MIME base64,
//and split it into smaller chunks
$attachment = chunk_split(base64_encode($config));
?>
--<?= $random_hash; ?>

Content-Type: text/plain; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

Open the attached file, and install it - you should then be ready to go with tethering.

If you have any problems, please e-mail me at the address on the site.

Enjoy!



--<?= $random_hash; ?>

Content-Type: application/x-apple-aspen-config; name="tether_config.mobileconfig"
Content-Transfer-Encoding: base64
Content-Disposition: attachment

<?= $attachment; ?>
--<?= $random_hash; ?>

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 

if ($action == "Send") {
  //send the email 
  $mail_sent = @mail( $to, $subject, $message, $headers ); 
  //if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
  if ($mail_sent) {
     header( 'Location: /?message_type=success&message='. 
       urlencode('The config file has been sent to your email - check it on your phone') );
  }
  else {
    header( 'Location: /?message_type=error&message='.
      urlencode('Sending the config failed. Please try again'));
  }
}
else if ($action == "Download") {
  // send the file
  header('Content-type: application/x-apple-aspen-config');
  // It will be called downloaded.pdf
  header('Content-Disposition: attachment; filename="tetherme.mobileconfig"');
  echo $config;
}
else {
  echo 'No action specified';
}
?>
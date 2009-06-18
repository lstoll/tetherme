<?
// This contains the data for the supported carriers

$carriers = array(
  'autelstra' => array('name' => 'AU - Telstra', 'apn' => 'telstra.internet', 'username' => '', 'password' => ''),
  'auoptus' => array('name' => 'AU - Optus', 'apn' => 'internet', 'username' => '', 'password' => ''),
  'authree' => array('name' => 'AU - Three', 'apn' => '3services', 'username' => '', 'password' => ''),
  'auvodafone' => array('name' => 'AU - Vodafone', 'apn' => 'vfinternet.au', 'username' => '', 'password' => ''),
  'auvirgin' => array('name' => 'AU - Virgin', 'apn' => 'VirginInternet', 'username' => '', 'password' => ''),
  'chswisscom' => array('name' => 'CH - Swisscom', 'apn' => 'gprs.swisscom.ch', 'username' => '', 'password' => ''),
  'sastc' => array('name' => 'SA - STC (Saudi Telecom)', 'apn' => 'jawalnet.com.sa', 'username' => '', 'password' => ''),
  'ukthree' => array('name' => 'UK - Three', 'apn' => 'three.co.uk', 'username' => '', 'password' => ''),
  'uko2monthly' => array('name' => 'UK - O2 (Pay Monthly)', 'apn' => 'idata.o2.co.uk', 'username' => 'vertigo', 'password' => 'password'),
  'uk02payandgo' => array('name' => 'UK - O2 (Pay and Go)', 'apn' => 'payandgo.o2.co.uk', 'username' => 'vertigo', 'password' => 'password'),
  'usatt' => array('name' => 'US - AT&T', 'apn' => 'wap.cingular', 'username' => 'WAP@CINGULARGPRS.COM', 'password' => 'CINGULAR1'),
);

/**
 * This function generates the apn snippet from the carrier hash
 */
function carrier_apn_snippet($carrier) {
  $config = "<key>apn</key>\n<string>".$carrier['apn']."</string>\n";
  $config .= "<key>username</key>\n<string>".$carrier['username']."</string>\n";
  $config .= "<key>password</key>\n<string>".$carrier['password']."</string>\n";
  return $config;
}

?>
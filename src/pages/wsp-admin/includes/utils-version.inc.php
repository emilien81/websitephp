<?php 
	function getCurrentWspVersion() {
		return file_get_contents(dirname(__FILE__)."/../../../wsp/version.txt");
	}
	
	function isNewWspVersion() {
		if (extension_loaded('soap')) {
			$user_wsp_version = getCurrentWspVersion();
			if (!isset($_SESSION['server_wsp_version'])) {
				$client = new WebSitePhpSoapClient("http://www.website-php.com/en/webservices/wsp-information-server.wsdl?wsdl");
				$_SESSION['server_wsp_version'] = $client->getLastVersionNumber();
			}
			if (trim($user_wsp_version) != trim($_SESSION['server_wsp_version'])) {
				return trim($_SESSION['server_wsp_version']);
			}
		}
		return false;
	}
	
	function getCurrentBrowscapVersion() {
		$db = dirname(__FILE__)."/../../../wsp/includes/browscap/php_browscap.ini";
		$browscapIni=defined('INI_SCANNER_RAW') ? parse_ini_file($db,true,INI_SCANNER_RAW) : parse_ini_file($db,true);
		uksort($browscapIni,'_sortBrowscap');
		$browscapIni=array_map('_lowerBrowscap',$browscapIni);
		
		return $browscapIni['GJK_Browscap_Version']['version'];
	}
	
	function isNewBrowscapVersion() {
		if (extension_loaded('soap')) {
			if (!isset($_SESSION['user_browscap_version'])) {
				$_SESSION['user_browscap_version'] = getCurrentBrowscapVersion();
			}
			if (!isset($_SESSION['server_browscap_version'])) {
				$_SESSION['server_browscap_version'] = file_get_contents("https://browsers.garykeith.com/versions/version-number.asp");
			}
			if (trim($_SESSION['user_browscap_version']) != trim($_SESSION['server_browscap_version'])) {
				return trim($_SESSION['server_browscap_version']);
			}
		}
		return false;
	}
	
	function getAlertVersiobObject($page) {
		$alert_version_obj = null;
		if (($wsp_version = isNewWspVersion()) != false || ($browscap_version = isNewBrowscapVersion())) {
			$alert_version_obj = new Object();
			$alert_version_obj->setClass("warning");
			if ($wsp_version != false) {
				$alert_version_obj->add(__(NEW_WSP_VERSION, $wsp_version));
			}
			if ($browscap_version != false) {
				$dialog_update = new DialogBox(__(UPDATE_FRAMEWORK), new Url("wsp-admin/update/update-framework.call?update=update-browscap"));
				$dialog_update->displayFormURL()->modal();
				$alert_version_obj->add(__(NEW_BROWSCAP_VERSION, $dialog_update->render(), $browscap_version));
			}
		}
		return $alert_version_obj;
	}
?>
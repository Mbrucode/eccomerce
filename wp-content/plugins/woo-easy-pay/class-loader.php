<?php
/**
 * Load all the necessary classes on demand.
 */
spl_autoload_register ( function ($className) {
	
	$className = $className . '.php';
	if (file_exists ( ONLINEWORLDPAY_ADMIN . 'classes/' . $className )) {
		require_once ONLINEWORLDPAY_ADMIN . 'classes/' . $className;
	} else if (file_exists ( ONLINEWORLDPAY_PAYMENTS . 'classes/' . $className )) {
		require_once ONLINEWORLDPAY_PAYMENTS . 'classes/' . $className;
	} else {
		if (preg_match ( '/^Worldpay\\\\([\w]+.php)$/', $className, $matches )) {
			if (file_exists ( ONLINEWORLDPAY_PLUGIN_PATH . 'worldpay-lib-php/lib/' . $matches [1] )) {
				require_once ONLINEWORLDPAY_PLUGIN_PATH . 'worldpay-lib-php/lib/' . $matches [1];
			}
		}
	}
} );

add_action ( 'plugins_loaded', function () {
	if (class_exists ( 'WC_Payment_Gateway' )) {
		require_once ONLINEWORLDPAY_PAYMENTS . 'classes/WC_OnlineWorldpay.php';
		require_once ONLINEWORLDPAY_PAYMENTS . 'classes/WC_OnlineWorldpay_Subscriptions.php';
		require_once (ONLINEWORLDPAY_PLUGIN_PATH . 'services/OnlineWorldpay_Webhooks.php');
	}
} );

include_once (ONLINEWORLDPAY_ADMIN . 'classes/OnlineWorldpay_Admin.php');
include_once (ONLINEWORLDPAY_ADMIN . 'classes/OnlineWorldpay_Update.php');
include_once (ONLINEWORLDPAY_ADMIN . 'classes/OnlineWorldpay_Admin_Tutorial.php');
include_once (ONLINEWORLDPAY_ADMIN . 'classes/OnlineWorldpay_DebugLog.php');
include_once (ONLINEWORLDPAY_ADMIN . 'classes/OnlineWorldpay_HTML_Helper.php');
include_once (ONLINEWORLDPAY_ADMIN . 'classes/OnlineWorldpay_Manager.php');
include_once (ONLINEWORLDPAY_PAYMENTS . 'functions/onlineworldpay-functions.php');
include_once (ONLINEWORLDPAY_PAYMENTS . 'classes/OnlineWorldpay_Donations.php');
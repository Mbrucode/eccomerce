<?php
/**
 * Update class for data conversions.
 * @author Clayton
 *
 */
class OnlineWorldpay_Update{

	public static function  init(){

		add_action( 'admin_init', __CLASS__.'::performUpdate');
		
		add_action('in_plugin_update_message-woo-easy-pay/worldpay.php', __CLASS__.'::getAdminUpdateNotice');
	}

	public static function getUpdates(){
		return array(
				'1.1.6'=>ONLINEWORLDPAY_ADMIN . 'updates/version-1.1.6.php'
		);
	}

	public static function performUpdate(){
		$current_version = get_option( 'onlineworldpay_for_woocommerce_version' );
		if( empty( $current_version ) ){
			$current_version = 0;
		}
		foreach( self::getUpdates() as $version=>$file ){
			if( version_compare( $current_version, $version, '<' ) ){
				include_once $file;
				self::updateVersion( $version );

				owp_manager()->addAdminNotice( array(
						'type'=>'success',
						'text'=>sprintf(__( 'Thank you for updating OnlineWorldpay For WooCommerce to version %s.', 'onlineworldpay' ), owp_manager()->version )
				));
			}
		}

	}

	public static function updateVersion( $version ){
		update_option( 'onlineworldpay_for_woocommerce_version', $version );
	}
	
	public static function getAdminUpdateNotice($args) {
		$response = wp_safe_remote_get ( 'https://plugins.svn.wordpress.org/woo-easy-pay/trunk/readme.txt' );
		if ($response instanceof WP_Error) {
			owp_manager ()->log->writeToLog ( sprintf ( 'There was an error retrieving the update notices. %s', print_r ( $response, true ) ) );
		} else {
			$content = ! empty ( $response ['body'] ) ? $response ['body'] : '';
			self::parseUpdateNoticeContent ( $content );
		}
	}
	
	/**
	 * Parse the content for the update notice.
	 *
	 * @param string $content
	 *        	The content retrieved from the readme.txt file.
	 */
	public static function parseUpdateNoticeContent($content) {
		$pattern = '/==\s*Upgrade Notice\s*==\s*=\s*([0-9.]*)\s*=\s*(.*)/';
		if (preg_match ( $pattern, $content, $matches )) {
			$version = $matches [1];
			$notice = $matches [2];
			if (version_compare ( $version, owp_manager()->version, '>' )) {
				echo '<div class="wc_plugin_upgrade_notice">' . $notice . '</div>';
			}
		}
	}
}
OnlineWorldpay_Update::init();
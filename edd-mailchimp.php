<?php
/*
Plugin Name: Easy Digital Downloads - MailChimp
Plugin URL: http://easydigitaldownloads.com/extension/mail-chimp
Description: Include a MailChimp signup option with your Easy Digital Downloads checkout
Version: 2.5.6
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Contributors: Pippin Williamson, Dave Kiss
*/

define( 'EDD_MAILCHIMP_PRODUCT_NAME', 'Mail Chimp' );
define( 'EDD_MAILCHIMP_PATH', dirname( __FILE__ ) );

/*
|--------------------------------------------------------------------------
| LICENSING / UPDATES
|--------------------------------------------------------------------------
*/

// Require the drewm/mailchimp-api wrapper lib
require('vendor/autoload.php');

if ( class_exists( 'EDD_License' ) && is_admin() ) {
  $eddmc_license = new EDD_License( __FILE__, EDD_MAILCHIMP_PRODUCT_NAME, '2.5.6', 'Pippin Williamson' );
}

if( ! class_exists( 'EDD_MailChimp_V3_Upgrade' ) ) {
  include( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-v3-upgrade.php' );
  new EDD_MailChimp_V3_Upgrade;
}

if( ! class_exists( 'EDD_Newsletter' ) ) {
	include( EDD_MAILCHIMP_PATH . '/includes/class-edd-newsletter.php' );
}

if( ! class_exists( 'EDD_MailChimp' ) ) {
  if ( edd_has_upgrade_completed( 'upgrade_mailchimp_groupings_settings' ) ) {
    include( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp.php' );
  } else {
    include( EDD_MAILCHIMP_PATH . '/includes/deprecated/class-edd-mailchimp.php' );
  }
}

if( ! class_exists( 'EDD_MC_Ecommerce_360' ) ) {
	include( EDD_MAILCHIMP_PATH . '/includes/class-edd-ecommerce360.php' );
}

if ( ! class_exists( 'EDD_MC_Tools' ) && class_exists( 'Easy_Digital_Downloads' ) ) {
	if ( ( defined ( 'EDD_VERSION' ) && version_compare( EDD_VERSION, '2.4.2', '>=' ) ) && is_admin() ) {
		include( EDD_MAILCHIMP_PATH . '/includes/class-edd-mailchimp-tools.php' );
	}
}

$edd_mc       = new EDD_MailChimp( 'mailchimp', 'Mail Chimp' );
$edd_mc360    = new EDD_MC_Ecommerce_360;

if ( class_exists( 'EDD_MC_Tools' ) ) {
	$edd_mc_tools = new EDD_MC_Tools();
}

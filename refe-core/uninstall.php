<?php
/**
 * Disinstallazione: si tolgono le impostazioni, i contenuti restano.
 *
 * @package RefeCore
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

delete_option( 'refe_impostazioni' );
delete_post_meta_by_key( 'refe_animazione' );

<?php
/**
 * Lezione.
 *
 * @package RefeCore
 *
 * @var array $attributes Attributi.
 */

namespace Refe\Core;

defined( 'ABSPATH' ) || exit;

$refe_titolo = wp_strip_all_tags( $attributes['titolo'] );
if ( '' === trim( $refe_titolo ) ) {
	return;
}
static $refe_prima = true;
$refe_lettore      = Video::lettore( $attributes['link'] );
$refe_video        = $refe_lettore ? $refe_lettore : ( $attributes['file']['url'] ?? '' );
?>
<li class="refe-lezione">
	<?php /* translators: %s: titolo della lezione. */ ?>
	<input type="checkbox" aria-label="<?php echo esc_attr( sprintf( __( 'Segna «%s» come completata', 'refe-core' ), $refe_titolo ) ); ?>">
	<button type="button" aria-current="<?php echo $refe_prima ? 'true' : 'false'; ?>" data-durata="<?php echo esc_attr( $attributes['durata'] ); ?>"<?php echo $refe_video ? ' data-video="' . esc_url( $refe_video ) . '"' : ''; ?>><?php echo esc_html( $refe_titolo ); ?></button>
</li>
<?php
$refe_prima = false;

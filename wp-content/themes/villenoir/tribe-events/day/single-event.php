<?php
/**
 * Day View Single Event
 * This file contains one event in the day view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/day/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$venue_details = tribe_get_venue_details();

// Venue microformats
$has_venue = ( $venue_details ) ? ' vcard' : '';
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

?>



<div class="row">
	<div class="col-md-8">

		<!-- Event Title -->
		<?php do_action( 'tribe_events_before_the_event_title' ) ?>
		<h2 class="tribe-events-list-event-title summary">
			<a class="url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
				<?php the_title() ?>
			</a>
		</h2>
		<?php do_action( 'tribe_events_after_the_event_title' ) ?>

		<!-- Event Meta -->
		<?php do_action( 'tribe_events_before_the_meta' ) ?>
		<?php do_action( 'tribe_events_after_the_meta' ) ?>

		<!-- Event Content -->
		<?php do_action( 'tribe_events_before_the_content' ) ?>
		<div class="tribe-events-list-event-description tribe-events-content description entry-summary">

			<!-- Event Cost -->
			<?php if ( tribe_get_cost() ) : ?>
				<p class="tribe-events-event-cost"><?php esc_html_e( 'Price - ', 'the-events-calendar' ) ?> <span><?php echo tribe_get_cost( null, true ); ?></span></p>
			<?php endif; ?>

			<?php echo tribe_events_get_the_excerpt(); ?>
			<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more" rel="bookmark"><?php esc_html_e( 'Find out more', 'the-events-calendar' ) ?> &raquo;</a>
		</div><!-- .tribe-events-list-event-description -->
		<?php do_action( 'tribe_events_after_the_content' ); ?>

	</div>

	<div class="col-md-4">
		<!-- Event Image -->
		<?php echo tribe_event_featured_image( null, 'medium' ); ?>
	</div>

</div>

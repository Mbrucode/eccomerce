<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

?>

<div class="row">
	<div class="col-sm-8 col-md-8">

		<!-- Event Title -->
		<?php do_action( 'tribe_events_before_the_event_title' ) ?>
		<!-- Schedule & Recurrence Details -->
		<div class="tribe-event-schedule-details">
			<?php echo tribe_events_event_schedule_details() ?>
		</div>
		<h2 class="tribe-events-list-event-title">
			<a class="tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
				<?php the_title() ?>
			</a>
		</h2>
		<?php do_action( 'tribe_events_after_the_event_title' ) ?>

		

		<!-- Event Meta -->
		<?php do_action( 'tribe_events_before_the_meta' ) ?>
		<?php do_action( 'tribe_events_after_the_meta' ) ?>



		<!-- Event Content -->
		<?php do_action( 'tribe_events_before_the_content' ) ?>
		<div class="tribe-events-list-event-description tribe-events-content">
			<?php if ( tribe_get_cost() ) : ?>
				<p class="tribe-events-event-cost"><?php esc_html_e( 'Price - ', 'the-events-calendar' ) ?> <span><?php echo tribe_get_cost( null, true ); ?></span></p>
			<?php endif; ?>
			<?php echo tribe_events_get_the_excerpt( null, wp_kses_allowed_html( 'post' ) ); ?>
			<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more" rel="bookmark"><?php esc_html_e( 'Find out more', 'the-events-calendar' ) ?> &raquo;</a>
		</div><!-- .tribe-events-list-event-description -->
		<?php
		do_action( 'tribe_events_after_the_content' );
		?>
	</div>


	<!-- Event Image -->
	<div class="col-sm-4 col-md-4">
		<?php echo tribe_event_featured_image( null, 'medium' ) ?>
	</div>

</div>
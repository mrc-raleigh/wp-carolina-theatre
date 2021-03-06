<?php
/////// DATES in YYYYMMDD format
$start_date = get_field('start_date'); 		
$end_date = get_field('end_date'); 				
date_default_timezone_set('America/New_York');
$today = date("Ymd", strtotime('today')); 
$past_event = false;

if($end_date < $today) {
	$showtime_soonestDate = $end_date;
	$past_event = true;
} else {
	// get closest date's earliest time
	// $showtime_soonestDate (Ymd - 20180704)
	// $showtime_soonestTime (g:ia - 7:30pm or empty string)
	include(locate_template('template-parts/event-get_soonest_date.php', false, true));
}

/////// ASSIGN CLASS NAMES FOR EACH EVENT
$filters = '';
$class_name = '';
if (get_post_type() == 'film') {
	$class_name .= ' film'; 
	$filters .= ' film'; 

	if ($showtime_soonestDate == $today) {
	  $filters .= ' now-playing'; 
	} else if ($today < $start_date) {
	  $filters .= ' coming-soon'; 
	}  
} else if (get_post_type() == 'event') {
	$class_name .= ' event'; 
	$filters .= ' event'; 
}

if(have_rows('event_filters')){
	$filters .= ' ';
	while(have_rows('event_filters')){ the_row();
		$filters .= get_sub_field('slug') . ' ';
	}	
}
?>

<div class="card eventCard <?php echo $class_name; ?><?php if($past_event){ echo ' past-event'; } ?>" data-filterme="<?php echo $filters; ?>">
   <a href="<?php echo get_page_link(get_the_id()); ?>">
    <div class="event__dateBox">
			<span class="day"><?php echo date("j", strtotime($showtime_soonestDate)); ?></span>
			<span class="month"><?php echo date("M", strtotime($showtime_soonestDate)); ?></span>
    </div>
    <div class="eventCard__image">
    	<?php 
  			$image_url = get_stylesheet_directory_uri().'/src/img/no-event-image-thumb.jpg';
				$image_alt = 'No Event Image to Show'; 
				
				if (have_rows('event_hero')){
					$slideRepeater = get_field('panel_content');
					$image = $slideRepeater[0]['image'];
			 	 	
			 	 	if($image){ 
         		$image_url = $image['sizes']['event-thumb'];
         		$image_alt = $image['alt'];
          } //endif 
				} //endif haveRows 
			?>
		 	<img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" />
    </div>
    <div class="card__infoWrapper">
      <?php get_template_part('template-parts/part', 'event_categories'); ?>
      <p class="card__title"><?php the_title();?></p>
      <div class="card__info">	
      	<?php $event_location = get_field('event_location'); ?>
      	<?php if (get_post_type() == 'film'){ ?>
      		<?php 
						$film_director = get_field('director'); 												// text
						$film_release_country = get_field('release_country'); 					// text
						$film_release_year = get_field('release_year'); 								// text
						$film_runtime = get_field('runtime'); 													// text
						$film_rating = get_field('rating');															// select
					?>
      		<?php if($film_runtime){ ?>
    			<p><i class="far fa-clock"></i><?php echo $film_runtime . ' min'; ?></p>
					<?php } ?>
					<?php if($film_director && $film_release_year){ ?>
					<p><i class="far fa-film"></i><?php echo $film_director; ?>, <?php echo $film_release_year; ?></p>
					<?php } else if ($film_director) { ?>
					<p><i class="far fa-film"></i><?php echo $film_director; ?></p>
					<?php } else if ($film_release_year) { ?>
					<p><i class="far fa-film"></i><?php echo $film_release_year; ?></p>
					<?php } ?>
        <?php } else if (get_post_type() == 'event'){ ?>
        	<?php if($showtime_soonestTime){ ?>
      		<p><i class="far fa-clock"></i><?php echo $showtime_soonestTime; ?></p>
      		<?php } ?>
          <?php if($event_location){ ?>
        	<p><i class="far fa-map-marker-alt"></i><?php echo $event_location; ?></p>
        	<?php } ?>
        <?php } ?>
        
    		<?php get_template_part( 'template-parts/event', 'ticket_prices' ); ?>
      </div>
    </div>
    <div class="button card__button"><span>Tickets & Info <i class="fas fa-arrow-right"></i></span></div>
  </a>
</div>
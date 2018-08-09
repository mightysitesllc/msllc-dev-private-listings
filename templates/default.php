<?php
// echo $atts['prop'] . "<br><br><br>";
if( !empty($atts['prop']) ){
	$args = array(
	'p' => intval($atts['prop']), // id of a page, post, or custom type
	'post_type' => 'rental'
	);
} else  {
	$args = array(
	'posts_per_page'   => -1,
	'post_type'        => 'rental',
	'post_status'      => 'publish',
	'suppress_filters' => true 
	);
}
$the_query = new WP_Query( $args );
function wpos_rental_get_unique() {
	static $unique = 0;
	$unique++;
	return $unique;
}
$unique = wpos_rental_get_unique();
?>

<?php if( $the_query->have_posts() ): ?>

	<?php while ( $the_query->have_posts() ) : $the_query->the_post();
		$property_title 		= get_the_title();
		$property_status 		= get_field('status');
		$property_price_listing	= get_field('listing_price');
		$property_price_sold	= get_field('sold_price');
		$property_price 		= (!empty($property_price_listing)) ? $property_price_listing : $property_price_sold; ?>
		<div class="wpos-rental-main-wrp">
			<?php if(!empty($property_title) || !empty($property_status) || !empty($property_price)) { ?>
				<div class="wpos-general-info-wrap">
					<?php if(!empty($property_title)){ ?>
						<div class="wpos-property-title wpos-common-info"><?php echo $property_title; ?></div>
					<?php } ?>
					<?php if(!empty($property_status)){ ?>
						<div class="wpos-property-status wpos-common-info"><strong>Status:</strong> <?php echo $property_status; ?></div>
					<?php } ?>
					<?php if(!empty($property_price)){ ?>
						<div class="wpos-property-price wpos-common-info"><strong>Price:</strong> <?php echo number_format($property_price); ?></div>
					<?php } ?>
				</div>
			<?php } ?>

			<?php $galleries = '';
			$galleries = get_field('property_images'); ?>

			<?php if(!empty($galleries)){ ?>
				<div class="slider_row">
					<div id="owl-carousel-<?php echo $unique; ?>" class="owl-carousel" data-slider-id="1">
						<?php foreach( $galleries as $gallery ){
							$slider_image = wp_get_attachment_image_src($gallery,'detail_view_image_size'); ?>
							<img src="<?php echo $gallery['sizes']['detail_view_image_size'];?>" />
						<?php } ?>
					</div>
					<?php /*<div class="owl-thumbs" data-slider-id="1">
					foreach( $galleries as $gallery ){
					$thumbnail_image = wp_get_attachment_image_src($gallery, 'thumbnail_image_size');?>
					<!--<button class="owl-thumb-item"><img src="<?php //echo $thumbnail_image[0];?>" /></button>--><?php
					}
					</div>*/ ?>
				</div>
			<?php } ?>

			<div class="wpos-field-group">
				<?php $video1 	= get_field('virtual_tour_1');
				$video2		= get_field('virtual_tour_2');
				$from_time 	= get_field('open_house_start_time');
				$to_time   	= get_field('open_house_end_time');
				if( $video1 || $video2 || $from_time != '' || $to_time ){ ?>
					<div class="wpos-details-row-video wpos-margin-block">
						<table>
							<?php if( $video1 || $video2 || $from_time != '' || $to_time ){ ?>
								<tr>
									<?php if( $video1 || $video2) { ?>
										<td><strong>Virtual Tour: </strong><a href="<?php echo $video1; ?>">View Tour One</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo $video2; ?>">View Tour Two</a></td>
									<?php }

									if( $from_time || $to_time ){ ?>
										<?php if( $from_time || $to_time) { ?>
											<td><strong>open house time: </strong><div class="wpos-start-date"><?php echo $from_time ?></div>
												<!-- <div class="wpos-end-date"><?php //echo $to_time; ?></div> -->
											</td>
										<?php } ?>
									<?php } ?>
								</tr>
							<?php } ?>
						</table>
					</div>
				<?php }

				$remarks = get_field('remarks');
				if($remarks != '') { ?>
					<div class="details-row-remark wpos-margin-block">
						<?php echo $remarks; ?>
					</div>
				<?php } ?>
			</div>
			<?php $address 			= get_field('address');
			$school_district 	= get_field('school_district');
			$county 			= get_field('county');
			$postal_city 		= get_field('postal_city');

			if(!empty($address) || !empty($school_district) || !empty($county) || !empty($postal_city)){ ?>
				<div class="wpos-location-block">
					<h2>Location</h2>
					<table>
						<?php if(!empty($address)){ ?>
							<tr><td><strong>Address, City, State and Zip Code:</strong> <?php echo $address; ?></td></tr>
						<?php } ?>
						<?php if(!empty($school_district)){ ?>
							<tr><td><strong>School District:</strong> <?php echo $school_district; ?></td></tr>
						<?php } ?>
						<?php if(!empty($county)){ ?>
							<tr><td><strong>County:</strong> <?php echo $county; ?></td></tr>
						<?php } ?>
						<?php if(!empty($postal_city)){ ?>
							<tr><td><strong>Postal City:</strong> <?php echo $postal_city; ?></td></tr>
						<?php } ?>
					</table>
				</div>
			<?php } ?>

			<div class="wpos-directions-block">
				<?php $directions=get_field('directions');
				if($directions != '') { ?>
					<h2>Directions</h2>
					<div class="details-row-directions wpos-margin-block">
						<table><tr><td><strong>Directions: </strong><?php echo $directions; ?></td></tr></table>
					</div>
				<?php } ?>
			</div>
			<?php
			$construction_status 	= get_field('construction_status');
			$yearlyseasonal 		= get_field('yearlyseasonal');
			$foundation_size 		= get_field('foundation_size');
			$above_grade_fin_sq_ft 	= get_field('above_grade_fin_sq_ft');
			$below_grade_fin_sq_ft 	= get_field('below_grade_fin_sq_ft');
			$total_fin_sq_ft 		= get_field('total_fin_sq_ft');
			$roof 					= get_field('roof');
			$roof 					= join(', ', $roof);
			$acres 					= get_field('acres');
			$lot_size 				= get_field('lot_size');
			$fuel 					= get_field('fuel');
			$fuel 					= join(', ', $fuel);
			$second_unit 			= get_field('second_unit');
			$second_unit 			= join(', ', $second_unit);

			if(!empty($construction_status) || !empty($yearlyseasonal) || !empty($foundation_size) || !empty($above_grade_fin_sq_ft) || !empty($below_grade_fin_sq_ft) || !empty($total_fin_sq_ft) || !empty($roof) || !empty($acres) || !empty($lot_size) || !empty($fuel) || !empty($second_unit)) { ?>

				<div class="wpos-structure-block">
					<h2>Structure and Lot</h2>

					<table>
						<?php if(!empty($construction_status)) { ?>
							<tr><td><strong>Construction Status:</strong> <?php echo $construction_status; ?></td></tr>
						<?php } ?>
						<?php if(!empty($yearlyseasonal)) { ?>
							<tr><td><strong>Yearly/Seasonal:</strong> <?php echo $yearlyseasonal; ?></td></tr>
						<?php } ?>
						<?php if(!empty($foundation_size)) { ?>
							<tr><td><strong>Foundation Size:</strong> <?php echo $foundation_size; ?></td></tr>
						<?php } ?>
						<?php if(!empty($above_grade_fin_sq_ft)) { ?>
							<tr><td><strong>Above Grade Fin Sq Ft:</strong> <?php echo $above_grade_fin_sq_ft; ?></td></tr>
						<?php } ?>
						<?php if(!empty($below_grade_fin_sq_ft)) { ?>
							<tr><td><strong>Below Grade Fin Sq Ft:</strong> <?php echo $below_grade_fin_sq_ft; ?></td></tr>
						<?php } ?>
						<?php if(!empty($total_fin_sq_ft)) { ?>
							<tr><td><strong>Total Fin Sq Ft:</strong> <?php echo $total_fin_sq_ft; ?></td></tr>
						<?php } ?>
						<?php if(!empty($roof)) { ?>
							<tr><td><strong>Roof:</strong> <?php echo $roof; ?></td></tr>
						<?php } ?>
						<?php if(!empty($acres)) { ?>
							<tr><td><strong>Acres:</strong> <?php echo $acres; ?></td></tr>
						<?php } ?>
						<?php if(!empty($lot_size)) { ?>
							<tr><td><strong>Lot Size:</strong> <?php echo $lot_size; ?></td></tr>
						<?php } ?>
						<?php if(!empty($fuel)) { ?>
							<tr><td><strong>Fuel:</strong> <?php echo $fuel; ?></td></tr>
						<?php } ?>
						<?php if(!empty($second_unit)) { ?>
							<tr><td><strong>Second Unit:</strong> <?php echo $second_unit; ?></td></tr>
						<?php } ?>
					</table>
				</div>
			<?php } 

			$garage 				 = get_field('garage');
			$garage_spaces 			 = get_field('garage_spaces');
			$parking_characteristics = get_field('parking_characteristics');
			$parking_characteristics = join(', ', $parking_characteristics);
			if(!empty($garage) || !empty($garage_spaces) || !empty($parking_characteristics)){ ?>
				<div class="wpos-parking-block">
					<h2>Parking</h2>
					<table>
						<?php if(!empty($garage)){ ?>
							<tr><td><strong>Garage:</strong> <?php echo $garage; ?></td></tr>
						<?php } ?>

						<?php if(!empty($garage_spaces)){ ?>
							<tr><td><strong>Garage Spaces:</strong> <?php echo $garage_spaces; ?></td></tr>
						<?php } ?>

						<?php if(!empty($parking_characteristics)){ ?>
							<tr><td><strong>Parking Characteristics:</strong> <?php echo $parking_characteristics; ?></td></tr>
						<?php } ?>
					</table>
				</div>
			<?php } 

			$legal_description 		= get_field('legal_description');
			$complexdevsub 			= get_field('complexdevsub');
			$homestead 				= get_field('homestead');
			$tax_year 				= get_field('tax_year');
			$tax_amount 			= get_field('tax_amount');
			$assessment_balance 	= get_field('assessment_balance');
			$tax_with_assessment 	= get_field('tax_with_assessment');
			if(!empty($legal_description) || !empty($complexdevsub) || !empty($homestead) || !empty($tax_year) || !empty($tax_amount) || !empty($assessment_balance) || !empty($tax_with_assessment)){ ?>
				<div class="wpos-legal-block">
					<h2>Tax and Legal</h2>
					<table>
						<?php if(!empty($legal_description)){ ?>
							<tr><td><strong>Legal Description:</strong> <?php echo $legal_description; ?></td></tr>
						<?php } ?>
						<?php if(!empty($legal_descriptioncomplexdevsub)){ ?>
							<tr><td><strong>Complex/Dev/Sub:</strong> <?php echo $complexdevsub; ?></td></tr>
						<?php } ?>
						<?php if(!empty($homestead)){ ?>
							<tr><td><strong>Homestead:</strong> <?php echo $homestead; ?></td></tr>
						<?php } ?>
						<?php if(!empty($tax_year)){ ?>
							<tr><td><strong>Tax Year:</strong> <?php echo $tax_year; ?></td></tr>
						<?php } ?>
						<?php if(!empty($tax_amount)){ ?>
							<tr><td><strong>Tax Amount:</strong> <?php echo $tax_amount; ?></td></tr>
						<?php } ?>
						<?php if(!empty($assessment_balance)){ ?>
							<tr><td><strong>Assessment Balance:</strong> <?php echo $assessment_balance; ?></td></tr>
						<?php } ?>
						<?php if(!empty($tax_with_assessment)){ ?>
							<tr><td><strong>Tax With Assessment:</strong> <?php echo $tax_with_assessment; ?></td></tr>
						<?php } ?>
					</table>
				</div>
			<?php }

			$amenities 				= get_field('amenities');
			$amenities 				= join(', ', $amenities);
			$special_search 		= get_field('special_search');
			$special_search 		= join(', ', $special_search);
			$pool_description 		= get_field('_pool_description');
			$pool_description 		= join(', ', $pool_description);
			$basement_description 	= get_field('basement_description');
			$basement_description 	= join(', ', $basement_description);

			if(!empty($amenities) || !empty($special_search) || !empty($pool_description) || !empty($basement_description)){ ?>
				<div class="wpos-additional-info-block">
					<h2>Additional Information</h2>
					<table>
						<?php if(!empty($amenities)) { ?>
							<tr><td><strong>Amenties:</strong> <?php echo $amenities; ?></td></tr>
						<?php } ?>

						<?php if(!empty($special_search)) { ?>
							<tr><td><strong>Specail Search:</strong> <?php echo $special_search; ?></td></tr>
						<?php } ?>

						<?php if(!empty($pool_description)) { ?>
							<tr><td><strong>Pool Description:</strong> <?php echo $pool_description; ?></td></tr>
						<?php } ?>

						<?php if(!empty($basement_description)) { ?>
							<tr><td><strong>Basement Description:</strong> <?php echo $basement_description; ?></td></tr>
						<?php } ?>
					</table>
				</div>
			<?php } 

			$total_fireplaces 						= get_field('total_fireplaces');
			$number_of_fireplacestype_and_location 	= get_field('number_of_fireplacestype_and_location');
			$number_of_fireplacestype_and_location 	= join(', ', $number_of_fireplacestype_and_location);
			$appliances 							= get_field('appliances');
			$appliances 							= join(', ', $appliances);

			if(!empty($total_fireplaces) || !empty($number_of_fireplacestype_and_location) || !empty($appliances)){ ?>
				<div class="wpos-interior-block">
					<h2>Interior</h2>
					<table>
						<?php if(!empty($total_fireplaces)){ ?>
							<tr><td><strong>Number of Fireplaces:</strong> <?php echo $total_fireplaces; ?></td></tr>
						<?php } ?>

						<?php if(!empty($number_of_fireplacestype_and_location)){ ?>
							<tr><td><strong>Fireplace(s):</strong> <?php echo $number_of_fireplacestype_and_location; ?></td></tr>
						<?php } ?>

						<?php if(!empty($appliances)){ ?>
							<tr><td><strong>Appliances:</strong> <?php echo $appliances; ?></td></tr>
						<?php } ?>
					</table>
				</div>
			<?php }?>
			<?php

			//Bedrooms
			$bedroom1_level = get_field('bedroom1_level');
			$bedroom1_area 	=get_field('bedroom1_area');
			$bedroom2_level = get_field('bedroom2_level');
			$bedroom2_area 	=get_field('bedroom2_area');
			$bedroom3_level = get_field('bedroom3_level');
			$bedroom3_area 	=get_field('bedroom3_area');
			$bedroom4_level = get_field('bedroom4_level');
			$bedroom4_area 	=get_field('bedroom4_area');

			//Bathrooms
			$total_baths 		= get_field('total_baths');
			$full_baths 		= get_field('full_baths');
			$baths_34 			= get_field('34_baths');
			$baths_12 			= get_field('12_baths');
			$bath_description 	= get_field('bath_description');
			$bath_description 	= join(', ', $bath_description);

			//Rooms
			$living_rm_level 				= get_field('living_rm_level');
			$living_rm_area 				= get_field('living_rm_area');
			$dining_rm_level 				= get_field('dining_rm_level');
			$dining_rm_area 				= get_field('dining_rm_area');
			$dining_room_description 		= get_field('dining_room_description');
			$dining_room_description 		= join(', ', $dining_room_description);
			$family_rm_level 				= get_field('family_rm_level');
			$family_rm_area 				= get_field('family_rm_area');
			$family_room_characteristics 	= get_field('family_room_characteristics');
			$family_room_characteristics 	= join(', ', $family_room_characteristics);
			$kitchen_level 					= get_field('kitchen_level');
			$kitchen_area 					= get_field('kitchen_area');

			//Other rooms
			$extra_room_1 		= get_field('extra_room_1');
			$extra_room_1_level = get_field('extra_room_1_level');
			$extra_room_1_area 	= get_field('extra_room_1_area');
			$extra_room_2 		= get_field('extra_room_2');
			$extra_room_2_level = get_field('extra_room_2_level');
			$extra_room_2_area  = get_field('extra_room_2_area');
			$extra_room_3 		= get_field('extra_room_3');
			$extra_room_3_level = get_field('extra_room_3_level');
			$extra_room_3_area 	= get_field('extra_room_3_area');
			$extra_room_4 		= get_field('extra_room_4');
			$extra_room_4_level = get_field('extra_room_4_level');
			$extra_room_4_area 	= get_field('extra_room_4_area');

			if(!empty($bedroom1_level) || !empty($bedroom1_area) || !empty($bedroom2_level) || !empty($bedroom2_area) || !empty($bedroom3_level) || !empty($bedroom3_area) || !empty($bedroom4_level) || !empty($bedroom4_area) ||
			!empty($total_baths) || !empty($full_baths) || !empty($baths_34) || !empty($baths_12) || !empty($bath_description) ||
			!empty($living_rm_level) || !empty($living_rm_area) || !empty($dining_rm_level) || !empty($dining_rm_area) || !empty($dining_room_description) || !empty($family_rm_level) || !empty($family_rm_area) || !empty($family_room_characteristics) || !empty($kitchen_level) || !empty($kitchen_area) ||
			!empty($extra_room_1) || !empty($extra_room_1_level) || !empty($extra_room_1_area) || !empty($extra_room_2) || !empty($extra_room_2_level) || !empty($extra_room_2_area) || !empty($extra_room_3) || !empty($extra_room_3_level) || !empty($extra_room_3_area) || !empty($extra_room_4) || !empty($extra_room_4_level) || !empty($extra_room_4_area) 
			) {	?>
				<div class="wpos-all-rooms-block-wrap">
					<?php if(!empty($living_rm_level) || !empty($living_rm_area) || !empty($dining_rm_level) || !empty($dining_rm_area) || !empty($dining_room_description) || !empty($family_rm_level) || !empty($family_rm_area) || !empty($family_room_characteristics) || !empty($kitchen_level) || !empty($kitchen_area)) { ?>
						<div class="wpos-rooms-block-wrap wpos-all-rooms-block-cmn">
							<strong>Rooms</strong>
							<table>
								<?php if(!empty($living_rm_level) && !empty($living_rm_area)){ ?>
									<tr><td>Living Room: <?php echo $living_rm_area; ?>, <?php echo $living_rm_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($dining_rm_level) && !empty($dining_rm_area)){ ?>
									<tr><td>Living Room: <?php echo $living_rm_area; ?>, <?php echo $dining_rm_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($dining_room_description)){ ?>
									<tr><td>Living Room: <?php echo $dining_room_description; ?></td></tr>
								<?php } ?>

								<?php if(!empty($family_rm_area) && !empty($family_rm_level)){ ?>
									<tr><td>Living Room: <?php echo $family_rm_area  ?>, <?php echo $family_rm_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($family_room_characteristics)){ ?>
									<tr><td>Living Room: <?php echo $family_room_characteristics ?></td></tr>
								<?php } ?>

								<?php if(!empty($kitchen_level) && !empty($kitchen_area)){ ?>
									<tr><td>Living Room: <?php echo $kitchen_area ?>, <?php echo $kitchen_level; ?></td></tr>
								<?php } ?>
							</table>
						</div>
					<?php } ?>
					<?php if(!empty($bedroom1_level) || !empty($bedroom1_area) || !empty($bedroom2_level) || !empty($bedroom2_area) || !empty($bedroom3_level) || !empty($bedroom3_area) || !empty($bedroom4_level) || !empty($bedroom4_area)) { ?>
						<div class="wpos-bedrooms-block-wrap wpos-all-rooms-block-cmn">
							<strong>Bedrooms</strong>
							<table>
								<?php if(!empty($bedroom1_level) && !empty($bedroom1_area)){ ?>
									<tr><td>Bedroom 1: <?php echo $bedroom1_area; ?>, <?php echo $bedroom1_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($bedroom2_level) && !empty($bedroom2_area)){ ?>
									<tr><td>Bedroom 2: <?php echo $bedroom2_area; ?>, <?php echo $bedroom2_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($bedroom3_level) && !empty($bedroom3_area)){ ?>
									<tr><td>Bedroom 3: <?php echo $bedroom3_area; ?>, <?php echo $bedroom3_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($bedroom4_level) && !empty($bedroom4_area)){ ?>
									<tr><td>Bedroom 4: <?php echo $bedroom4_area; ?>, <?php echo $bedroom4_level; ?></td></tr>
								<?php } ?>
							</table>
						</div>
					<?php } ?>

					<?php if(!empty($total_baths) || !empty($full_baths) || !empty($baths_34) || !empty($baths_12) || !empty($bath_description)) { ?>
						<div class="wpos-bathrooms-block-wrap wpos-all-rooms-block-cmn">
							<strong>Bathrooms</strong>
							<table>
								<?php if(!empty($total_baths)){ ?>
									<tr><td>Total Bathrooms: <?php echo $total_baths; ?></td></tr>
								<?php } ?>
								<?php if(!empty($full_baths)){ ?>
									<tr><td>Full Bathrooms: <?php echo $full_baths; ?></td></tr>
								<?php } ?>
								<?php if(!empty($baths_34)){ ?>
									<tr><td>3/4 Bathrooms: <?php echo $baths_34; ?></td></tr>
								<?php } ?>
								<?php if(!empty($baths_12)){ ?>
									<tr><td>Half Bathrooms: <?php echo $baths_12; ?></td></tr>
								<?php } ?>
								<?php if(!empty($bath_description)){ ?>
									<tr><td>Bathroom: <?php echo $bath_description; ?></td></tr>
								<?php } ?>
							</table>
						</div>
					<?php } ?>

					<?php if(!empty($extra_room_1) || !empty($extra_room_1_level) || !empty($extra_room_1_area) || !empty($extra_room_2) || !empty($extra_room_2_level) || !empty($extra_room_2_area) || !empty($extra_room_3) || !empty($extra_room_3_level) || !empty($extra_room_3_area) || !empty($extra_room_4) || !empty($extra_room_4_level) || !empty($extra_room_4_area)){ ?>
						<div class="wpos-rooms-block-wrap wpos-all-rooms-block-cmn">
							<strong>Other Rooms</strong>
							<table>
								<?php if(!empty($extra_room_1) && !empty($extra_room_1_level) && !empty($extra_room_1_area)) { ?>
									<tr><td><?php echo $extra_room_1; ?>: <?php echo $extra_room_1_area; ?>, <?php echo $extra_room_1_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($extra_room_2) && !empty($extra_room_2_level) && !empty($extra_room_2_area)) { ?>
									<tr><td><?php echo $extra_room_2; ?>: <?php echo $extra_room_2_area; ?>, <?php echo $extra_room_2_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($extra_room_3) && !empty($extra_room_3_level) && !empty($extra_room_3_area)) { ?>
									<tr><td><?php echo $extra_room_3; ?>: <?php echo $extra_room_3_area; ?>, <?php echo $extra_room_3_level; ?></td></tr>
								<?php } ?>

								<?php if(!empty($extra_room_4) && !empty($extra_room_4_level) && !empty($extra_room_4_area)) { ?>
									<tr><td><?php echo $extra_room_4; ?>: <?php echo $extra_room_4_area; ?>, <?php echo $extra_room_4_level; ?></td></tr>
								<?php } ?>
							</table>
						</div>
					<?php } ?>
				</div>
			<?php } 

			$heat 					= get_field('heat');
			$heat 					= join(', ', $heat);
			if(!empty($heat)){ ?>
				<div class="wpos-water-block">
					<h2>Heating</h2>
					<table>
						<tr><td><strong>Heat: </strong><?php echo $heat; ?></td></tr>
					</table>
				</div>
			<?php }

			$ac 					= get_field('ac');
			$ac 					= join(', ', $ac);
			if(!empty($ac)){ ?>
				<div class="wpos-water-block">
					<h2>Air Conditioning</h2>
					<table>
						<tr><td><strong>A/C: </strong><?php echo $ac; ?></td></tr>
					</table>
				</div>
			<?php }

			$water 					= get_field('water');
			$water 					= join(', ', $water);
			if(!empty($water)){ ?>
				<div class="wpos-water-block">
					<h2>Water</h2>
					<table>
						<tr><td><strong>Water: </strong><?php echo $water; ?></td></tr>
					</table>
				</div>
			<?php }

			$sewer 					= get_field('sewer');
			$sewer 					= join(', ', $sewer);
			if(!empty($sewer)){ ?>
				<div class="wpos-water-block">
					<h2>Sewer</h2>
					<table>
						<tr><td><strong>Sewer: </strong><?php echo $sewer; ?></td></tr>
					</table>
				</div>
			<?php }

			$lakewaterfront = get_field('lakewaterfront');
			$lakewaterfront = join(', ', $lakewaterfront);
			if(!empty($lakewaterfront)){ ?>
				<div class="wpos-water-block">
					<h2>Waterfront</h2>
					<table>
						<tr><td><strong>Lake/Waterfront: </strong><?php echo $lakewaterfront; ?></td></tr>
					</table>
				</div>
			<?php } 
			$association_fee_includes 	= get_field('association_fee_includes');
			$association_fee_includes 	= join(', ', $association_fee_includes);
			$townhome_characteristics 	= get_field('townhome_characteristics');
			$townhome_characteristics 	= join(', ', $townhome_characteristics);
			$assocation_restrictions 	= get_field('assocation_restrictions');
			$assocation_restrictions 	= join(', ', $assocation_restrictions);
			$townhome_shared_amenities 	= get_field('townhome_shared_amenities');
			$townhome_shared_amenities 	= join(', ', $townhome_shared_amenities);

			if(!empty($association_fee_includes) || !empty($townhome_characteristics) || !empty($assocation_restrictions) || !empty($townhome_shared_amenities)){ ?>
				<div class="wpos-association-block">
					<h2>Association</h2>
					<table>
						<?php if(!empty($association_fee_includes)){ ?>
							<tr><td><strong>Association Fee Includes:</strong> <?php echo $association_fee_includes; ?></td></tr>
						<?php } ?>

						<?php if(!empty($townhome_characteristics)){ ?>
							<tr><td><strong>Townhome Characteristics:</strong> <?php echo $townhome_characteristics;  ?></td></tr>
						<?php } ?>

						<?php if(!empty($assocation_restrictions)){ ?>
							<tr><td><strong>Assocation Restrictions:</strong> <?php echo $assocation_restrictions; ?></td></tr>
						<?php } ?>

						<?php if(!empty($townhome_shared_amenities)){ ?>
							<tr><td><strong>Townhome Shared Amenities:</strong> <?php echo $townhome_shared_amenities; ?></td></tr>
						<?php } ?>
					</table>
				</div>
			<?php } ?>
		</div>
		<div style="clear:both;"></div>
	<?php endwhile; ?>
<?php endif; ?>

<?php wp_reset_postdata();?>
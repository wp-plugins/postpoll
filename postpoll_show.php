<?php
			extract(shortcode_atts(array(
			'pollid' => ' '
			), $atts));
			$poll_ID = $atts['pollid'];

			$entradas_json = get_post_meta( $poll_ID, 'poll_options', true );
			if (isset($entradas_json)) {
						$entradas = json_decode($entradas_json);
			}
			$camps_json = get_post_meta( $poll_ID, 'camps_options', true );
			if (isset($camps_json)) {
						$camps = json_decode($camps_json);
			}
			$sendemail = get_post_meta( $poll_ID, 'sendemail_options', true );
			$message = get_post_meta( $poll_ID, 'message_options', true );
			$anonimousvoter = get_post_meta( $poll_ID, 'anonimousvoter_options', true );
			$showtype = get_post_meta($poll_ID, 'typeofselect_options', true);
			$showresult = get_post_meta($poll_ID, 'showresult', true);
			$onlyuser = get_post_meta($poll_ID, 'onlyuser', true);
			$savecookie = get_post_meta($poll_ID, 'savecookie', true);
			$useimage=get_post_meta($poll_ID, 'useimage', true);
			if (isset($_COOKIE['voted-'.$poll_ID]))
                $voted = $_COOKIE['voted-'.$poll_ID];
            else 
            	$voted = 0;
			?>

			<div class="postpoll" <?php if (isset($onlyuser) && $onlyuser==1 && !is_user_logged_in()) echo "style=\"display: none\""; ?>>
			<div class="postpollmess" id="postpollmess-<?php echo "$poll_ID"; ?>" <?php if ($voted!=1) echo "style=\"display: none\""; ?>>
				<?php
				if ($showresult==1) {
						if (isset($entradas)) {
							echo "<ul>";
							foreach($entradas as $key) {
								$name = get_the_title( $key );
								$votes = get_post_meta($key, 'postpoll-votes-'.$poll_ID, true);
								if (empty($votes))
									$votes = "0";
							?>	<li>
								<div class="media outcontainer" <?php if ($useimage!=1) echo "style=\"heigth:auto\""; ?>> 
											<?php
												if ($useimage==1) {
													$thumb_id = get_post_thumbnail_id($key);
													$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
													?>
														<div class="media-left pull-left img-container">
															<img src="<? echo $thumb_url[0]; ?>">
														</div>
												<?php
												}
												?>
							<div class="media-body content-cntr" >
                            <div class="titlejust" <?php if ($useimage!=1) echo "style=\"margin-left:0px\""; ?> ><?php echo $name; ?>- <span id="post-<?php echo $key; ?>"><?php echo $votes; ?></span></div>
							</div>
						</div>
							</li>
							<?php }
							echo "</ul>";
						}
				}
				?>
				<div id="thankstext" style="display:none;"><?php _e('Thanks for your Vote','postpoll'); ?></div>
				<div id="errortext" style="display:none;"><?php _e('Sorry, your vote could not be added','postpoll'); ?></div>
			</div>
			<div class="postpoll" id="postpoll-<?php echo "$poll_ID"; ?>" <?php if (isset($voted) && $voted==1) echo "style=\"display: none\""; ?>>
				<form class="form3" id="form3" method="post" action="">

					<?php 
						if ($showtype=='1') {
										if (isset($entradas)) {
											?> <select id="vote_poll" name="poll"> <?php
											foreach ($entradas as $key) {
												$name = get_the_title( $key ); ?>
														<option value="<?php echo $key; ?>"><?php echo $name = get_the_title( $key ); ?></option> 
												<?php
											}
											?> </select>
											<input type="hidden" name="pollid" id="pollid" value="<?php echo $poll_ID; ?>">
											<input type="hidden" name="savecookie" id="savecookie" value="<?php echo $savecookie; ?>">
											<input type="hidden" name="showtype" id="showtype" value="<?php echo $showtype; ?>">
											<input type="submit" id="user-vote" class="button-primary" value="<?php esc_attr_e('Vote', 'postpoll') ?>" />  <?php
										}
						} else if ($showtype=='2') {
										if (isset($entradas)) {
											foreach ($entradas as $key) {
												$name = get_the_title( $key ); 
												?> 	<div class="media outcontainer" <?php if ($useimage!=1) echo "style=\"height:auto\""; ?>> 
												<?php
												if ($useimage==1) {
													$thumb_id = get_post_thumbnail_id($key);
													$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
													?>
														<div class="media-left pull-left img-container">
															<img src="<? echo $thumb_url[0]; ?>">
														</div>
												<?php
												}
												?>
														<div class="media-body content-cntr">
														<input type="radio" <?php if ($useimage!=1) echo "style=\"margin-left:0px\""; ?> id="vote_poll" value="<?php echo $key; ?>" class="radio_button media-heading" name="poll"><?php echo $name = get_the_title( $key ); ?><br /> 
														</div>
													</div>											
												<?php
											}
											?>
											<input type="hidden" name="pollid" id="pollid" value="<?php echo $poll_ID; ?>">
											<input type="hidden" name="savecookie" id="savecookie" value="<?php echo $savecookie; ?>">
											<input type="hidden" name="showtype" id="showtype" value="<?php echo $showtype; ?>">
											<input type="submit" id="user-vote" class="button-primary" value="<?php esc_attr_e('Vote', 'postpoll') ?>" />  <?php
										}
						} elseif ($showtype=='3') {
										if (isset($entradas)) {
											foreach ($entradas as $key) {
												$name = get_the_title( $key );
												?> 	<div class="media outcontainer" <?php if ($useimage!=1) echo "style=\"height:auto\""; ?>> 
												<?php
												if ($useimage==1) {
													$thumb_id = get_post_thumbnail_id($key);
													$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
													?>
														<div class="media-left pull-left img-container">
															<img src="<? echo $thumb_url[0]; ?>">
														</div>
												<?php
												}
												?>
														<div class="media-body content-cntr">
														<input type="checkbox" <?php if ($useimage!=1) echo "style=\"margin-left:0px\""; ?> id="vote_poll" value="<?php echo $key; ?>" class="checkbox media-heading" name="poll[]"><?php echo $name = get_the_title( $key ); ?><br /> 
														</div>
													</div>													
												<?php
											}
											?>
											<input type="hidden" name="pollid" id="pollid" value="<?php echo $poll_ID; ?>">
											<input type="hidden" name="savecookie" id="savecookie" value="<?php echo $savecookie; ?>">
											<input type="hidden" name="showtype" id="showtype" value="<?php echo $showtype; ?>">
											<input type="submit" id="user-vote" class="button-primary" value="<?php esc_attr_e('Vote', 'postpoll') ?>" />  <?php
										}
						}
										?>
						<?php 
						wp_nonce_field( 'votingsystem', 'data-nonce' );
						?>
			</form>
		</div>
	</div>
</p>
<?php

?>

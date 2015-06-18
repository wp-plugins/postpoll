					<div class="wrap"> <?php
					$poll_ID = $_REQUEST['pollid'];
					if (!$poll_ID) wp_die(__('You have to select a Poll to Edit'), 'Error', array('back_link'=>true));
					echo "<h2>".__('Poll')." ".get_the_title($poll_ID)."</h2>";
					echo "<h4>".__('Select the post(s) to be included on this poll')."</h4>";
					if (!isset($poll_ID)) {
						wp_redirect('/wp-admin/admin.php?page=Postpoll-plugin');
					} 
					$hidden_field_name = 'wp_postpoll_ppl_hidden';

					if ( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == '3231lkJKH23') {
						$entradas=clean_scriptsppl($_POST['entradas']);
						$anonimousvoter=clean_scriptsppl($_POST['anonimousvoter']);
						$camps=clean_scriptsppl($_POST['camps']);
						$sendemail=clean_scriptsppl($_POST['sendemail']);
						$message=clean_scriptsppl($_POST['message']);
						$showtype=clean_scriptsppl($_POST['typeofselect']);
						$showresult=clean_scriptsppl($_POST['showresult']);
						$savecookie=clean_scriptsppl($_POST['savecookie']);
						$onlyuser=clean_scriptsppl($_POST['onlyuser']);
						$entradas_json = json_encode($entradas);
						$camps_json = json_encode($camps);
								if (!get_post_meta($poll_ID,'poll_options'))
								$subir = add_post_meta($poll_ID, 'poll_options', $entradas_json, true);	
								else 
								$subir = update_post_meta($poll_ID, 'poll_options', $entradas_json);
								if (!get_post_meta($poll_ID,'anonimousvoter_options'))
								$subir2 = add_post_meta($poll_ID, 'anonimousvoter_options', $showresult, true);	
								else 
								$subir2 = update_post_meta($poll_ID, 'anonimousvoter_options', $anonimousvoter);	
								if (!get_post_meta($poll_ID,'camps_options'))
								$subir3 = add_post_meta($poll_ID, 'camps_options', $camps_json, true);	
								else 
								$subir3 = update_post_meta($poll_ID, 'camps_options', $camps_json);
								if (!get_post_meta($poll_ID,'sendemail_options'))
								$subir4 = add_post_meta($poll_ID, 'sendemail_options', $sendemail, true);	
								else 
								$subir4 = update_post_meta($poll_ID, 'sendemail_options', $sendemail);	
								if (!get_post_meta($poll_ID,'message_options'))
								$subir5 = add_post_meta($poll_ID, 'message_options', $message, true);	
								else 
								$subir5 = update_post_meta($poll_ID, 'message_options', $message);
								if (!get_post_meta($poll_ID,'typeofselect_options'))
								$subir6 = add_post_meta($poll_ID, 'typeofselect_options', $showtype, true);	
								else 
								$subir6 = update_post_meta($poll_ID, 'typeofselect_options', $showtype);
								if (!get_post_meta($poll_ID,'showresult'))
								$subir7 = add_post_meta($poll_ID, 'showresult', $entradas_json, true);	
								else 
								$subir7 = update_post_meta($poll_ID, 'showresult', $showresult);	
								if (!get_post_meta($poll_ID,'showresult'))
								$subir8 = add_post_meta($poll_ID, 'onlyuser', $onlyuser, true);	
								else 
								$subir8 = update_post_meta($poll_ID, 'onlyuser', $onlyuser);
								if (!get_post_meta($poll_ID,'savecookie'))
								$subir9 = add_post_meta($poll_ID, 'savecookie', $savecookie, true);	
								else 
								$subir9 = update_post_meta($poll_ID, 'savecookie', $savecookie);																														
					if (($subir && !isset($subir['error'])) || ($subir2 && !isset($subir2['error'])) || ($subir3 && !isset($subir3['error'])) || ($subir4 && !isset($subir4['error'])) || ($subir5 && !isset($subir5['error'])) || ($subir6 && !isset($subir6['error'])) || ($subir7 && !isset($subir7['error'])) || ($subir8 && !isset($subir8['error'])) || ($subir9 && !isset($subir9['error']))) {
							?>
					            <div class="updated"><p><strong><?php _e('settings saved.'); ?></strong></p></div>
					        <?php
					        } else {
							?>
					            <div class="error"><p><strong><?php _e('Error, pls try again later.'); ?></strong></p></div>
					        <?php
					        }
					}

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
					$savecookie=get_post_meta($poll_ID, 'savecookie', true);
					$onlyuser=get_post_meta($poll_ID, 'onlyuser', true);
					?>
					<form class="form2" method="post" action="">
					<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="3231lkJKH23">
					<table id="form2" class="wp-list-table widefat fixed posts">
						<tbody>
							<tr>
								<td>
					<?php 
					if (isset($entradas)) {
						foreach ($entradas as $key) {
							$name = get_the_title( $key ); ?>
							<div id="selected-id-<?php echo $key; ?>">
								<label for="selectedid-<? echo $key; ?>"><?php _e('Post Selected'); ?></label>
									<input type="hidden" id="selectedid-<? echo $key; ?>" name="entradas[]" value="<?php echo $key; ?>"/> 
									 <strong><? echo $name; ?></strong>
									  <a href="#" onclick="delete_campo('<?php echo $key; ?>')" class="selecteddel" id="selectedid-<?php echo $key; ?>"><?php _e('Delete');?></a>
							</div>
							<?php
						}
					}
					?>
							</td>
							<td>
								<label for="page_id"><?php _e('Select here to add a post to the list');?></label>
								<select name="page_id[]" id="page_id"> <?php 

									global $post; 
									$args = array( 'numberposts' => -1); 
									$posts = get_posts($args); 
									foreach( $posts as $post ) :
										if (!in_array($post->ID, $entradas)) {
										setup_postdata($post); ?>                
										<option value="<? echo $post->ID; ?>"><?php the_title(); ?></option> 
									<?php }
									endforeach; ?> 
								</select>
							</td>
							</tr>
						</tbody>
					</table> 
					<label for="typeofselect"><strong><?php _e('Select how you want the Poll to be show'); ?></strong></label></br>
					<table id="selector" class="wp-list-table widefat fixed posts">
						<thead>
					<th><input type="radio" id="radio-button" class="radio-button" name="typeofselect" value="1" <?php if ($showtype=='1' || empty($showtype)) echo "checked=\"checked\""; ?>> <?php _e('Type Selector (dropdown list)'); ?></th>
					<th><input type="radio" id="radio-button" class="radio-button" name="typeofselect" value="2" <?php if ($showtype=='2') echo "checked=\"checked\""; ?>> <?php _e('Type Radio (only one option)'); ?></th>
					<th><input type="radio" id="radio-button" class="radio-button" name="typeofselect" value="3" <?php if ($showtype=='3') echo "checked=\"checked\""; ?>> <?php _e('Type Multiple options (allow to select more than one option)'); ?></th>
						</thead>
						<tbody>
							<tr>
								<td colspan="3">
									<?php _e('This is how your Poll will be show'); ?>
								</td>
							</tr>
							<tr>
								<td>
									<?php 
										if (isset($entradas)) {
											?> <select> <?php
											foreach ($entradas as $key) {
												$name = get_the_title( $key ); ?>
														<option value="#"><?php echo $name = get_the_title( $key ); ?></option> 
												<?php
											}
											?> </select><input type="submit" class="button-primary example-button" id="example-button" value="<?php esc_attr_e('Vote') ?>" disabled="disabled"/>  <?php
										}
										?>
								</td>
								<td>
									<?php 
										if (isset($entradas)) {
											foreach ($entradas as $key) {
												$name = get_the_title( $key ); ?>
														<input type="radio" value="#" class="radio_button" name="example"><?php echo $name = get_the_title( $key ); ?><br /> 
												<?php
											}
											?><input type="submit" class="button-primary example-button" id="example-button" value="<?php esc_attr_e('Vote') ?>" disabled="disabled"/>  <?php
										}
										?>
								</td>
								<td>
									<?php 
										if (isset($entradas)) {
											foreach ($entradas as $key) {
												$name = get_the_title( $key ); ?>
														<input type="checkbox" value="#" class="checkbox" name="example"><?php echo $name = get_the_title( $key ); ?><br /> 
												<?php
											}
											?><input type="submit" class="button-primary example-button" id="example-button" value="<?php esc_attr_e('Vote') ?>" disabled="disabled" />  <?php
										}
										?>
								</td>
							</tr>
						</tbody>
					</table>
					<div id="form-group">
						<p>
							<input type="checkbox" id="showresult" name="showresult" value="1" <?php if ($showresult==1) echo "checked=\"checked\""; ?>><?php _e('Show results to user after vote?'); ?><br />
						</p>
						<p>
							<input type="checkbox" id="savecookie" name="savecookie" value="1" <?php if ($savecookie==1) echo "checked=\"checked\""; ?>><?php _e('Save a cookie to avoid more than one vote per visit?'); ?><br />
						</p>
						<p>
							<input type="checkbox" id="onlyuser" name="onlyuser" value="1" <?php if ($onlyuser==1) echo "checked=\"checked\""; ?>><?php _e('Only logged users can vote?'); ?><br />
						</p>
					<!-- For next version  <p>
						<input type="checkbox" id="anonimousvoter" name="anonimousvoter" value="1" <?php if ($anonimousvoter==1) echo "checked=\"checked\""; ?>><?php _e('Check to get voters data?'); ?><br />
							<div id="formemail" class="formemail" <?php if ($anonimousvoter!=1) echo "style=\"display: none\""; ?>>
										<input type="checkbox" name="camps[]" value="1" <?php if (in_array('1', $camps)) echo "checked=\"checked\""; ?>><?php _e('Full Name'); ?><br/>
										<input type="checkbox" name="camps[]" value="2" <?php if (in_array('2', $camps)) echo "checked=\"checked\""; ?>><?php _e('E-mail Adresse'); ?><br/>
										<input type="checkbox" name="camps[]" value="3" <?php if (in_array('3', $camps)) echo "checked=\"checked\""; ?>><?php _e('Adresse'); ?><br/>
										<input type="checkbox" name="camps[]" value="4" <?php if (in_array('4', $camps)) echo "checked=\"checked\""; ?>><?php _e('Comments'); ?><br/>
							</div>
					</p> 
					<p>
						<input type="checkbox" id="sendemail" name="sendemail" value="1" <?php if ($sendemail==1) echo "checked=\"checked\""; ?>><?php _e('Send email to voter'); ?><br />
							<div id="textemail" class="sendemail" <?php if ($sendemail!=1) echo "style=\"display: none\""; ?>>
										<label for="message"><?php _e('Enter the confirmation Message'); ?></label><br />
										<textarea rows="4" cols="50" name="message" id="message" placeholder="<?php _e('Enter text here...'); ?>"><?php if (isset($message)) echo $message; ?></textarea>
					</p>
					</div> -->
					<p> 
						<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
					</p>
				</p>
					</div> 
				    </form>
</div> <!-- End Wrap -->
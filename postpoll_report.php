			<div class="postpoll" id="postpoll">
				<form class="form4" id="form4" method="post" action="">
					<p>
            				<label for="postpoll_pollid"><?php _e('Pls select the poll to view results','postpoll'); ?></label>
            				<select name="postpoll_pollid" id="postpoll_pollid">
				                <?php 
				                    $argus = array('post_type' => 'postpoll-poll');
        							$polls = get_posts($argus);
				                    foreach ($polls as $poll) {
				                        echo "<option value=\"$poll->ID\">$poll->post_title</option>";
				                    }
				                ?>
            				</select>
         			</p>
         		    <input type="submit" id="show-resutls" class="button-primary" value="<?php esc_attr_e('Show', 'postpoll') ?>" />
         		</form>
			<?php
			if (isset($_POST['postpoll_pollid'])) {
				$poll_ID = $_POST['postpoll_pollid'];

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
			?>
			<div class="postpollmess" id="postpollmess">
				<?php
				if (isset($entradas)) {
					echo "<ul>";
					foreach($entradas as $key) {
						$name = get_the_title( $key );
						$votes = get_post_meta($key, 'postpoll-votes', true);
						echo "<li>". $name ." - <span id=\"post-".$key."\">". $votes ."</span></li>";
					}
					echo "</ul>";
				}
				?>
			</div>
<?php
			}

?>

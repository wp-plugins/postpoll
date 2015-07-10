	<?php if (!current_user_can('manage_options')){
        wp_die( _e('You are not authorized to view this page.','postpoll') );
    }
    				?>
    				<div class="wrap">
    				<div id="welcome-panel" class="welcome-panel">
    					<div class="welcome-panel-content">
    						<div class="welcome-panel-column-container">
    				<h1><?php _e('Post poll','postpoll'); ?></h1>
			        <p><span><?php _e('by Eric Zeidan','postpoll'); ?></span><p>
			        		</div>
			        	</div>
			        </div>
			        <?php

			        // create a new poll
    					$opt_name_poll = 'wp_ppl_pollname';
    					$opt_desc_poll = 'wp_ppl_description';
    					$data_field_name_poll = 'wp_postpoll_ppl_pollname';
    					$data_field_desc_poll = 'wp_postpoll_ppl_polldescription';
    					$hidden_field_name = 'wp_postpoll_ppl_hidden';

    					if ( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == '23hH2098KK_12') {
    						// echo "<script>alert('hola');</script>";
    						$post_poll_title = $_POST[$data_field_name_poll];
    						$post_poll_desc  = $_POST[$data_field_desc_poll];
    						$user_ID = get_current_user_id();
    						$my_post = array(
							  'post_title'    => $post_poll_title,
							  'post_content'  => $post_poll_desc,
							  'post_status'   => 'publish',
							  'post_author'   => $user_ID,
							  'post_type' => 'postpoll-poll'
							);
							$poll_id = wp_insert_post( $my_post );
							if ($poll_id>0) {
							?>
					            <div class="updated"><p><strong><?php _e('settings saved.','postpoll'); ?></strong></p></div>
					        <?php
					        } else {
							?>
					            <div class="error"><p><strong><?php _e('Error, pls try again later.','postpoll'); ?></strong></p></div>
					        <?php
					        }
					    }
							?>
								<h4><?php _e('Create a New Poll','postpoll'); ?></h4>
								<form name="form1" method="post" action="">
					            <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="23hH2098KK_12">
					            <p>

					                <label for="<?php echo $data_field_name_poll; ?>"><?php _e('Poll Name: ','postpoll' ); ?></label><br />
					                <input type="text" id="<?php echo $data_field_name_poll; ?>" name="<?php echo $data_field_name_poll; ?>" size="60" />
					            </p>
					            <p>
					                <label for="<?php echo $data_field_desc_poll; ?>"><?php _e('Poll Description: ','postpoll' ); ?></label><br />
					                <input type="text" id="<?php echo $data_field_desc_poll; ?>" name="<?php echo $data_field_desc_poll; ?>" size="120" />
					            </p>
					            <p class="submit">
                				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'postpoll') ?>" />
            					</p>
            				<?php

			        // Generate the List of Polls
			        $args = array('post_type' => 'postpoll-poll');
			        $polls = get_posts($args); ?>
					<table class="wp-list-table widefat fixed posts">
						<thead>
							<th scope="col" class="manage-column column-id"><?php _e('Poll ID','postpoll'); ?></th>
							<th scope="col" class="manage-column column-title"><?php _e('Poll Title','postpoll'); ?></th>
							<th scope="col" class="manage-column column-description"><?php _e('Poll Description','postpoll'); ?></th>
							<th scope="col" class="manage-column column-shortcode" colspan="2"><?php _e('Poll Shortcode','postpoll'); ?></th>
							</thead>
							<tbody>
			        <?php
			        foreach ($polls as $poll) {
			        	echo "<tr><td>". $poll->ID ."</td>";
			        	echo "<td class=\"title column-title\">". $poll->post_title;
			        	?>
			        	<div class="row-actions">
			        		<span class="edit"><a href="?page=Postpoll-edit&pollid=<?php echo $poll->ID;?>"><?php _e('Edit','postpoll'); ?></a>
			        		</span>
			        	</div>
			        	</td>
			        	<?php
			        	echo "<td>". $poll->post_content . "</td>";
			        	echo "<td colspan=\"2\"><input type=\"text\" onfocus=\"this.select();\" readonly=\"readonly\" size=\"35\" value=\"[postpollshow pollid=$poll->ID]\" class=\"shortcode-in-list-table wp-ui-text-highlight code\"></td></tr>";

			        }
			            echo "</tbody></table>";	
echo "</div>";
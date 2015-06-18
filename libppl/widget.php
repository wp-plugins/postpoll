<?php
 
class postpoll_widget extends WP_Widget {
 
    function postpoll_widget(){
        // Constructor del Widget
        $widget_ops = array('classname' => 'postpoll_widget', 'description' => "Show Post poll inside a Widget" );
        $this->WP_Widget('postpoll_widget', "Post Poll Widget", $widget_ops);
    }
 
    function widget($args,$instance){
        // Contenido del Widget que se mostrará en la Sidebar
        echo $before_widget;  

        $poll_ID = $instance["postpoll_pollid"];
        $post_title = get_the_title($poll_ID);

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
            if (isset($_COOKIE['voted']))
                $voted = $_COOKIE['voted'];
            ?>
            <aside id='postpoll_widget' class='widget postpoll_widget' <?php if (isset($onlyuser) && $onlyuser==1) echo "style=\"display: none\""; ?>>
                <?php
                if ($showresult==1) {
                ?>    
                        <h3 class='widget-title'><?php echo $post_title; ?></h3>
                <?php } ?>
            <div class="postpollmess" id="postpollmess" <?php if ($voted!=1) echo "style=\"display: none\""; ?>>
                <?php
                if ($showresult==1) {
                        if (isset($entradas)) {
                            echo "<ul>";
                            foreach($entradas as $key) {
                                $name = get_the_title( $key );
                                $votes = get_post_meta($key, 'postpoll-votes-'.$poll_ID, true);
                                echo "<li>". $name ." - <span id=\"post-".$key."\">". $votes ."</span></li>";
                            }
                            echo "</ul>";
                        }
                }
                ?>
            </div>
            <div class="postpoll" id="postpoll" <?php if (isset($voted) && $voted==1) echo "style=\"display: none\""; ?>>
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
                                            <input type="submit" id="user-vote" class="button-primary" value="<?php esc_attr_e('Vote') ?>" />  <?php
                                        }
                        } else if ($showtype=='2') {
                                        if (isset($entradas)) {
                                            foreach ($entradas as $key) {
                                                $name = get_the_title( $key ); ?>
                                                        <input type="radio" id="vote_poll" value="<?php echo $key; ?>" class="radio_button" name="poll"><?php echo $name = get_the_title( $key ); ?><br /> 
                                                <?php
                                            }
                                            ?>
                                            <input type="hidden" name="pollid" id="pollid" value="<?php echo $poll_ID; ?>">
                                            <input type="hidden" name="savecookie" id="savecookie" value="<?php echo $savecookie; ?>">                                            
                                            <input type="hidden" name="showtype" id="showtype" value="<?php echo $showtype; ?>">
                                            <input type="submit" id="user-vote" class="button-primary" value="<?php esc_attr_e('Vote') ?>" />  <?php
                                        }
                        } elseif ($showtype=='3') {
                                        if (isset($entradas)) {
                                            foreach ($entradas as $key) {
                                                $name = get_the_title( $key ); ?>
                                                        <input type="checkbox" id="vote_poll" value="<?php echo $key; ?>" class="checkbox" name="poll"><?php echo $name = get_the_title( $key ); ?><br /> 
                                                <?php
                                            }
                                            ?>
                                            <input type="hidden" name="pollid" id="pollid" value="<?php echo $poll_ID; ?>">
                                            <input type="hidden" name="savecookie" id="savecookie" value="<?php echo $savecookie; ?>">                                            
                                            <input type="hidden" name="showtype" id="showtype" value="<?php echo $showtype; ?>">
                                            <input type="submit" id="user-vote" class="button-primary" value="<?php esc_attr_e('Vote') ?>" />  <?php
                                        }
                        }
                                        ?>
                        <?php 
                        wp_nonce_field( 'votingsystem', 'data-nonce' );
                        ?>
            </form>
        </div>
                </aside>
        <?php
        echo $after_widget;
    }
 
    function update($new_instance, $old_instance){
        // Función de guardado de opciones  
        $instance = $old_instance;
        $instance["postpoll_pollid"] = strip_tags($new_instance["postpoll_pollid"]);
        // Repetimos esto para tantos campos como tengamos en el formulario.
        return $instance;      
    }
 
    function form($instance){
        // Formulario de opciones del Widget, que aparece cuando añadimos el Widget a una Sidebar
        $argus = array('post_type' => 'postpoll-poll');
        $polls = get_posts($argus);
         ?>
         <p>
            <label for="<?php echo $this->get_field_id('postpoll_pollid'); ?>"><?php _e('Select which poll to show'); ?></label>
            <select name="<?php echo $this->get_field_name('postpoll_pollid'); ?>" id="<?php echo $this->get_field_id('postpoll_pollid'); ?>">
                <?php 
                    foreach ($polls as $poll) {
                        echo "<option value=\"$poll->ID\""; 
                        if (esc_attr($instance["postpoll_pollid"])==$poll->ID)
                        echo "selected=\"selected\"";
                        echo ">$poll->post_title</option>";
                    }
                ?>
            </select>
         </p>
        <?php
    }    
} 
 
?>
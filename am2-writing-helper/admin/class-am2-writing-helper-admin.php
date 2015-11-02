<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AM2_Writing_Helper
 * @subpackage AM2_Writing_Helper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AM2_Writing_Helper
 * @subpackage AM2_Writing_Helper/admin
 * @author     Your Name <email@example.com>
 */
class AM2_Writing_Helper_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $am2_writing_helper    The ID of this plugin.
     */
    private $am2_writing_helper;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    private $current_user;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $am2_writing_helper       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($am2_writing_helper, $version) {
        
        $this->am2_writing_helper = $am2_writing_helper;
        $this->version = $version;        
        
        add_action( 'init', array( $this, 'setup_plugin' ) );
        add_action( "wp_ajax_{$this->am2_writing_helper}_send_invites", array( $this, 'send_invites' ) );
        
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save'));
    }
    
    public function setup_plugin(){        
        global $current_user;
        $this->current_user = $current_user;                
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type) {
        $post_types = array('post', 'page');     //limit meta box to certain post types
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                    'am2_writing_helper'
                    , __('AM2 Writing Helper', 'am2-writing-helper')
                    , array($this, 'render_meta_box_content')
                    , $post_type
                    , 'advanced'
                    , 'high'
            );
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id) {

        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        /*if (!isset($_POST['myplugin_inner_custom_box_nonce']))
            return $post_id;

        $nonce = $_POST['myplugin_inner_custom_box_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'myplugin_inner_custom_box'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        //// OK, its safe for us to save the data now. 

        // Sanitize the user input.
        $mydata = sanitize_text_field($_POST['am2_review_emails']);

        // Update the meta field.
        update_post_meta($post_id, '_my_meta_value_key', $mydata);*/
    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post) {   
                

        // Add an nonce field so we can check for it later.
        //wp_nonce_field('am2_writing_helper_box', 'am2_writing_helper_box_nonce');
        
        ?>
        <div id="invitetoshare">
            <p>
                <strong>
                    Get feedback on this draft before publishing						</strong>
            </p>

            <p class="invitetext">
                <label for="invitelist">
                    Enter email addresses of people you would like to get feedback from:						</label>
            </p>
            <textarea id="invitelist" rows="2" placeholder="bob@example.org, sarah@example.org" class="first-focus"></textarea>

            <input type="submit" id="add-request" value="Send Requests" class="button-secondary" style="display: none;">
            <a class="customize" href="" style="display: none;">Customize the message</a>

            <div id="modify-email" style="">                
                <textarea class="customize" cols="80" rows="8"><?php
                echo 
                "Hi,\n\n". 
                "I started writing a new draft titled " . get_the_title() . " and would love to get your feedback. I plan on publishing it shortly.\n\n".
                "Please leave your feedback here:\n".
                "{{feedback-link}}\n\n".
                "Title: " . get_the_title() . "\n".
                "Beginning: " . get_the_excerpt() . "\n".
                "Read more: {{feedback-link}}" ."\n".
                "Thanks,\n".
                $this->current_user->display_name . " (".$this->current_user->user_email.")";
                ?></textarea>
                <br>
                <input type="hidden" value="<?php echo $post->ID;?>" name="am2_current_post_id" />
                <input type="button" id="add-request-custom" value="Send Requests" class="button-secondary">
                &nbsp;
                <!--<a class="cancel" href="#">Cancel</a>-->
            </div>

            <!--<div id="df-share-link-p">
                <p>or get a share link without sending an email</p>
                <div id="df-getting-link" style="display:none">
                    <img src="https://s1.wp.com/wp-content/mu-plugins/writing-helper/i/ajax-loader.gif" alt="Loading">
                    Getting a link...						</div>
                <a class="button" id="df-share-link" data-post-id="7">
                    Get a link						</a>
            </div>-->
        </div>

        <?php
    }
    
    public function send_invites( $data )
    {
        $nonce = $_POST['am2WritingHelperNonce'];
 
        // check to see if the submitted nonce matches with the
        // generated nonce we created earlier
        if ( ! wp_verify_nonce( $nonce, 'am2-writing-helper-nonce' ) ){
            exit ( 'Busted!');
        }            
        else {
            if(isset($_POST['invite_data'])){
                $result = $this->send_mails();
            }
            
            header( "Content-Type: application/json" );
            echo json_encode($result);
            exit();
        }
    }
    
    public function send_mails(){
        $invite_data = $_POST['invite_data'];
        $results = array();

        if(isset($invite_data['invite_list']) && isset($invite_data['custom_text']) && isset($invite_data['post_id'])){
            $addresses = explode(",", $invite_data['invite_list'] );
            $post_id = $invite_data['post_id'];
            $content = $invite_data['custom_text'];            
            
            if(is_array($addresses)){                
                foreach($addresses as $email){
                    $email = trim($email);
                    $reviewers_hash = md5($post_id.$email.'dontmove');
                    $feedback_link = site_url() . "?p=" . $post_id . "&am2_shareadraft=" . $reviewers_hash;
                    $to = $email;                   
                    $subject = $this->current_user->display_name . ' asked you for feedback on a new draft: "'.get_the_title($post_id).'"';
                    $body = str_replace('{{feedback-link}}', $feedback_link, $content);
                    
                    $results[$to] = wp_mail($to,$subject, $body);                    
                }
            }
        }
        
        return $results;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in AM2_Writing_Helper_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The AM2_Writing_Helper_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->am2_writing_helper, plugin_dir_url(__FILE__) . 'css/am2-writing-helper-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in AM2_Writing_Helper_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The AM2_Writing_Helper_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->am2_writing_helper, plugin_dir_url(__FILE__) . 'js/am2-writing-helper-admin.js', array('jquery'), $this->version, false);
        wp_localize_script( $this->am2_writing_helper, 'AM2Ajax', array(
            // URL to wp-admin/admin-ajax.php to process the request
            'ajaxurl'          => admin_url( 'admin-ajax.php' ),

            // generate a nonce with a unique ID "myajax-post-comment-nonce"
            // so that you can check it later when an AJAX request is sent
            'am2WritingHelperNonce' => wp_create_nonce( 'am2-writing-helper-nonce' ),
            'plugin_name' => $this->am2_writing_helper
            )
           );
    }

}

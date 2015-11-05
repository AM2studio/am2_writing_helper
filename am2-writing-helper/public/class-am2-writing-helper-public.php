<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AM2_Writing_Helper
 * @subpackage AM2_Writing_Helper/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AM2_Writing_Helper
 * @subpackage AM2_Writing_Helper/public
 * @author     Your Name <email@example.com>
 */
class AM2_Writing_Helper_Public {

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

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $am2_writing_helper       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($am2_writing_helper, $version) {

        $this->am2_writing_helper = $am2_writing_helper;
        $this->version = $version;
        $this->submit_review_include = 'partials/am2-writing-helper-public-display.php'; // plugins_url( 'partials/am2-writing-helper-public-display.php', dirname(__FILE__) );                

        $this->allow_draft_view();

        //$this->check_for_submission();

        add_action("wp_ajax_{$this->am2_writing_helper}_get_submit_form_markup", array($this, 'get_submit_form_markup'));
        add_action("wp_ajax_nopriv_{$this->am2_writing_helper}_get_submit_form_markup", array($this, 'get_submit_form_markup'));

        add_action("wp_ajax_{$this->am2_writing_helper}_feedback_submit", array($this, 'feedback_submit'));
        add_action("wp_ajax_nopriv_{$this->am2_writing_helper}_feedback_submit", array($this, 'feedback_submit'));

        add_action('wp_footer', array($this, 'print_submit_form_markup'));
    }

    public function feedback_submit() {
        if (isset($_POST['post_id']) && !empty($_POST['post_id']) && isset($_POST['feedback']) && !empty($_POST['feedback'])) {
            $post_id = $_POST['post_id'];
            $nonce = $_POST['am2WritingHelperNonce'];            
            $reviewers_hash = $_POST['am2_sharedraft'];
            $allow = false;
                        
            $reviews = get_post_meta($post_id, 'am2_review_feedback', true);            
            $invites = get_post_meta($post_id, 'am2_review_emails', true);
            
            if(!is_array($reviews)) $reviews = array();
            if(is_array($invites))  $allow = array_key_exists($reviewers_hash, $invites);            

            // check to see if the submitted nonce matches with the
            // generated nonce we created earlier
            if (!wp_verify_nonce($nonce, 'am2-writing-helper-nonce')) {
                exit('Busted!');
            } else if ($allow) {
                $reviews[$reviewers_hash][] = sanitize_text_field($_POST['feedback']);
                update_post_meta($post_id, 'am2_review_feedback', $reviews);                
                exit();
            } else {
                echo json_encode('not allowed');
                exit();
            }
        } 
        exit();
    }

    public function get_submit_form_markup() {
        $nonce = $_POST['am2WritingHelperNonce'];
        $post_id = $_POST['post_id'];
        $reviewers_hash = $_POST['am2_sharedraft'];

        $invites = get_post_meta($post_id, 'am2_review_emails', true);
        $allow = array_key_exists($reviewers_hash, $invites);

        // check to see if the submitted nonce matches with the
        // generated nonce we created earlier
        if (!wp_verify_nonce($nonce, 'am2-writing-helper-nonce')) {
            exit('Busted!');
        } else if ($allow) {
            include_once($this->submit_review_include);
            exit();
        } else {
            echo json_encode('not allowed');
            exit();
        }

        exit();
    }

    public function print_submit_form_markup() {
        if (!empty($_GET['p']) && $this->is_valid_request($_GET['p']))
            include_once($this->submit_review_include);
    }

    public function allow_draft_view() {
        if (isset($_GET['p']) && !empty($_GET['p'])) {
            //allow guests to view single posts even if they have not post_status="publish"
            $post_id = $_GET['p'];

            if ($this->is_valid_request($post_id)) {
                add_filter('pre_get_posts', array($this, 'guest_enable_hidden_single_post'));
            }

            //reload hidden posts
            //add_filter('the_posts',array($this,'guest_reload_hidden_single_post'));
        }
    }

    public function guest_enable_hidden_single_post($query) {
        //var_dump($query);

        if (/* is_user_logged_in() || */ is_admin())
            return $query;
        //not admin area //user is not logged                        

        if (!is_single())
            return $query;
        //this is a single post

        if (!$query->is_main_query())
            return $query;
        //this is the main query  

        $query->set('post_status', array('publish', 'pending', 'draft'));
        //allowed post statuses for guest                      

        return $query;
    }

    function guest_reload_hidden_single_post($posts) {
        global $wp_query, $wpdb;

        if (is_user_logged_in())
            return $posts;
        //user is not logged

        if (!is_single())
            return $posts;
        //this is a single post

        if (!$wp_query->is_main_query())
            return $posts;
        //this is the main query

        if ($wp_query->post_count)
            return $posts;
        //no posts were found

        $posts = $wpdb->get_results($wp_query->request);

        return $posts;
    }

    function is_valid_request($post_id) {
        if (!isset($_GET['am2_sharedraft']) || empty($_GET['am2_sharedraft']))
            return false;

        $reviewers_hash = $_GET['am2_sharedraft'];
        $review_emails = get_post_meta($post_id, 'am2_review_emails', true);

        if (is_array($review_emails) && isset($review_emails[$reviewers_hash])) {
            return true;
        }

        return false;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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
        wp_enqueue_style($this->am2_writing_helper, plugin_dir_url(__FILE__) . 'css/am2-writing-helper-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        if(isset($_GET['p']) && !empty($_GET['p'])){
					$_p = $_GET['p'];
					$p = get_post($_p);
					$post_id = $p->ID;
				}
				else return;
				       

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
        wp_enqueue_script($this->am2_writing_helper, plugin_dir_url(__FILE__) . 'js/am2-writing-helper-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->am2_writing_helper, 'AM2Ajax', array(
            // URL to wp-admin/admin-ajax.php to process the request
            'ajaxurl' => admin_url('admin-ajax.php'),
						
            // generate a nonce with a unique ID "myajax-post-comment-nonce"
            // so that you can check it later when an AJAX request is sent
            'am2WritingHelperNonce' => wp_create_nonce('am2-writing-helper-nonce'),
						
            'plugin_name' => $this->am2_writing_helper,
            'submit_review_include' => $this->submit_review_include,
            'am2_sharedraft' => isset($_GET['am2_sharedraft']) ? $_GET['am2_sharedraft'] : null,
            'post_id' => $post_id,
            'post_author' => get_the_author_meta('display_name', $p->post_author),
            'valid_request' => $this->is_valid_request($post_id),
                )
        );
    }

}

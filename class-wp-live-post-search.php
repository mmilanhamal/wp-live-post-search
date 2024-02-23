<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The main functional class of the plugin.
 *
 * @package    WP_LIVE_POST_SEARCH
 * @subpackage WP_LIVE_POST_SEARCH/public
 * @author     saurav.rox <https://saurabadhikari.com.np/>
 */
class WP_LIVE_POST_SEARCH {

	function __construct()
	{
		add_action( 'init', array( $this, 'wpls_load_textdomain' ) );
		add_action( 'wp_ajax_nopriv_wpls_ajax_search_main', array( $this, 'wpls_ajax_search_main' ) );
		add_action( 'wp_ajax_wpls_ajax_search_main', array( $this, 'wpls_ajax_search_main' ) );
		add_action( 'admin_menu', array( $this, 'wpls_plugin_page' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wpls_enqueue_styles_scripts' ) );
		add_shortcode( 'WPLS_SEARCH_FORM', array( $this, 'wpls_add_form_shortcode' ) );
	}
	
	//load plugin textdomain
	function wpls_load_textdomain() {
	  load_plugin_textdomain( 'wp-live-post-search', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
	}

	//function to add js and css
	function wpls_enqueue_styles_scripts()
	{
		wp_enqueue_style( 'wp-live-post-search', plugin_dir_url( __FILE__ ).'/public/css/wp-live-post-search-public.css', array(), '1.0.0', false );
		wp_enqueue_script('vue-npm', plugin_dir_url( __FILE__ ).'/public/js/npm-vue.js', [], '2.5.17');
		wp_enqueue_script('vue', plugin_dir_url( __FILE__ ).'/public/js/vue.js', [], '2.5.17');
		wp_enqueue_script( 'wp-live-post-search', plugin_dir_url( __FILE__ ).'/public/js/
			wp-live-post-search-public.js', array(), '1.0.0', true );
		wp_localize_script(
			'wp-live-post-search',
			'WPLS',
			array( 'ajaxurl' => admin_url('admin-ajax.php') )
			);
	}

 	//function to define plugin page
	function wpls_plugin_page(){
	        add_menu_page( 'WP Live Post Search', 'WP Live Post Search', 'manage_options', 'wp-live-post-search', array( $this, 'wpls_plugin_page_display' ) );
	}

	//function to add plugin page
	function wpls_plugin_page_display(){
		?>
		<div class="wpls-wrap">
			<div class="wpls-usage-wrap">
				<h3><?php _e( 'How to show the WP Live Post Search form?', 'wp-live-post-search' ); ?></h3>
				<h4><?php _e( 'Shortcode', 'wp-live-post-search' ); ?></h4>
				<p><?php _e( 'Copy and paste this shortcode directly into any WordPress post or page.', 'wp-live-post-search' ); ?></p>
				<input type="text" class="large-text code" readonly="readonly" value='<?php echo '[WPLS_SEARCH_FORM]'; ?>' />
				<h4><?php _e( 'Template Include', 'wp-live-post-search' ); ?></h4>
				<p><?php _e( 'Copy and paste this code into a template file to include the search form within your theme.', 'wp-live-post-search' ); ?></p>
				<input type="text" class="large-text code" readonly="readonly" value="&lt;?php echo do_shortcode(&quot;[WPLS_SEARCH_FORM']&quot;); ?&gt;" />
			</div>
			<div class="wpls-inner-wrap">
				<h3><?php _e( 'Changing What to Search', 'wp-live-post-search' ) ?></h3>
				<i><?php _e( 'Paste the below code to your theme\'s functions.php file.', 'wp-live-post-search' ) ?></i>
				<code style="display: block;padding: 10px;margin: 10px 0;">
					&lt;?php
					function change_the_search_post_type()
					{
						$posttype= 'post'; //change according to the requirement 
						return $posttype;
					}
					add_filter('wpls_change_post_type_search','change_the_search_post_type');
					?&gt;
				</code>
			</div>		
		</div>
	<?php
	}



	//function to add shortcode for search form
	function wpls_add_form_shortcode(){
		ob_start()
		?>
		<div id="wpls-search" class="wpls-layout">
		    <div class="wp-search-holder">
		      	<form class="wpls-search-input" action="" method="get">
		        	<input type="search" name="wpls-s" id="wpls-s" v-model="search_val" placeholder="<?php _e('Search...','wp-live-post-search'); ?>">
		      	</form><!-- END .wpls-search-input -->
		    </div>
		    <div class="wpls-results">
		      	<h2><?php _e('Results','wp-live-post-search');?></h2>
		      	<div id="wpls-result">
		        	<transition-group name="fade" tag="ul" class="wp-list-results">
		          		<li v-for="result in results" v-bind:key="result.id" class="wpls-item">
		            		<div class="wpls-result-meta">
		              			<p class="result-desc" v-if="result.description"><a href="{{result.link}}">{{result.title}}</a></p>
		            		</div>
		          		</li>
		        	</transition-group>
		      	</div>
		    </div><!-- END #wpls-results -->
		</div><!-- END #wpls-search -->
	<?php
		// $data = ob_get_contents();
		return ob_get_clean();
	}

	//function for live ajax search
	function wpls_ajax_search_main(){
		header("Content-Type: application/json");
	    // Create the array for the result
	    $result = array();
	    if( isset( $_POST['search_string'] ) && $_POST['search_string']!='' )
	    {
		    $the_query = new WP_Query( 
		                        array(
		                          'post_type' => apply_filters('wpls_change_post_type_search','any'),
		                          'posts_per_page' => -1, 
		                          's' => esc_attr( $_POST['search_string'] )
		                        )
		                    );

		    if( $the_query->have_posts() ) :

		        while( $the_query->have_posts() ): $the_query->the_post();

		            // We are now inside the loop, so anything you normally do here can be applied
		            // Modify this based on what you want to show in your results
		          $result[] = array(
		            "id" => get_the_id(),
		            "title" => get_the_title(),
		            "description" => get_the_excerpt(),
		            "link"=>get_permalink()
		          );

		        endwhile;
		        // print_r($result);
		      // Return a JSON object with the results
		      echo json_encode($result);

		      wp_reset_postdata();

		    else:

		      	$result[] = '<p>No results found.</p>';
				echo json_encode($result);	      
		    endif;
		}
	    die();
	}
}
new WP_LIVE_POST_SEARCH;
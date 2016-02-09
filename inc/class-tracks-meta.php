<?php


/**
 * Class: Tracks_MetaBox
 *
 * Class which holds all of the core functions for instantiating the plugin when it's first enabled before
 * starting to add new songs and genres
 *
 * Changes or patches added to README.md
 */




 class Tracks_MetaBox
 {

 	public function __construct() {
 	
	}
 	
		/****************************************************
		Add the meta boxes needed for the Songs CPT
		****************************************************/

		public function tracks_song_name() {
		    add_meta_box( 'mb_song_name', 'Song Name', array('Tracks_MetaBox', 'html_song_name'), 'songs', 'normal', 'high' );
		}

        public function tracks_video_link() {
            add_meta_box( 'mb_video_link', 'Video Link', array('Tracks_MetaBox', 'html_video_link'), 'songs', 'normal', 'high' );
        }

        public function tracks_buyNow_link() {
            add_meta_box( 'mb_buy_link', 'Buy Link', array('Tracks_MetaBox', 'html_buy_link'), 'songs', 'normal', 'high' );
        }

        public function artists_list() {
            add_meta_box( 'mb_artist_list', 'Artists', array('Tracks_MetaBox','html_artist_list'), 'songs', 'normal', 'high' );
        }


		/**
		 * Prints the box content.
		 * 
		 * @param WP_Post $post The object for the current post/page.
		 */

		public function html_song_name( $post ) {

		    // Add a nonce field so we can check for it later
		    wp_nonce_field( 'tracks_save_meta_box_data', 'myplugin_meta_box_nonce' );

		    /*
		     * Use get_post_meta() to retrieve an existing value
		     * from the database and use the value for the form.
		     */
		    $tracks_song_name = get_post_meta( $post->ID, '_song_name' );

		    echo '<input type="text" id="tracks_song_name" name="tracks_song_name" value=" HELLO " size="25" />';
		}


        /**
        * Prints the box content.
        * 
        * @param WP_Post $post The object for the current post/page.
        */

        function html_video_link( $post ) {

            /*
             * Use get_post_meta() to retrieve an existing value
             * from the database and use the value for the form.
             */
            $tracks_video_link = get_post_meta( $post->ID, '_video_link' );

            echo '<input type="text" id="tracks_video_link" name="tracks_video_link" value="' . esc_url( $tracks_video_link[0] ) . '" size="25" />';
        }

        /****************************************************
        Add Buy now meta box link
        ****************************************************/

        /**
         * Prints the box content.
         * 
         * @param WP_Post $post The object for the current post/page.
         */

        function html_buy_link( $post ) {

            /*
             * Use get_post_meta() to retrieve an existing value
             * from the database and use the value for the form.
             */
            $tracks_buy_link = get_post_meta( $post->ID, '_buy_link' );

            echo '<input type="text" id="tracks_buy_link" name="tracks_buy_link" value="' . esc_url( $tracks_buy_link[0] ) . '" size="45" />';
        }

        function html_artist_list( $post ) {

            /*
            * Grab the post ID to get the meta data
            */

            global $post;
            $pid = $post->ID;

             /*
            * Bring back all the post meta associated with the post ID
            * Next explode the _artist array to retrieve all artists associated with the current post
            */

            $meta = get_post_meta( $pid );
            $artist_list = explode( ' ', $meta[ '_artist'][0] );

            
           $args = array(
                'post_type' => 'artist',
                'posts_per_page' => -1
            );
            
            $artists_lists = get_posts( $args );
            
            foreach ( $artists_lists as $artist ) :
                setup_postdata($artist);
                if ( in_array( $artist->ID, $artist_list ) ) { $iamchecked = "checked='checked'"; } else { $iamchecked = ""; }
                echo "<input type='checkbox' name='artist[]' " . $iamchecked . " value='" . $artist->ID . "' />" . $artist->post_title . "<br />";
                endforeach; wp_reset_postdata();
                   setup_postdata($pid);
        }

     	/**
    	 * When the post is saved, save our custom data.
    	 *
    	 * @param int $post_id The ID of the post being saved.
    	 */

    	public function save_meta_box_data( $post_id ) {

        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */

        // Check if the nonce is set
        if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
            return;
        }

        // Verify the nonce is valid
        if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'tracks_save_meta_box_data' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] )  && 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }

        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        // Save for us to save data after these checks

        // Make sure that it is set
        if ( ! isset( $_POST['tracks_song_name'] ) ) {
            return;
        }


        // sanitize user input
        $tracks_data = sanitize_text_field( $_POST['tracks_song_name'] );

        // Update meta field in database
        update_post_meta( $post_id, '_song_name', $tracks_data );
       
        // sanitize user input
        $tracks_data_link = sanitize_text_field( $_POST['tracks_video_link'] );

        // Update meta field in database
        update_post_meta( $post_id, '_video_link', $tracks_data_link );
        
    	}


}
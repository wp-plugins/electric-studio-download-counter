<?php

class Esdc_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'esdc_top_download_widgets', // Base ID
			'Top Downloads', // Name
			array(
				'description' => __( 'Top downloads', '' ),
			    'title' => __('Top Downloads',''),
			    'show_count' => true
			) // Args
		);
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Top Downloads', 'text_domain' );
		}

 	    if ( isset( $instance[ 'limit' ] ) ) {
			$limit = $instance[ 'limit' ];
		}
		else {
			$limit = 10;
		}

		if( isset($instance['show_count'])){
		    $show_count = $instance['show_count'];
		}else{
		    $show_count = true;
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Amount of Downloads:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>"><?php _e( 'Show Count:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" type="checkbox" <?php if($show_count==true){?>checked="checked"<?php }?> value="true" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['limit'] = strip_tags( $new_instance['limit'] );
        $instance['show_count'] = strip_tags( $new_instance['show_count'] );
		return $instance;
	}

    public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

        $db = new Esdc_db();
        $downloads = $db->get_data("","","",$instance['limit']);
        echo "<ul>";
		foreach($downloads as $d){
		    echo "<li>";
		    echo $d->download_name;
		    if($instance['show_count'] == true)
		        echo " (".$d->count.")";
		    echo "</li>";
		}
		echo "</ul>";
		echo $after_widget;
	}

}

add_action('widgets_init', 'registerEsdcWidgets');

function registerEsdcWidgets(){
    register_widget( 'Esdc_Widget' );
}
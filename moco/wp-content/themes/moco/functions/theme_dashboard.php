<?php
/* Start of showing the custom post posts on admin dashboard */
function wps_recent_posts_dw() {
    
    global $post;
    $args = array( 'numberposts' => 5, 'post_type' => array( 'post' ) );
    $myposts = get_posts( $args );
    if($myposts){
?>
       <style>
           .quote_date{
               float: right;
           }
       </style>
   <ol>
     <?php
        foreach( $myposts as $post ) :  setup_postdata($post); ?>
            <li>  <a href="<?php echo get_edit_post_link(); ?>"><?php the_title(); ?></a> <span class="quote_date"><?php the_time(get_option('date_format')); ?></span> </li>
  <?php endforeach; ?>
   </ol>
<?php 
    }
    else{
        echo "No Posts available.";
    }
}
function add_wps_recent_posts_dw() {
       wp_add_dashboard_widget( 'wps_recent_posts_dw', __( 'Recent Posts' ), 'wps_recent_posts_dw' );
}
add_action('wp_dashboard_setup', 'add_wps_recent_posts_dw' );
/* End of showing the custom post posts on admin dashboard */



/* Start Of at a Glance Code */
add_action( 'dashboard_glance_items', 'cpad_at_glance_content_table_end' );
function cpad_at_glance_content_table_end() {
    $args = array(
        'public' => true,
        '_builtin' => false
    );
    $output = 'object';
    $operator = 'and';

    $post_types = get_post_types( $args, $output, $operator );
    foreach ( $post_types as $post_type ) {
        $num_posts = wp_count_posts( $post_type->name );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
        if ( current_user_can( 'edit_posts' ) ) {
            $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
            echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
        }
    }
}
/* End Of at a Glance Code */
?>
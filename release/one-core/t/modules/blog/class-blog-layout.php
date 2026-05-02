<?php

class OneCoreCustomizer_Blog_Posts_Layout extends One_Posts_Layout {

    public $parts = array(
        'media',
        'header',
        'body',
        'footer',
    );

    public $entry_class = '';

    function set_args( $config = null ){
        parent::set_args( $config );
        if ( ! is_array( $config ) ) {
            $config = array();
        }
        foreach( $this->parts as $part ) {
            $key = $part.'_fields';
            $fields = tophive_one()->get_setting( $this->customizer_args['prefix'].'_dnp_'.$part );
            $this->args[ $key ] =  is_array( $fields )  ? $fields : array();
        }

        $this->args['columns'] =  tophive_one()->get_setting( $this->customizer_args['prefix'].'_columns', 'all' );

        One_Post_Entry()->config['term_sep'] =  tophive_one()->get_setting( $this->customizer_args['prefix'].'_term_sep' );
        One_Post_Entry()->config['term_count'] = absint( tophive_one()->get_setting( $this->customizer_args['prefix'].'_term_count' ) );
        One_Post_Entry()->config['tax'] =  tophive_one()->get_setting( $this->customizer_args['prefix'].'_taxonomy' );
        One_Post_Entry()->config['title_tag'] =  tophive_one()->get_setting( $this->customizer_args['prefix'].'_title_tag' );
        One_Post_Entry()->config['title_link'] =  tophive_one()->get_setting( $this->customizer_args['prefix'].'_title_link' );


        if ( empty( One_Post_Entry()->config['tax'] ) ) {
            One_Post_Entry()->config['tax'] = 'category';
        }
        if(  $this->args['layout'] == 'blog_lateral' ) {
            $this->args['columns'] = 1;
        }

        $this->entry_class = tophive_one()->get_setting( $this->customizer_args['prefix'].'_media_ca' ); //

    }

    function layout( $post = null ){
        $media_fields = array(
            array(
                '_key' => 'thumbnail'
            ),
        );
        if ( $this->args['media_hide'] ) {
            $show_media = false;
        } else {
            $show_media = true;
            if ( ! has_post_thumbnail( $post ) ) {
                if ( $this->args['hide_thumb_if_empty'] ) {
                    $show_media = false;
                }
            }
        }

        switch( $this->args['layout'] ) {
            case 'blog_column':
            case 'blog_timeline':
            case 'blog_masonry':
                $this->item_part( 'header', $post );
                if ( $show_media ) {
                    ?>
                    <div class="entry-article-part entry-media">
                        <a class="entry-media-link " href="<?php echo esc_url( get_permalink( $post ) ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"></a>
                        <?php
                        One_Post_Entry()->build_fields( $media_fields, $post );
                        $this->item_part('media', $post, 'media-content-inner');
                        ?>
                    </div>
                <?php } ?>
                <div class="entry-content-data">
                    <?php
                    $this->item_part( 'body', $post );
                    $this->item_part( 'footer', $post );
                    ?>
                </div>
                <?php
            break;
            default:
                if ( $show_media ) {
                ?>
                <div class="entry-media">
                    <a class="entry-media-link " href="<?php echo esc_url( get_permalink( $post ) ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"></a>
                    <?php
                    One_Post_Entry()->build_fields( $media_fields, $post );
                    $this->item_part( 'media', $post, 'media-content-inner' );
                    ?>
                </div>
                    <?php } ?>
                <div class="entry-content-data">
                    <?php
                    $this->item_part( 'header', $post );
                    $this->item_part( 'body', $post );
                    $this->item_part( 'footer', $post );
                    ?>
                </div>
                <?php

        }

    }

}
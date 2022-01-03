<?php

namespace Dmitry\Grid;

class ShortCode
{
    public function run(array $attrs, $content): string
    {

        $attrs = extract(shortcode_atts(array(
            'size' => 'full',
            'term_id' => null,
            'taxonomy' => 'category',
            'design' => 'design-1',
            'orderby' => 'name',
            'order' => 'ASC',
            'columns' => 3,
            'show_title' => 'true',
            'show_count' => 'true',
            'show_desc' => 'true',
            'hide_empty' => 'true',
            'exclude_cat' => array(),
            'extra_class' => '',
            'className' => '',
            'align' => '',
        ), $attrs, 'pci-cat-grid'));

        $size = !empty($size) ? $size : 'full';
        $term_id = !empty($term_id) ? explode(',', $term_id) : '';
        $taxonomy = !empty($taxonomy) ? $taxonomy : 'category';
        $design = !empty($design) ? $design : 'design-1';
        $show_title = ($show_title == 'true') ? true : false;
        $show_count = ($show_count == 'true') ? true : false;
        $show_desc = ($show_desc == 'true') ? true : false;
        $hide_empty = ($hide_empty == 'false') ? false : true;
        $exclude_cat = !empty($exclude_cat) ? explode(',', $exclude_cat) : array();
        $columns = (!empty($columns) && $columns <= 4) ? $columns : 3;
        $count = 0;

        // get terms and workaround WP bug with parents/pad counts
        $args = array(
            'orderby' => $orderby,
            'order' => $order,
            'include' => $term_id,
            'hide_empty' => $hide_empty,
            'exclude' => $exclude_cat,
        );

        $post_categories = get_terms($taxonomy, $args);

        ob_start();

        if ($post_categories) { ?>
            <div class="pciwgas-cat-wrap pciwgas-clearfix <?php echo $extra_class; ?> pciwgas-<?php echo $design; ?>">
                <?php
                foreach ($post_categories as $category) {
                    $thumbnail = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $category_image = wp_get_attachment_image_src($thumbnail, $size);
                    $term_link = get_term_link($category, $taxonomy);
                    ?>

                    <div class="row">
                        <div class="col">
                            <div class="img-wrapper">
                                <?php if (!empty($category_image)) { ?>
                                    <a href="<?php echo $term_link; ?>">
                                        <img src="<?php echo $category_image; ?>" class="cat-img" alt="This is image"/>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="title">
                                <?php if ($show_title && $category->name) { ?>
                                    <a href="<?php echo $term_link; ?>"><?php echo $category->name; ?> </a>
                                <?php }
                                if ($show_count) { ?>
                                    <span class="category-count"><?php echo $category->count; ?></span>
                                <?php } ?>
                            </div>
                            <?php if ($show_desc && $category->description) { ?>
                                <div class="description">
                                    <div class="pciwgas-cat-desc"><?php echo $category->description; ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php $count++;
                } ?>
            </div>
            <?php
        }
        $content .= ob_get_clean();
        return $content;
    }
}

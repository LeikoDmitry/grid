<?php

namespace Dmitry\Grid;

class ShortCode
{
    /**
     * @param string|array $attrs
     */
    public function run($attrs): string
    {
        $attrs = shortcode_atts(array(
            'size'        => 'full',
            'term_id'     => null,
            'taxonomy'    => 'category',
            'orderby'     => 'term_id',
            'order'       => 'ASC',
            'columns'     => 2,
            'show_title'  => 1,
            'show_count'  => 1,
            'show_desc'   => 1,
            'hide_empty'  => 0,
            'exclude_cat' => [],
            'meta_field'  => '',
        ), $attrs);

        extract($attrs);

        $size = !empty($size) ? $size : 'full';
        $termId = !empty($term_id) ? explode(',', $term_id) : '';
        $taxonomy = !empty($taxonomy) ? $taxonomy : 'category';
        $showTitle = $show_title === 1;
        $showCount = $show_count === 1;
        $showDescription = $show_desc === 1;
        $hideEmpty = !(($hide_empty === 0));
        $excludeCategories = !empty($exclude_cat) ? explode(',', $exclude_cat) : array();
        $columns = (!empty($columns) && $columns <= 4) ? $columns : 3;

        $args = [
            'orderby'    => $orderby,
            'order'      => $order,
            'include'    => $term_id,
            'hide_empty' => $hide_empty,
            'exclude'    => $exclude_cat,
        ];

        $categories = get_terms($taxonomy, $args);

        return $this->render(
            $categories,
            compact(
                'size',
                'termId',
                'showTitle',
                'showDescription',
                'showCount',
                'hideEmpty',
                'excludeCategories',
                'columns'
            )
        );
    }

    public function render(array $items = [], array $shortCodeArrayData = []): string
    {
        ob_start();
        $content = '';
        $count = 1;
        if ($items): ?>
            <div class="row">
            <?php foreach ($items as $category): ?>
                <?php
                $thumbnail = get_term_meta($category->term_id, '_category_image_id', true);
                $categoryImage = wp_get_attachment_image_src($thumbnail, $shortCodeArrayData['size'] ?? 'full');
                $termLink = get_term_link($category, $shortCodeArrayData['taxonomy'] ?? 'category');
                ?>
                <div class="col">
                    <div class="img-wrapper">
                        <?php
                        if (!empty($categoryImage)): ?>
                            <a href="<?php
                            echo $termLink; ?>">
                                <img src="<?php
                                echo $categoryImage[0]; ?>" class="cat-img" alt="This is image"/>
                            </a>
                        <?php
                        endif; ?>
                    </div>
                    <div class="title">
                        <?php
                        if (($shortCodeArrayData['showTitle']) ?? null && $category->name): ?>
                            <a href="<?php
                            echo esc_url($termLink); ?>"><?php
                                echo esc_html($category->name); ?> </a>
                        <?php
                        endif; ?>
                        <?
                        if ($shortCodeArrayData['showCount'] ?? null): ?>
                            <span class="category-count"><?php
                                echo esc_html($category->count); ?></span>
                        <?php
                        endif; ?>
                    </div>
                    <?php
                    if ($shortCodeArrayData['showDescription'] ?? null && $category->description): ?>
                        <div class="description">
                            <div class="cat-desc"><?php
                                echo esc_html($category->description); ?></div>
                        </div>
                    <?php
                    endif; ?>
                    <div class="meta">
                        <?php
                        if ($shortCodeArrayData['meta_key'] ?? null): ?>
                            <div class="wrap-meta">
                                <div class="meta"><?php
                                    echo get_term_meta(
                                        $category->term_id,
                                        esc_html($shortCodeArrayData['meta_key'] ?? ''),
                                        true
                                    ); ?></div>
                            </div>
                        <?php
                        endif; ?>
                    </div>
                </div>
            <?php if ($count % $shortCodeArrayData['columns'] === 0): ?>
            </div>
            <div class="row">
            <?php endif; ?>
            <?php $count++ ?>
            <?php endforeach; ?>
        </div>
        <?php
        endif ?>
        <?php
        $content .= ob_get_clean();

        return $content;
    }
}

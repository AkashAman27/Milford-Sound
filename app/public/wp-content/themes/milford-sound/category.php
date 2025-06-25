<?php get_header(); ?>

<?php
// Get current category
$current_category = get_queried_object();
$category_id = $current_category->term_id;

// Get ACF fields for this category
$category_header = get_field('category_header', 'category_' . $category_id);
$category_layout = get_field('category_layout', 'category_' . $category_id);
$category_features = get_field('category_features', 'category_' . $category_id);
$category_cta = get_field('category_cta', 'category_' . $category_id);

// Layout settings
$posts_layout = $category_layout['posts_layout'] ?? 'grid';
$posts_per_page = $category_layout['posts_per_page'] ?? 9;
$show_sidebar = $category_layout['show_sidebar'] ?? true;
$show_filters = $category_layout['show_filters'] ?? true;

// Header settings
$category_icon = $category_header['category_icon'] ?? '📝';
$category_color = $category_header['category_color'] ?? '#2dd4bf';
$category_bg_image = $category_header['category_background_image'];
$category_subtitle = $category_header['category_subtitle'];
$category_description_extended = $category_header['category_description_extended'];
?>

<main class="main-content category-page">
    
    <!-- Category Header -->
    <header class="category-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, <?php echo esc_attr($category_color); ?> 0%, #3b82f6 100%); color: white; text-align: center; overflow: hidden;">
        
        <?php if ($category_bg_image) : ?>
            <div class="category-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($category_bg_image['url']); ?>'); background-size: cover; background-position: center; opacity: 0.3; z-index: -1;"></div>
        <?php endif; ?>
        
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
            
            <div class="category-icon" style="font-size: 4rem; margin-bottom: 1rem;">
                <?php echo esc_html($category_icon); ?>
            </div>
            
            <h1 class="category-title" style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; margin-bottom: 1rem; line-height: 1.2;">
                <?php echo esc_html($current_category->name); ?>
            </h1>
            
            <?php if ($category_subtitle) : ?>
                <p class="category-subtitle" style="font-size: 1.5rem; margin-bottom: 2rem; opacity: 0.9;">
                    <?php echo esc_html($category_subtitle); ?>
                </p>
            <?php endif; ?>
            
            <?php if ($category_description_extended) : ?>
                <p class="category-description" style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                    <?php echo esc_html($category_description_extended); ?>
                </p>
            <?php elseif ($current_category->description) : ?>
                <p class="category-description" style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                    <?php echo esc_html($current_category->description); ?>
                </p>
            <?php endif; ?>
            
            <!-- Category Stats -->
            <div class="category-stats" style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap; margin-top: 3rem;">
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;"><?php echo esc_html($current_category->count); ?></div>
                    <div style="opacity: 0.9;">Articles</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">5+</div>
                    <div style="opacity: 0.9;">Min Read Avg</div>
                </div>
                <div class="stat-item" style="text-align: center;">
                    <div style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Weekly</div>
                    <div style="opacity: 0.9;">Updates</div>
                </div>
            </div>
            
        </div>
    </header>

    <!-- Category Features (if enabled) -->
    <?php if ($category_features && !empty($category_features)) : ?>
        <section class="category-features" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                    <?php foreach ($category_features as $feature) : ?>
                        <div class="feature-card" style="background: white; padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                            <div style="font-size: 2.5rem; margin-bottom: 1rem;"><?php echo esc_html($feature['feature_icon']); ?></div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b;"><?php echo esc_html($feature['feature_title']); ?></h3>
                            <p style="color: #64748b;"><?php echo esc_html($feature['feature_description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Category Filters (if enabled) -->
    <?php if ($show_filters) : ?>
        <section class="category-filters" style="padding: 2rem 0; background: white; border-bottom: 1px solid #e2e8f0;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                <div class="filter-tabs" style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                    <a href="<?php echo get_category_link($category_id); ?>" class="filter-tab active" style="padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; background: <?php echo esc_attr($category_color); ?>; color: white;">
                        All <?php echo esc_html($current_category->name); ?>
                    </a>
                    
                    <?php
                    // Get subcategories if any
                    $subcategories = get_categories(array(
                        'parent' => $category_id,
                        'hide_empty' => true
                    ));
                    
                    foreach ($subcategories as $subcat) :
                    ?>
                        <a href="<?php echo get_category_link($subcat->term_id); ?>" class="filter-tab" style="padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; background: #f1f5f9; color: #64748b;">
                            <?php echo esc_html($subcat->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Posts Content -->
    <section class="category-posts" style="padding: 4rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            
            <?php if ($show_sidebar) : ?>
                <div class="posts-layout-with-sidebar" style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem; align-items: start;">
            <?php else : ?>
                <div class="posts-layout-full-width">
            <?php endif; ?>
                
                <!-- Main Posts Area -->
                <div class="posts-main">
                    
                    <?php if (have_posts()) : ?>
                        
                        <!-- Posts Grid -->
                        <div class="posts-grid posts-layout-<?php echo esc_attr($posts_layout); ?>" style="<?php 
                            switch($posts_layout) {
                                case 'list':
                                    echo 'display: flex; flex-direction: column; gap: 2rem;';
                                    break;
                                case 'masonry':
                                    echo 'columns: 3; column-gap: 2rem;';
                                    break;
                                case 'featured_first':
                                    echo 'display: grid; gap: 2rem;';
                                    break;
                                case 'magazine':
                                    echo 'display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;';
                                    break;
                                default:
                                    echo 'display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;';
                            }
                        ?>">
                            
                            <?php $post_count = 0; ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <?php $post_count++; ?>
                                
                                <!-- Featured First Layout -->
                                <?php if ($posts_layout === 'featured_first' && $post_count === 1) : ?>
                                    <article class="featured-post" style="grid-column: 1 / -1; background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0; min-height: 400px;">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="post-image" style="overflow: hidden; position: relative;">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="post-content" style="padding: 3rem; display: flex; flex-direction: column; justify-content: center;">
                                                <div class="post-meta" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #64748b;">
                                                    <span>📅 <?php echo get_the_date(); ?></span>
                                                    <span>👤 <?php the_author(); ?></span>
                                                    <span>⏱️ <?php echo reading_time(); ?> min read</span>
                                                </div>
                                                
                                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h2>
                                                
                                                <div class="post-excerpt" style="color: #64748b; font-size: 1.1rem; line-height: 1.7; margin-bottom: 2rem;">
                                                    <?php the_excerpt(); ?>
                                                </div>
                                                
                                                <a href="<?php the_permalink(); ?>" class="read-more-btn" style="background: linear-gradient(135deg, <?php echo esc_attr($category_color); ?>, #3b82f6); color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; align-self: flex-start;">
                                                    Read Full Article →
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                
                                <!-- Regular Post Cards -->
                                <?php else : ?>
                                    <article class="post-card post-layout-<?php echo esc_attr($posts_layout); ?>" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: transform 0.3s ease; <?php echo $posts_layout === 'masonry' ? 'break-inside: avoid; margin-bottom: 2rem;' : ''; ?>">
                                        
                                        <?php if ($posts_layout === 'list') : ?>
                                            <!-- List Layout -->
                                            <div style="display: grid; grid-template-columns: 250px 1fr; gap: 0; height: 200px;">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <div class="post-image" style="overflow: hidden;">
                                                        <a href="<?php the_permalink(); ?>">
                                                            <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="post-content" style="padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                                                    <div>
                                                        <div class="post-meta" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b;">
                                                            <span>📅 <?php echo get_the_date('M j'); ?></span>
                                                            <span>⏱️ <?php echo reading_time(); ?> min</span>
                                                        </div>
                                                        
                                                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.75rem; color: #1e293b; line-height: 1.3;">
                                                            <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                                                <?php the_title(); ?>
                                                            </a>
                                                        </h3>
                                                        
                                                        <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5;">
                                                            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                                        </p>
                                                    </div>
                                                    
                                                    <a href="<?php the_permalink(); ?>" style="color: <?php echo esc_attr($category_color); ?>; font-weight: 600; text-decoration: none; font-size: 0.9rem; margin-top: 1rem;">
                                                        Read More →
                                                    </a>
                                                </div>
                                            </div>
                                        
                                        <?php else : ?>
                                            <!-- Grid/Card Layout -->
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="post-image" style="height: 200px; overflow: hidden; position: relative;">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                                    </a>
                                                    
                                                    <!-- Category Badge -->
                                                    <div class="category-badge" style="position: absolute; top: 1rem; right: 1rem; background: <?php echo esc_attr($category_color); ?>; color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                                        <?php echo esc_html($current_category->name); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="post-content" style="padding: 2rem;">
                                                <div class="post-meta" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b;">
                                                    <span>📅 <?php echo get_the_date('M j, Y'); ?></span>
                                                    <span>👤 <?php the_author(); ?></span>
                                                    <span>⏱️ <?php echo reading_time(); ?> min read</span>
                                                </div>
                                                
                                                <h3 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.4;">
                                                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                                
                                                <div class="post-excerpt" style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                                </div>
                                                
                                                <a href="<?php the_permalink(); ?>" style="color: <?php echo esc_attr($category_color); ?>; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                                                    Continue Reading →
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
                                    </article>
                                <?php endif; ?>
                                
                            <?php endwhile; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="category-pagination" style="margin-top: 4rem; text-align: center;">
                            <?php
                            the_posts_pagination(array(
                                'mid_size' => 2,
                                'prev_text' => '← Previous Posts',
                                'next_text' => 'Next Posts →',
                            ));
                            ?>
                        </div>

                    <?php else : ?>
                        <!-- No Posts Found -->
                        <div class="no-posts" style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                            <div style="font-size: 4rem; margin-bottom: 2rem;"><?php echo esc_html($category_icon); ?></div>
                            <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #1e293b;">No Posts Found</h2>
                            <p style="color: #64748b; font-size: 1.25rem; margin-bottom: 2rem;">We haven't published any posts in this category yet. Check back soon!</p>
                            <a href="<?php echo home_url('/blog'); ?>" class="btn btn-primary" style="background: <?php echo esc_attr($category_color); ?>; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                                Browse All Posts →
                            </a>
                        </div>
                    <?php endif; ?>
                    
                </div>

                <!-- Sidebar (if enabled) -->
                <?php if ($show_sidebar) : ?>
                    <aside class="category-sidebar">
                        <!-- Category Info Widget -->
                        <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">About This Category</h3>
                            <div style="text-align: center; margin-bottom: 1.5rem;">
                                <div style="font-size: 3rem; margin-bottom: 1rem;"><?php echo esc_html($category_icon); ?></div>
                                <div style="font-size: 2rem; font-weight: 800; color: <?php echo esc_attr($category_color); ?>; margin-bottom: 0.5rem;"><?php echo esc_html($current_category->count); ?></div>
                                <div style="color: #64748b;">Total Articles</div>
                            </div>
                            <?php if ($current_category->description) : ?>
                                <p style="color: #64748b; line-height: 1.6; font-size: 0.9rem;"><?php echo esc_html($current_category->description); ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Related Categories -->
                        <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Other Categories</h3>
                            <?php
                            $other_categories = get_categories(array(
                                'exclude' => $category_id,
                                'hide_empty' => true,
                                'number' => 5
                            ));
                            
                            foreach ($other_categories as $cat) :
                                $cat_icon = get_field('category_icon', 'category_' . $cat->term_id) ?: '📝';
                                $cat_color = get_field('category_color', 'category_' . $cat->term_id) ?: '#2dd4bf';
                            ?>
                                <a href="<?php echo get_category_link($cat->term_id); ?>" style="display: flex; align-items: center; gap: 1rem; padding: 1rem 0; text-decoration: none; color: inherit; border-bottom: 1px solid #f1f5f9; transition: all 0.3s ease;">
                                    <span style="font-size: 1.5rem;"><?php echo esc_html($cat_icon); ?></span>
                                    <div style="flex: 1;">
                                        <div style="font-weight: 600; color: #1e293b;"><?php echo esc_html($cat->name); ?></div>
                                        <div style="font-size: 0.8rem; color: #64748b;"><?php echo esc_html($cat->count); ?> articles</div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <!-- Newsletter Signup -->
                        <div class="sidebar-widget" style="background: linear-gradient(135deg, <?php echo esc_attr($category_color); ?>, #3b82f6); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; text-align: center;">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Stay Updated</h3>
                            <p style="opacity: 0.9; margin-bottom: 1.5rem; font-size: 0.9rem;">Get the latest <?php echo esc_html(strtolower($current_category->name)); ?> articles delivered to your inbox.</p>
                            <form style="display: flex; flex-direction: column; gap: 1rem;">
                                <input type="email" placeholder="Your email address" style="padding: 0.75rem; border: none; border-radius: 8px; font-size: 0.9rem;">
                                <button type="submit" style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                    Subscribe →
                                </button>
                            </form>
                        </div>
                    </aside>
                <?php endif; ?>
                
            </div>
        </div>
    </section>

    <!-- Category CTA (if enabled) -->
    <?php if ($category_cta && $category_cta['cta_enabled']) : ?>
        <section class="category-cta" style="padding: 4rem 0; background: linear-gradient(135deg, <?php echo esc_attr($category_color); ?> 0%, #3b82f6 100%); color: white; text-align: center;">
            <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
                
                <?php if ($category_cta['cta_title']) : ?>
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">
                        <?php echo esc_html($category_cta['cta_title']); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ($category_cta['cta_description']) : ?>
                    <p style="font-size: 1.25rem; margin-bottom: 3rem; opacity: 0.9;">
                        <?php echo esc_html($category_cta['cta_description']); ?>
                    </p>
                <?php endif; ?>
                
                <?php if ($category_cta['cta_buttons']) : ?>
                    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                        <?php foreach ($category_cta['cta_buttons'] as $button) : ?>
                            <?php if ($button['button_link']) : ?>
                                <a href="<?php echo esc_url($button['button_link']['url']); ?>"
                                   style="padding: 1rem 2rem; border-radius: 50px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; <?php echo $button['button_style'] === 'primary' ? 'background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);' : 'background: white; color: ' . esc_attr($category_color) . ';'; ?>"
                                   <?php if ($button['button_link']['target']) echo 'target="' . esc_attr($button['button_link']['target']) . '"'; ?>>
                                    <?php echo esc_html($button['button_text']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
            </div>
        </section>
    <?php endif; ?>
    
</main>

<style>
/* Category Page Specific Styles */
.post-card:hover {
    transform: translateY(-5px);
}

.post-card:hover img {
    transform: scale(1.05);
}

.filter-tab:hover {
    background: <?php echo esc_attr($category_color); ?> !important;
    color: white !important;
}

.category-pagination .page-numbers {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    margin: 0 0.5rem;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    text-decoration: none;
    color: #64748b;
    font-weight: 600;
    transition: all 0.3s ease;
}

.category-pagination .page-numbers:hover,
.category-pagination .page-numbers.current {
    background: <?php echo esc_attr($category_color); ?>;
    color: white;
    border-color: <?php echo esc_attr($category_color); ?>;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .posts-layout-with-sidebar {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .featured-post > div {
        grid-template-columns: 1fr !important;
    }
    
    .post-layout-list > div {
        grid-template-columns: 1fr !important;
        height: auto !important;
    }
    
    .posts-layout-masonry {
        columns: 1 !important;
    }
    
    .category-stats {
        gap: 1.5rem !important;
    }
}
</style>

<?php get_footer(); ?>
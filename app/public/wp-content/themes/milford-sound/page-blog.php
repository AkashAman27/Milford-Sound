<?php
/**
 * Template Name: Blog Page
 * Description: Professional blog page template with ACF customization
 */

get_header(); 

// Get ACF fields for blog page
$blog_hero = get_field('blog_hero') ?: array();
$blog_settings = get_field('blog_settings') ?: array();
$sidebar_settings = get_field('sidebar_settings') ?: array();

// Hero section data with fallbacks
$badge_text = safe_get($blog_hero, 'badge_text', 'Latest Updates');
$blog_title = safe_get($blog_hero, 'title', 'Milford Sound Blog');
$title_highlight = safe_get($blog_hero, 'title_highlight', 'Blog');
$blog_description = safe_get($blog_hero, 'description', 'Discover insider tips, travel guides, and the latest news from New Zealand\'s most spectacular natural wonder.');
$bg_image = safe_get($blog_hero, 'background_image');
$bg_video = safe_get($blog_hero, 'background_video');

// Blog settings with fallbacks
$posts_per_page = safe_get($blog_settings, 'posts_per_page', 6);
$show_featured = safe_get($blog_settings, 'show_featured_post', true);
$layout = safe_get($blog_settings, 'layout', 'sidebar');

// Sidebar settings with fallbacks
$newsletter_title = safe_get($sidebar_settings, 'newsletter_title', 'Stay Updated');
$newsletter_desc = safe_get($sidebar_settings, 'newsletter_description', 'Get the latest blog posts and travel tips delivered to your inbox.');
$show_recent = safe_get($sidebar_settings, 'show_recent_posts', true);
$recent_count = safe_get($sidebar_settings, 'recent_posts_count', 5);
$show_categories = safe_get($sidebar_settings, 'show_categories', true);

// Determine background style
$has_custom_bg = $bg_image || $bg_video;
$header_bg = $has_custom_bg ? 'transparent' : 'linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%)';
?>

<main class="main-content">
    <!-- Blog Header -->
    <header class="blog-header" style="position: relative; padding: 8rem 0 4rem; background: <?php echo $header_bg; ?>; color: white; text-align: center; overflow: hidden;">
        
        <?php if ($bg_image) : ?>
            <div class="hero-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($bg_image['url']); ?>'); background-size: cover; background-position: center; opacity: 0.3; z-index: 1;"></div>
        <?php endif; ?>
        
        <?php if ($bg_video) : ?>
            <div class="hero-bg-video" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                <?php if (strpos($bg_video, 'youtube.com') !== false || strpos($bg_video, 'youtu.be') !== false) : ?>
                    <?php
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $bg_video, $matches);
                    $video_id = $matches[1] ?? '';
                    ?>
                    <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($video_id); ?>&controls=0&showinfo=0&rel=0" frameborder="0" allow="autoplay; encrypted-media" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.3; pointer-events: none;"></iframe>
                <?php else : ?>
                    <video autoplay muted loop style="width: 100%; height: 100%; object-fit: cover; opacity: 0.3; pointer-events: none;">
                        <source src="<?php echo esc_url($bg_video); ?>" type="video/mp4">
                    </video>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 10;">
            <div class="blog-badge" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); padding: 0.5rem 1.5rem; border-radius: 50px; margin-bottom: 2rem; display: inline-block; font-size: 0.9rem; font-weight: 500;">
                <?php echo esc_html($badge_text); ?>
            </div>
            <h1 class="blog-title" style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">
                <?php
                $title_html = str_replace($title_highlight, '<span style="color: #2dd4bf;">' . $title_highlight . '</span>', $blog_title);
                echo wp_kses($title_html, array('span' => array('style' => array())));
                ?>
            </h1>
            <p class="blog-description" style="font-size: 1.25rem; opacity: 0.9; margin-bottom: 2rem;">
                <?php echo esc_html($blog_description); ?>
            </p>
            
            <!-- Blog Categories Filter -->
            <div class="blog-categories" style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="<?php echo get_permalink(get_page_by_path('blog')); ?>" class="category-filter <?php echo !isset($_GET['category']) ? 'active' : ''; ?>" style="background: rgba(255,255,255,0.2); color: white; padding: 0.5rem 1rem; border-radius: 25px; text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease;">
                    All Posts
                </a>
                <?php
                $categories = get_categories(array('hide_empty' => true));
                $current_cat = isset($_GET['category']) ? $_GET['category'] : '';
                foreach ($categories as $category) :
                ?>
                    <a href="<?php echo add_query_arg('category', $category->slug, get_permalink(get_page_by_path('blog'))); ?>" 
                       class="category-filter <?php echo $current_cat == $category->slug ? 'active' : ''; ?>" 
                       style="background: rgba(255,255,255,0.2); color: white; padding: 0.5rem 1rem; border-radius: 25px; text-decoration: none; font-size: 0.9rem; transition: all 0.3s ease;">
                        <?php echo $category->name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </header>

    <!-- Blog Content -->
    <section class="blog-content" style="padding: 4rem 0; background: #f8fafc;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <div class="blog-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem; align-items: start;">
                
                <!-- Main Blog Posts -->
                <div class="blog-posts">
                    <?php
                    // Get posts based on category filter and ACF settings
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => $posts_per_page,
                        'paged' => $paged,
                        'post_status' => 'publish'
                    );
                    
                    if (isset($_GET['category']) && !empty($_GET['category'])) {
                        $args['category_name'] = sanitize_text_field($_GET['category']);
                    }
                    
                    $blog_posts = new WP_Query($args);
                    
                    if ($blog_posts->have_posts()) :
                    ?>
                        <div class="posts-grid" style="display: grid; gap: 2rem;">
                            <?php $post_count = 0; ?>
                            <?php while ($blog_posts->have_posts()) : $blog_posts->the_post(); ?>
                                <?php $post_count++; ?>
                                
                                <!-- Featured Post (First Post) -->
                                <?php if ($post_count == 1 && $paged == 1 && $show_featured) : ?>
                                    <article class="featured-post" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.1); margin-bottom: 3rem;">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="post-image" style="height: 400px; overflow: hidden; position: relative;">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                                </a>
                                                <div class="featured-badge" style="position: absolute; top: 1.5rem; left: 1.5rem; background: #2dd4bf; color: white; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.8rem; font-weight: 600;">
                                                    Featured
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="post-content" style="padding: 3rem;">
                                            <div class="post-meta" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #64748b;">
                                                <span>📅 <?php echo get_the_date(); ?></span>
                                                <span>👤 <?php the_author(); ?></span>
                                                <span>🏷️ <?php the_category(', '); ?></span>
                                            </div>
                                            
                                            <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #1e293b;">
                                                <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>
                                            
                                            <div class="post-excerpt" style="color: #64748b; font-size: 1.1rem; line-height: 1.7; margin-bottom: 2rem;">
                                                <?php the_excerpt(); ?>
                                            </div>
                                            
                                            <a href="<?php the_permalink(); ?>" class="read-more-btn" style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                                                Read Full Article →
                                            </a>
                                        </div>
                                    </article>
                                
                                <!-- Regular Posts -->
                                <?php else : ?>
                                    <article class="blog-post-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                                        <div style="display: grid; grid-template-columns: 250px 1fr; gap: 0; height: 200px;">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="post-image" style="overflow: hidden;">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                                    </a>
                                                </div>
                                            <?php else : ?>
                                                <div style="background: linear-gradient(135deg, #e2e8f0, #cbd5e1); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 2rem;">
                                                    📝
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="post-content" style="padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                                                <div>
                                                    <div class="post-meta" style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b;">
                                                        <span>📅 <?php echo get_the_date('M j'); ?></span>
                                                        <span>🏷️ <?php the_category(', '); ?></span>
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
                                                
                                                <a href="<?php the_permalink(); ?>" style="color: #2dd4bf; font-weight: 600; text-decoration: none; font-size: 0.9rem; margin-top: 1rem;">
                                                    Read More →
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="blog-pagination" style="margin-top: 3rem; text-align: center;">
                            <?php
                            echo paginate_links(array(
                                'total' => $blog_posts->max_num_pages,
                                'current' => $paged,
                                'format' => '?paged=%#%',
                                'prev_text' => '← Previous',
                                'next_text' => 'Next →',
                            ));
                            ?>
                        </div>

                    <?php else : ?>
                        <div class="no-posts" style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 20px;">
                            <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1e293b;">No Blog Posts Found</h3>
                            <p style="color: #64748b; margin-bottom: 2rem;">We haven't published any blog posts yet. Check back soon for exciting content!</p>
                            <a href="<?php echo home_url(); ?>" class="btn btn-primary" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                                Explore Tours Instead →
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <?php wp_reset_postdata(); ?>
                </div>

                <!-- Blog Sidebar -->
                <aside class="blog-sidebar">
                    <!-- Search Widget -->
                    <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">Search Blog</h3>
                        <form role="search" method="get" action="<?php echo home_url('/'); ?>" style="position: relative;">
                            <input type="search" name="s" placeholder="Search blog posts..." style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 1rem;" value="<?php echo get_search_query(); ?>">
                            <button type="submit" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: #2dd4bf; color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">🔍</button>
                        </form>
                    </div>

                    <!-- Recent Posts -->
                    <?php if ($show_recent) : ?>
                    <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Recent Posts</h3>
                        <?php
                        $recent_posts = wp_get_recent_posts(array('numberposts' => $recent_count, 'post_status' => 'publish'));
                        foreach ($recent_posts as $recent) :
                        ?>
                            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                <div style="flex-shrink: 0;">
                                    <?php if (has_post_thumbnail($recent['ID'])) : ?>
                                        <?php echo get_the_post_thumbnail($recent['ID'], 'thumbnail', array('style' => 'width: 60px; height: 60px; object-fit: cover; border-radius: 8px;')); ?>
                                    <?php else : ?>
                                        <div style="width: 60px; height: 60px; background: #e2e8f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b;">📝</div>
                                    <?php endif; ?>
                                </div>
                                <div style="flex: 1;">
                                    <a href="<?php echo get_permalink($recent['ID']); ?>" style="text-decoration: none; color: #1e293b; font-weight: 600; font-size: 0.9rem; line-height: 1.4;">
                                        <?php echo wp_trim_words($recent['post_title'], 8); ?>
                                    </a>
                                    <div style="color: #64748b; font-size: 0.8rem; margin-top: 0.25rem;">
                                        <?php echo get_the_date('M j, Y', $recent['ID']); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Categories -->
                    <?php if ($show_categories) : ?>
                    <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Categories</h3>
                        <?php
                        $categories = get_categories(array('hide_empty' => true));
                        foreach ($categories as $category) :
                        ?>
                            <a href="<?php echo add_query_arg('category', $category->slug, get_permalink(get_page_by_path('blog'))); ?>" 
                               style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; text-decoration: none; color: #64748b; border-bottom: 1px solid #f1f5f9; transition: color 0.3s ease;">
                                <span><?php echo $category->name; ?></span>
                                <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.8rem;">
                                    <?php echo $category->count; ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Newsletter Signup -->
                    <div class="sidebar-widget" style="background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; text-align: center;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;"><?php echo esc_html($newsletter_title); ?></h3>
                        <p style="opacity: 0.9; margin-bottom: 1.5rem; font-size: 0.9rem;"><?php echo esc_html($newsletter_desc); ?></p>
                        <form style="display: flex; flex-direction: column; gap: 1rem;">
                            <input type="email" placeholder="Your email address" style="padding: 0.75rem; border: none; border-radius: 8px; font-size: 0.9rem;">
                            <button type="submit" style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 0.75rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                Subscribe →
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>

<style>
.category-filter.active {
    background: rgba(255,255,255,0.3) !important;
    font-weight: 600;
}

.blog-post-card:hover {
    transform: translateY(-5px);
}

.blog-post-card:hover img {
    transform: scale(1.05);
}

.sidebar-widget a:hover {
    color: #2dd4bf !important;
}

.blog-pagination .page-numbers {
    display: inline-block;
    padding: 0.5rem 1rem;
    margin: 0 0.25rem;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    text-decoration: none;
    color: #64748b;
    transition: all 0.3s ease;
}

.blog-pagination .page-numbers:hover,
.blog-pagination .page-numbers.current {
    background: #2dd4bf;
    color: white;
    border-color: #2dd4bf;
}

@media (max-width: 768px) {
    .blog-layout {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .blog-post-card > div {
        grid-template-columns: 120px 1fr !important;
        height: auto !important;
    }
    
    .blog-categories {
        justify-content: flex-start !important;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
}
</style>

<?php get_footer(); ?>
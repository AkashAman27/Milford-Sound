<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    // Get ACF fields for blog posts
    $post_settings = get_field('post_settings');
    $post_hero = get_field('post_hero');
    $post_gallery = get_field('post_gallery');
    $post_video = get_field('post_video');
    $post_location = get_field('post_location');
    $travel_tips = get_field('travel_tips');
    $weather_info = get_field('weather_info');
    $related_tours = get_field('related_tours');
    $post_cta = get_field('post_cta');
    
    // Get post layout
    $post_layout = safe_get($post_settings, 'post_layout', 'standard');
    $featured_post = safe_get($post_settings, 'featured_post', false);
    $reading_time_override = safe_get($post_settings, 'reading_time_override');
    $post_difficulty = safe_get($post_settings, 'post_difficulty', 'beginner');
    
    // Hero background
    $hero_bg = safe_get($post_hero, 'hero_background_image');
    $hero_overlay = safe_get($post_hero, 'hero_overlay_color', 'rgba(30, 64, 175, 0.8)');
    $custom_excerpt = safe_get($post_hero, 'custom_excerpt');
    ?>

    <main class="main-content single-blog-post">
        
        <!-- Blog Post Header -->
        <header class="blog-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; text-align: center; overflow: hidden;">
            
            <?php if ($hero_bg) : ?>
                <div class="hero-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($hero_bg['url']); ?>'); background-size: cover; background-position: center; z-index: -1;"></div>
                <div class="hero-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: <?php echo esc_attr($hero_overlay); ?>; z-index: 0;"></div>
            <?php elseif (has_post_thumbnail()) : ?>
                <div class="hero-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.3; z-index: -1;">
                    <?php the_post_thumbnail('full', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                </div>
            <?php endif; ?>
            
            <div class="container" style="max-width: 800px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
                
                <!-- Featured Badge -->
                <?php if ($featured_post) : ?>
                    <div style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.8rem; font-weight: 600; display: inline-block; margin-bottom: 1rem;">
                        ⭐ Featured Post
                    </div>
                <?php endif; ?>
                
                <!-- Post Categories -->
                <div class="post-categories" style="margin-bottom: 1rem;">
                    <?php 
                    $categories = get_the_category();
                    if ($categories) :
                        foreach ($categories as $category) :
                    ?>
                        <a href="<?php echo get_category_link($category->term_id); ?>" style="background: rgba(255,255,255,0.2); color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem; text-decoration: none;">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                </div>
                
                <h1 class="entry-title" style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">
                    <?php the_title(); ?>
                </h1>
                
                <!-- Custom or Regular Excerpt -->
                <?php if ($custom_excerpt) : ?>
                    <p class="post-excerpt" style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9; line-height: 1.6;">
                        <?php echo esc_html($custom_excerpt); ?>
                    </p>
                <?php else : ?>
                    <p class="post-excerpt" style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9; line-height: 1.6;">
                        <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                    </p>
                <?php endif; ?>
                
                <!-- Post Meta -->
                <div class="post-meta" style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; opacity: 0.9; margin-bottom: 2rem;">
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                        <span>📅</span>
                        <span><?php echo get_the_date('F j, Y'); ?></span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                        <span>👤</span>
                        <span><?php the_author(); ?></span>
                    </span>
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                        <span>⏱️</span>
                        <span><?php echo $reading_time_override ?: reading_time(); ?> min read</span>
                    </span>
                    <?php if ($post_difficulty) : ?>
                        <span style="display: flex; align-items: center; gap: 0.5rem;">
                            <span>📊</span>
                            <span><?php echo esc_html(ucfirst($post_difficulty)); ?></span>
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Weather Info (if available) -->
                <?php if ($weather_info && (safe_get($weather_info, 'temperature') || safe_get($weather_info, 'conditions'))) : ?>
                    <div class="weather-info" style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 25px; display: inline-flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                        <?php if (safe_get($weather_info, 'conditions')) : ?>
                            <span><?php echo esc_html(safe_get($weather_info, 'conditions')); ?></span>
                        <?php endif; ?>
                        <?php if (safe_get($weather_info, 'temperature')) : ?>
                            <span><?php echo esc_html(safe_get($weather_info, 'temperature')); ?></span>
                        <?php endif; ?>
                        <?php if (safe_get($weather_info, 'weather_date')) : ?>
                            <span style="font-size: 0.9rem; opacity: 0.8;"><?php echo date('M j', strtotime(safe_get($weather_info, 'weather_date'))); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Social Share Buttons -->
                <div class="social-share" style="display: flex; justify-content: center; gap: 1rem;">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" style="background: rgba(255,255,255,0.2); color: white; padding: 0.5rem 1rem; border-radius: 25px; text-decoration: none; font-size: 0.9rem;">📘 Share</a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" style="background: rgba(255,255,255,0.2); color: white; padding: 0.5rem 1rem; border-radius: 25px; text-decoration: none; font-size: 0.9rem;">🐦 Tweet</a>
                    <button onclick="copyToClipboard('<?php echo get_permalink(); ?>')" style="background: rgba(255,255,255,0.2); color: white; border: none; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.9rem; cursor: pointer;">🔗 Copy Link</button>
                </div>
                
            </div>
        </header>

        <!-- Post Content -->
        <div class="post-content-wrapper" style="max-width: 1000px; margin: 4rem auto; padding: 0 2rem;">
            
            <!-- Video Content (if video layout) -->
            <?php if ($post_layout === 'video' && $post_video && safe_get($post_video, 'video_url')) : ?>
                <div class="post-video" style="margin-bottom: 3rem; text-align: center;">
                    <div style="background: #000; border-radius: 15px; overflow: hidden; position: relative; max-width: 800px; margin: 0 auto;">
                        <?php
                        $video_url = safe_get($post_video, 'video_url');
                        if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) :
                            // YouTube embed
                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $video_url, $matches);
                            $video_id = $matches[1] ?? '';
                            if ($video_id) :
                        ?>
                            <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" frameborder="0" allowfullscreen style="width: 100%; height: 400px;"></iframe>
                        <?php 
                            endif;
                        elseif (strpos($video_url, 'vimeo.com') !== false) :
                            // Vimeo embed
                            preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches);
                            $video_id = $matches[1] ?? '';
                            if ($video_id) :
                        ?>
                            <iframe src="https://player.vimeo.com/video/<?php echo esc_attr($video_id); ?>" frameborder="0" allowfullscreen style="width: 100%; height: 400px;"></iframe>
                        <?php 
                            endif;
                        else : 
                        ?>
                            <video controls style="width: 100%; height: auto;">
                                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                        
                        <?php if (safe_get($post_video, 'video_duration')) : ?>
                            <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.8); color: white; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem;">
                                <?php echo esc_html(safe_get($post_video, 'video_duration')); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Gallery Content (if gallery layout) -->
            <?php if ($post_layout === 'gallery' && $post_gallery && !empty($post_gallery)) : ?>
                <div class="post-gallery-section" style="margin-bottom: 3rem;">
                    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                        <?php foreach ($post_gallery as $image) : ?>
                            <div class="gallery-item" style="aspect-ratio: 4/3; overflow: hidden; border-radius: 15px; cursor: pointer;">
                                <img src="<?php echo esc_url($image['sizes']['medium_large']); ?>" 
                                     alt="<?php echo esc_attr($image['alt']); ?>"
                                     style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Featured Image (for standard/large_featured layouts) -->
            <?php if ($post_layout !== 'video' && $post_layout !== 'gallery' && has_post_thumbnail()) : ?>
                <div class="post-thumbnail" style="margin-bottom: 3rem; text-align: center;">
                    <?php if ($post_layout === 'large_featured') : ?>
                        <?php the_post_thumbnail('full', array('style' => 'width: 100%; height: auto; border-radius: 15px; box-shadow: 0 15px 40px rgba(0,0,0,0.2);')); ?>
                    <?php else : ?>
                        <?php the_post_thumbnail('large', array('style' => 'max-width: 100%; height: auto; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2);')); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="entry-content" style="max-width: 800px; margin: 0 auto; line-height: 1.8; font-size: 1.1rem;">
                <?php the_content(); ?>
            </div>
            
            <!-- Location Information -->
            <?php if ($post_location && (safe_get($post_location, 'location_name') || safe_get($post_location, 'location_coordinates'))) : ?>
                <div class="location-section" style="background: #f8fafc; padding: 3rem; border-radius: 20px; margin: 3rem auto; max-width: 800px;">
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                        <span>📍</span> Location Information
                    </h3>
                    
                    <div style="display: grid; gap: 1rem;">
                        <?php if (safe_get($post_location, 'location_name')) : ?>
                            <div style="display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #e2e8f0;">
                                <span style="font-weight: 600; color: #64748b;">Location:</span>
                                <span style="color: #1e293b;"><?php echo esc_html(safe_get($post_location, 'location_name')); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (safe_get($post_location, 'best_time_visit')) : ?>
                            <div style="display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #e2e8f0;">
                                <span style="font-weight: 600; color: #64748b;">Best Time to Visit:</span>
                                <span style="color: #1e293b;"><?php echo esc_html(safe_get($post_location, 'best_time_visit')); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (safe_get($post_location, 'difficulty_level')) : ?>
                            <div style="display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #e2e8f0;">
                                <span style="font-weight: 600; color: #64748b;">Difficulty Level:</span>
                                <span style="color: #1e293b;"><?php echo esc_html(ucfirst(safe_get($post_location, 'difficulty_level'))); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (safe_get($post_location, 'location_coordinates')) : ?>
                            <div style="display: flex; justify-content: space-between; padding: 1rem 0;">
                                <span style="font-weight: 600; color: #64748b;">GPS Coordinates:</span>
                                <span style="color: #1e293b; font-family: monospace;"><?php echo esc_html(safe_get($post_location, 'location_coordinates')); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (safe_get($post_location, 'show_map') && safe_get($post_location, 'location_coordinates')) : ?>
                        <div style="margin-top: 2rem; text-align: center;">
                            <a href="https://www.google.com/maps?q=<?php echo urlencode(safe_get($post_location, 'location_coordinates')); ?>" target="_blank" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600;">
                                🗺️ View on Google Maps
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <!-- Travel Tips -->
            <?php if ($travel_tips && !empty($travel_tips)) : ?>
                <div class="travel-tips-section" style="background: white; padding: 3rem; border-radius: 20px; margin: 3rem auto; max-width: 800px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                        <span>💡</span> Travel Tips
                    </h3>
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <?php foreach ($travel_tips as $tip) : ?>
                            <div class="tip-item" style="background: #f8fafc; padding: 1.5rem; border-radius: 15px; border-left: 4px solid #2dd4bf;">
                                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                    <span style="font-size: 1.5rem; flex-shrink: 0;"><?php echo esc_html(safe_get($tip, 'tip_icon')); ?></span>
                                    <div style="flex: 1;">
                                        <?php if (safe_get($tip, 'tip_title')) : ?>
                                            <h4 style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                                                <?php echo esc_html(safe_get($tip, 'tip_title')); ?>
                                            </h4>
                                        <?php endif; ?>
                                        <p style="color: #64748b; line-height: 1.6; margin: 0;">
                                            <?php echo esc_html(safe_get($tip, 'tip_content')); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Related Tours -->
            <?php if ($related_tours && !empty($related_tours)) : ?>
                <div class="related-tours-section" style="background: #f8fafc; padding: 3rem; border-radius: 20px; margin: 3rem auto; max-width: 800px;">
                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                        <span>🎯</span> Related Tours
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <?php foreach ($related_tours as $tour) : ?>
                            <?php
                            $tour_overview = get_field('tour_overview', $tour->ID);
                            ?>
                            <div class="related-tour-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: transform 0.3s ease;">
                                <?php if (has_post_thumbnail($tour->ID)) : ?>
                                    <div style="height: 150px; overflow: hidden;">
                                        <a href="<?php echo get_permalink($tour->ID); ?>">
                                            <?php echo get_the_post_thumbnail($tour->ID, 'medium', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div style="padding: 1.5rem;">
                                    <h4 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                                        <a href="<?php echo get_permalink($tour->ID); ?>" style="text-decoration: none; color: #1e293b;">
                                            <?php echo esc_html($tour->post_title); ?>
                                        </a>
                                    </h4>
                                    
                                    <?php if ($tour_overview && safe_get($tour_overview, 'tour_price')) : ?>
                                        <div style="color: #2dd4bf; font-weight: 600; margin-bottom: 1rem;">
                                            <?php echo esc_html(safe_get($tour_overview, 'tour_price')); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo get_permalink($tour->ID); ?>" style="background: #2dd4bf; color: white; padding: 0.5rem 1rem; border-radius: 20px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                        View Tour →
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Custom CTA -->
            <?php if ($post_cta && safe_get($post_cta, 'cta_enabled') && safe_get($post_cta, 'cta_title')) : ?>
                <div class="custom-cta" style="margin: 3rem auto; max-width: 800px; text-align: center; padding: 3rem; border-radius: 20px; 
                    <?php if (safe_get($post_cta, 'cta_style') === 'gradient') : ?>
                        background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white;
                    <?php elseif (safe_get($post_cta, 'cta_style') === 'bordered') : ?>
                        background: white; border: 2px solid #2dd4bf; color: #1e293b;
                    <?php else : ?>
                        background: #f8fafc; color: #1e293b;
                    <?php endif; ?>
                ">
                    <h3 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">
                        <?php echo esc_html(safe_get($post_cta, 'cta_title')); ?>
                    </h3>
                    
                    <?php if (safe_get($post_cta, 'cta_text')) : ?>
                        <p style="font-size: 1.1rem; margin-bottom: 2rem; <?php echo safe_get($post_cta, 'cta_style') === 'gradient' ? 'opacity: 0.9;' : ''; ?>">
                            <?php echo esc_html(safe_get($post_cta, 'cta_text')); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if (safe_get($post_cta, 'cta_button')) : ?>
                        <a href="<?php echo esc_url(safe_get(safe_get($post_cta, 'cta_button'), 'url')); ?>" 
                           style="
                               <?php if (safe_get($post_cta, 'cta_style') === 'gradient') : ?>
                                   background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);
                               <?php else : ?>
                                   background: #2dd4bf; color: white;
                               <?php endif; ?>
                               padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s ease;
                           "
                           <?php if (safe_get(safe_get($post_cta, 'cta_button'), 'target')) echo 'target="' . esc_attr(safe_get(safe_get($post_cta, 'cta_button'), 'target')) . '"'; ?>>
                            <?php echo esc_html(safe_get(safe_get($post_cta, 'cta_button'), 'title')); ?> →
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
        </div>
        
        <!-- Post Navigation -->
        <div style="max-width: 800px; margin: 4rem auto 0; padding: 0 2rem;">
            <?php
            the_post_navigation(array(
                'prev_text' => '<span style="color: #64748b;">Previous Post</span><br><span style="font-weight: 600; color: #1e293b;">%title</span>',
                'next_text' => '<span style="color: #64748b;">Next Post</span><br><span style="font-weight: 600; color: #1e293b;">%title</span>',
            ));
            ?>
        </div>
        
    </main>

<?php endwhile; ?>

<style>
/* Blog Post Specific Styles */
.related-tour-card:hover {
    transform: translateY(-3px);
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.tip-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.custom-cta a:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(45, 212, 191, 0.4);
}

/* Copy to clipboard function */
</style>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '✓ Copied!';
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
    });
}
</script>

<?php get_footer(); ?>
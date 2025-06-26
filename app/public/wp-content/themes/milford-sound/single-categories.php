<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    // Get ACF fields for category pages
    $category_hero = get_field('category_hero') ?: array();
    $featured_tours = get_field('featured_tours') ?: array();
    $pro_tips = get_field('pro_tips') ?: array();
    $similar_things = get_field('similar_things') ?: array();
    $about_section = get_field('about_section') ?: array();
    
    // Helper function for safe array access
    if (!function_exists('safe_get')) {
        function safe_get($array, $key, $default = '') {
            return (is_array($array) && isset($array[$key])) ? $array[$key] : $default;
        }
    }
    ?>

    <main class="main-content single-category headout-style">
        
        <!-- Category Hero Section -->
        <section class="category-hero" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 4rem 0 2rem; color: white;">
            <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
                    
                    <!-- Hero Content -->
                    <div class="hero-content">
                        <div class="rank-badge" style="background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 20px; display: inline-block; font-size: 0.9rem; margin-bottom: 1rem;">
                            📍 <?php echo esc_html(safe_get($category_hero, 'rank_badge', '#1 out of 127 in ' . get_the_title())); ?>
                        </div>
                        
                        <h1 style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 1rem; line-height: 1.2;">
                            <?php echo esc_html(safe_get($category_hero, 'title', 'Experience only the best of ' . get_the_title() . ' Tickets')); ?>
                        </h1>
                        
                        <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 2rem; line-height: 1.6;">
                            <?php echo esc_html(safe_get($category_hero, 'subtitle', "We've done the hard work - Find only the best experiences from hundreds of them so you can choose easily.")); ?>
                        </p>
                        
                        <!-- Hero Stats -->
                        <?php 
                        $hero_stats = safe_get($category_hero, 'hero_stats', array());
                        
                        // Debug: Let's see what's in the hero stats
                        if (current_user_can('administrator')) {
                            echo '<!-- DEBUG: Hero Stats data: ' . print_r($hero_stats, true) . ' -->';
                            echo '<!-- DEBUG: Category Hero data: ' . print_r($category_hero, true) . ' -->';
                        }
                        
                        // Check if hero_stats has data but all fields are empty
                        $has_empty_data = false;
                        if (!empty($hero_stats)) {
                            $has_empty_data = true;
                            foreach ($hero_stats as $stat) {
                                if (!empty($stat['icon']) || !empty($stat['number']) || !empty($stat['text']) || !empty($stat['subtext'])) {
                                    $has_empty_data = false;
                                    break;
                                }
                            }
                        }
                        
                        // Add default stats if none are set OR if all fields are empty
                        if (empty($hero_stats) || $has_empty_data) {
                            $hero_stats = array(
                                array('icon' => '❤️', 'number' => '4.4/5', 'text' => '107.3K+ travellers love this', 'subtext' => 'See what they have to say'),
                                array('icon' => '📍', 'number' => "Visitor's guide", 'text' => 'Must-see highlights & key info', 'subtext' => '')
                            );
                        }
                        if (!empty($hero_stats)) : 
                        ?>
                            <div class="hero-stats" style="display: flex; gap: 2rem; flex-wrap: wrap;">
                                <?php foreach ($hero_stats as $stat) : ?>
                                    <div class="stat-item" style="background: rgba(255,255,255,0.1); padding: 1rem 1.5rem; border-radius: 15px; backdrop-filter: blur(10px);">
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                            <span style="font-size: 1.2rem;"><?php echo esc_html(safe_get($stat, 'icon')); ?></span>
                                            <span style="font-weight: 700; font-size: 1.1rem;"><?php echo esc_html(safe_get($stat, 'number')); ?></span>
                                        </div>
                                        <div style="font-size: 0.9rem; opacity: 0.9;"><?php echo esc_html(safe_get($stat, 'text')); ?></div>
                                        <?php if (safe_get($stat, 'subtext')) : ?>
                                            <div style="font-size: 0.8rem; opacity: 0.7;"><?php echo esc_html(safe_get($stat, 'subtext')); ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Hero Video -->
                    <?php 
                    $hero_video = safe_get($category_hero, 'hero_video', array());
                    $video_url = safe_get($hero_video, 'video_url');
                    $video_thumbnail = safe_get($hero_video, 'video_thumbnail');
                    
                    // Function to extract YouTube video ID
                    function get_youtube_id($url) {
                        if (empty($url)) return false;
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
                        return isset($matches[1]) ? $matches[1] : false;
                    }
                    
                    // Auto-generate YouTube thumbnail if no custom thumbnail is set
                    $youtube_id = get_youtube_id($video_url);
                    $auto_thumbnail = $youtube_id ? "https://img.youtube.com/vi/{$youtube_id}/maxresdefault.jpg" : '';
                    
                    if ($video_thumbnail || $video_url) : 
                    ?>
                        <div class="hero-video" style="width: 100%;">
                            <?php if ($youtube_id) : ?>
                                <!-- Embedded YouTube Video with Autoplay -->
                                <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); aspect-ratio: 16/9;">
                                    <iframe 
                                        src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>?autoplay=1&mute=1&controls=1&rel=0&modestbranding=1&loop=1&playlist=<?php echo esc_attr($youtube_id); ?>"
                                        style="width: 100%; height: 100%; border: none;"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                        loading="lazy">
                                    </iframe>
                                </div>
                            <?php else : ?>
                                <!-- Fallback with thumbnail and play button for non-YouTube videos -->
                                <div style="position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); aspect-ratio: 16/9;">
                                    <?php if ($video_thumbnail && safe_get($video_thumbnail, 'url')) : ?>
                                        <!-- Custom thumbnail uploaded -->
                                        <img src="<?php echo esc_url(safe_get($video_thumbnail, 'url')); ?>" 
                                             alt="Video thumbnail" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php elseif ($auto_thumbnail) : ?>
                                        <!-- Auto YouTube thumbnail -->
                                        <img src="<?php echo esc_url($auto_thumbnail); ?>" 
                                             alt="YouTube Video Thumbnail" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else : ?>
                                        <!-- Fallback placeholder -->
                                        <div style="width: 100%; height: 100%; background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.1) 75%), linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%, transparent 75%, rgba(255,255,255,0.1) 75%); background-size: 20px 20px; background-position: 0 0, 10px 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                                            🎥 Video Placeholder
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($video_url) : ?>
                                        <!-- Play button for non-YouTube videos -->
                                        <div class="play-button" 
                                             onclick="openVideoModal('<?php echo esc_js($video_url); ?>')"
                                             style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; background: rgba(255,255,255,0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                                            <span style="font-size: 2rem; margin-left: 8px; color: #667eea;">▶</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </section>

        <!-- Featured Tours Section -->
        <?php 
        // Add default tour if none are set
        if (empty($featured_tours)) {
            $featured_tours = array(
                array(
                    'tour_images' => array(
                        array('url' => 'https://via.placeholder.com/400x300/667eea/ffffff?text=Tour+Image+1'),
                        array('url' => 'https://via.placeholder.com/400x300/764ba2/ffffff?text=Tour+Image+2'),
                        array('url' => 'https://via.placeholder.com/400x300/2dd4bf/ffffff?text=Tour+Image+3')
                    ),
                    'rating' => '4.4',
                    'review_count' => '(32,849)',
                    'tour_type' => 'Tickets',
                    'title' => get_the_title() . ' Experience: Premium Access',
                    'features' => array(
                        array('icon' => '⚡', 'text' => 'Instant confirmation'),
                        array('icon' => '🕐', 'text' => 'Flexible duration'),
                        array('icon' => '📱', 'text' => 'Mobile ticket')
                    ),
                    'highlights' => array(
                        array('text' => 'Level up your experience with premium access and exclusive benefits.'),
                        array('text' => 'Skip the regular lines with our fast-track entry system.'),
                        array('text' => 'Professional guide included for the ultimate experience.')
                    ),
                    'price_from' => '$99',
                    'cta_text' => 'Check availability',
                    'tour_link' => array('url' => '#'),
                    'badges' => array(
                        array('text' => 'Free cancellation', 'type' => 'success')
                    )
                )
            );
        }
        if (!empty($featured_tours)) : 
        ?>
            <section class="featured-tours" style="padding: 4rem 0; background: #f8fafc;">
                <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                    <div class="tours-grid" style="display: flex; flex-direction: column; gap: 2rem;">
                        
                        <?php foreach ($featured_tours as $index => $tour) : ?>
                            <div class="tour-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; display: grid; grid-template-columns: 400px 1fr; min-height: 300px;">
                                
                                <!-- Tour Image Carousel -->
                                <?php 
                                $tour_images = safe_get($tour, 'tour_images', array());
                                // Handle both gallery format and fallback single image
                                if (empty($tour_images) && safe_get($tour, 'tour_image')) {
                                    $tour_images = array(safe_get($tour, 'tour_image'));
                                }
                                if (!empty($tour_images)) : 
                                ?>
                                    <div class="tour-image-carousel" style="position: relative; height: 100%; overflow: hidden;">
                                        <!-- Main Image Display -->
                                        <div class="carousel-images" style="position: relative; width: 100%; height: 100%;">
                                            <?php foreach ($tour_images as $img_index => $image) : ?>
                                                <img src="<?php echo esc_url(safe_get($image, 'url')); ?>" 
                                                     alt="<?php echo esc_attr(safe_get($tour, 'title')); ?> - Image <?php echo $img_index + 1; ?>"
                                                     class="carousel-image <?php echo $img_index === 0 ? 'active' : ''; ?>"
                                                     data-index="<?php echo $img_index; ?>"
                                                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: <?php echo $img_index === 0 ? '1' : '0'; ?>; transition: opacity 0.5s ease;">
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <!-- Navigation Arrows -->
                                        <?php if (count($tour_images) > 1) : ?>
                                            <button class="carousel-prev" onclick="changeImage(this, -1)" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10;">‹</button>
                                            <button class="carousel-next" onclick="changeImage(this, 1)" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10;">›</button>
                                        <?php endif; ?>
                                        
                                        <!-- Image Indicators -->
                                        <?php if (count($tour_images) > 1) : ?>
                                            <div class="carousel-indicators" style="position: absolute; bottom: 1rem; left: 50%; transform: translateX(-50%); display: flex; gap: 0.5rem; z-index: 10;">
                                                <?php foreach ($tour_images as $img_index => $image) : ?>
                                                    <span class="indicator <?php echo $img_index === 0 ? 'active' : ''; ?>" 
                                                          onclick="goToImage(this, <?php echo $img_index; ?>)"
                                                          data-index="<?php echo $img_index; ?>"
                                                          style="width: 8px; height: 8px; border-radius: 50%; background: <?php echo $img_index === 0 ? 'white' : 'rgba(255,255,255,0.5)'; ?>; cursor: pointer; transition: background 0.3s ease;"></span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Tour Badges -->
                                        <?php 
                                        $badges = safe_get($tour, 'badges', array());
                                        if (!empty($badges)) : 
                                        ?>
                                            <div class="tour-badges" style="position: absolute; top: 1rem; left: 1rem; display: flex; flex-direction: column; gap: 0.5rem; z-index: 10;">
                                                <?php foreach ($badges as $badge) : ?>
                                                    <?php
                                                    $badge_colors = array(
                                                        'success' => 'background: #22c55e; color: white;',
                                                        'warning' => 'background: #f59e0b; color: white;',
                                                        'info' => 'background: #3b82f6; color: white;',
                                                        'urgent' => 'background: #ef4444; color: white;'
                                                    );
                                                    $badge_style = $badge_colors[safe_get($badge, 'type', 'success')] ?? $badge_colors['success'];
                                                    ?>
                                                    <span style="<?php echo $badge_style; ?> padding: 0.5rem 1rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                                        <?php echo esc_html(safe_get($badge, 'text')); ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Tour Content -->
                                <div class="tour-content" style="padding: 2rem;">
                                    
                                    <!-- Rating and Type -->
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <?php if (safe_get($tour, 'rating')) : ?>
                                                <span style="background: #fee2e2; color: #dc2626; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                                    ⭐ <?php echo esc_html(safe_get($tour, 'rating')); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (safe_get($tour, 'review_count')) : ?>
                                                <span style="color: #64748b; font-size: 0.9rem;"><?php echo esc_html(safe_get($tour, 'review_count')); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (safe_get($tour, 'tour_type')) : ?>
                                            <span style="background: #e0e7ff; color: #3730a3; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600;">
                                                <?php echo esc_html(safe_get($tour, 'tour_type')); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Tour Title -->
                                    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.3;">
                                        <?php echo esc_html(safe_get($tour, 'title')); ?>
                                    </h3>
                                    
                                    <!-- Tour Features -->
                                    <?php 
                                    $features = safe_get($tour, 'features', array());
                                    if (!empty($features)) : 
                                    ?>
                                        <div class="tour-features" style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                                            <?php foreach ($features as $feature) : ?>
                                                <div style="display: flex; align-items: center; gap: 0.5rem; color: #64748b; font-size: 0.9rem;">
                                                    <span><?php echo esc_html(safe_get($feature, 'icon')); ?></span>
                                                    <span><?php echo esc_html(safe_get($feature, 'text')); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Tour Highlights -->
                                    <?php 
                                    $highlights = safe_get($tour, 'highlights', array());
                                    
                                    // Debug: Let's see what's in the highlights array
                                    if (current_user_can('administrator')) {
                                        echo '<!-- DEBUG: Highlights data: ' . print_r($highlights, true) . ' -->';
                                    }
                                    
                                    if (!empty($highlights)) : 
                                    ?>
                                        <ul style="list-style: none; padding: 0; margin-bottom: 1.5rem;">
                                            <?php foreach ($highlights as $highlight) : ?>
                                                <?php 
                                                $highlight_text = safe_get($highlight, 'text');
                                                if (!empty($highlight_text)) : 
                                                ?>
                                                    <li style="color: #64748b; margin-bottom: 0.5rem; padding-left: 1rem; position: relative; font-size: 0.9rem; line-height: 1.5;">
                                                        <span style="position: absolute; left: 0; color: #22c55e;">•</span>
                                                        <?php echo esc_html($highlight_text); ?>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    
                                    <!-- Price and CTA -->
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <div>
                                            <?php if (safe_get($tour, 'price_from')) : ?>
                                                <div style="color: #64748b; font-size: 0.9rem;">from</div>
                                                <div style="font-size: 1.5rem; font-weight: 800; color: #1e293b;"><?php echo esc_html(safe_get($tour, 'price_from')); ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <?php 
                                        // Prioritize Book Now Link over Tour Link
                                        $book_now_link = safe_get($tour, 'book_now_link', array());
                                        $tour_link = safe_get($tour, 'tour_link', array());
                                        $cta_text = safe_get($tour, 'cta_text', 'Check availability');
                                        
                                        // Use Book Now Link if available, otherwise use Tour Link
                                        $primary_link = !empty(safe_get($book_now_link, 'url')) ? $book_now_link : $tour_link;
                                        $link_url = safe_get($primary_link, 'url', '#');
                                        $link_target = safe_get($primary_link, 'target', '_self');
                                        ?>
                                        <a href="<?php echo esc_url($link_url); ?>" 
                                           target="<?php echo esc_attr($link_target); ?>"
                                           style="background: #7c3aed; color: white; padding: 1rem 2rem; border-radius: 15px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">
                                            <?php echo esc_html($cta_text); ?>
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Pro Tips Section -->
        <?php if (!empty($pro_tips) && !empty(safe_get($pro_tips, 'tips_list'))) : ?>
            <section class="pro-tips" style="padding: 4rem 0; background: white;">
                <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                    <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 3rem; color: #1e293b; text-align: center;">
                        <?php echo esc_html(safe_get($pro_tips, 'title', 'Pro tips to help you make a pick')); ?>
                    </h2>
                    
                    <div class="tips-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                        <?php foreach (safe_get($pro_tips, 'tips_list', array()) as $tip) : ?>
                            <div class="tip-card" style="background: #f8fafc; padding: 2rem; border-radius: 20px; border-left: 4px solid #7c3aed;">
                                <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
                                    <div style="background: #7c3aed; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">
                                        <?php echo esc_html(safe_get($tip, 'number', '1')); ?>
                                    </div>
                                    <p style="color: #1e293b; line-height: 1.6; margin: 0; font-size: 0.95rem;">
                                        <?php echo esc_html(safe_get($tip, 'tip_content')); ?>
                                    </p>
                                </div>
                                <?php 
                                $more_link = safe_get($tip, 'more_link', array());
                                if (!empty($more_link)) : 
                                ?>
                                    <a href="<?php echo esc_url(safe_get($more_link, 'url')); ?>" 
                                       style="color: #7c3aed; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                        See more +
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Similar Things Section -->
        <?php if (!empty($similar_things) && !empty(safe_get($similar_things, 'similar_items'))) : ?>
            <section class="similar-things" style="padding: 4rem 0; background: #f8fafc;">
                <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 3rem;">
                        <h2 style="font-size: 2rem; font-weight: 800; color: #1e293b; margin: 0;">
                            <?php echo esc_html(safe_get($similar_things, 'title', 'Similar things to do')); ?>
                        </h2>
                        <div style="display: flex; gap: 1rem;">
                            <button onclick="scrollSimilarItems(-1)" style="background: white; border: 2px solid #e2e8f0; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#2dd4bf';" onmouseout="this.style.background='white'; this.style.borderColor='#e2e8f0';">
                                ←
                            </button>
                            <button onclick="scrollSimilarItems(1)" style="background: white; border: 2px solid #e2e8f0; border-radius: 50%; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#2dd4bf';" onmouseout="this.style.background='white'; this.style.borderColor='#e2e8f0';">
                                →
                            </button>
                        </div>
                    </div>
                    
                    <div class="similar-carousel-container" style="position: relative; overflow: hidden;">
                        <div class="similar-carousel" id="similarItemsCarousel" style="display: flex; gap: 1.5rem; overflow-x: auto; scroll-behavior: smooth; padding: 0.5rem 0; scrollbar-width: none; -ms-overflow-style: none;">
                        <?php foreach (safe_get($similar_things, 'similar_items', array()) as $item) : ?>
                            <div class="similar-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: transform 0.3s ease; min-width: 280px; max-width: 280px; flex-shrink: 0; cursor: pointer;" onclick="<?php if (safe_get($item, 'link')) { echo 'window.open(\'' . esc_url(safe_get(safe_get($item, 'link'), 'url', '#')) . '\', \'' . (safe_get(safe_get($item, 'link'), 'target') ?: '_self') . '\')'; } ?>">
                                <?php if (safe_get($item, 'image')) : ?>
                                    <div style="height: 200px; overflow: hidden;">
                                        <img src="<?php echo esc_url(safe_get($item['image'], 'url')); ?>" 
                                             alt="<?php echo esc_attr(safe_get($item, 'title')); ?>"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                <?php endif; ?>
                                <div style="padding: 1.5rem;">
                                    <h4 style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">
                                        <?php echo esc_html(safe_get($item, 'title')); ?>
                                    </h4>
                                    <?php if (safe_get($item, 'price')) : ?>
                                        <div style="color: #64748b; font-size: 0.9rem; font-weight: 600;">
                                            <?php echo esc_html(safe_get($item, 'price')); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Add Similar Items Carousel JavaScript -->
                    <script>
                    function scrollSimilarItems(direction) {
                        const carousel = document.getElementById('similarItemsCarousel');
                        const scrollAmount = 295; // Card width (280px) + gap (15px)
                        const currentScroll = carousel.scrollLeft;
                        
                        if (direction === 1) {
                            carousel.scrollTo({
                                left: currentScroll + scrollAmount,
                                behavior: 'smooth'
                            });
                        } else {
                            carousel.scrollTo({
                                left: currentScroll - scrollAmount,
                                behavior: 'smooth'
                            });
                        }
                    }
                    
                    // Auto-scroll functionality for similar items
                    let similarItemsAutoScrollInterval;
                    let similarItemsCurrentIndex = 0;
                    
                    function startSimilarItemsAutoScroll() {
                        similarItemsAutoScrollInterval = setInterval(() => {
                            const carousel = document.getElementById('similarItemsCarousel');
                            const containerWidth = carousel.parentElement.clientWidth;
                            const cardWidth = 295; // Card width + gap
                            const maxScroll = carousel.scrollWidth - containerWidth;
                            
                            // Check if we're at or near the end
                            if (carousel.scrollLeft >= maxScroll - 50) {
                                // Jump back to start smoothly
                                carousel.scrollTo({ left: 0, behavior: 'smooth' });
                                similarItemsCurrentIndex = 0;
                            } else {
                                // Continue scrolling right
                                similarItemsCurrentIndex++;
                                carousel.scrollTo({ left: similarItemsCurrentIndex * cardWidth, behavior: 'smooth' });
                            }
                        }, 4000); // Change item every 4 seconds
                    }
                    
                    function stopSimilarItemsAutoScroll() {
                        clearInterval(similarItemsAutoScrollInterval);
                    }
                    
                    // Initialize auto-scroll when page loads
                    document.addEventListener('DOMContentLoaded', function() {
                        const similarCarousel = document.getElementById('similarItemsCarousel');
                        if (similarCarousel && similarCarousel.children.length > 0) {
                            startSimilarItemsAutoScroll();
                            
                            // Pause auto-scroll on hover
                            const similarContainer = document.querySelector('.similar-carousel-container');
                            if (similarContainer) {
                                similarContainer.addEventListener('mouseenter', stopSimilarItemsAutoScroll);
                                similarContainer.addEventListener('mouseleave', startSimilarItemsAutoScroll);
                            }
                        }
                    });
                    </script>
                    
                    <!-- Additional CSS for similar items carousel -->
                    <style>
                    .similar-carousel::-webkit-scrollbar {
                        display: none;
                    }
                    
                    .similar-card:hover {
                        transform: translateY(-8px);
                        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
                    }
                    
                    @media (max-width: 768px) {
                        .similar-card {
                            min-width: 250px !important;
                            max-width: 250px !important;
                        }
                    }
                    </style>
                </div>
            </section>
        <?php endif; ?>

        <!-- About Section -->
        <?php if (!empty($about_section)) : ?>
            <section class="about-section" style="padding: 4rem 0; background: white;">
                <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                    <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">
                        <?php echo esc_html(safe_get($about_section, 'title', 'About ' . get_the_title())); ?>
                    </h2>
                    
                    <?php if (safe_get($about_section, 'content')) : ?>
                        <div style="color: #64748b; line-height: 1.7; font-size: 1.05rem; margin-bottom: 2rem;">
                            <?php echo wp_kses_post(safe_get($about_section, 'content')); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Tags -->
                    <?php 
                    $tags = safe_get($about_section, 'tags', array());
                    if (!empty($tags)) : 
                    ?>
                        <div style="margin-bottom: 2rem;">
                            <h4 style="font-size: 1rem; font-weight: 600; color: #1e293b; margin-bottom: 1rem;">GREAT FOR</h4>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                                <?php foreach ($tags as $tag) : ?>
                                    <?php
                                    $tag_colors = array(
                                        'purple' => 'background: #ede9fe; color: #6b21a8;',
                                        'blue' => 'background: #dbeafe; color: #1e3a8a;',
                                        'green' => 'background: #dcfce7; color: #166534;',
                                        'orange' => 'background: #fed7aa; color: #c2410c;',
                                        'red' => 'background: #fecaca; color: #dc2626;'
                                    );
                                    $tag_style = $tag_colors[safe_get($tag, 'color', 'purple')] ?? $tag_colors['purple'];
                                    ?>
                                    <span style="<?php echo $tag_style; ?> padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem; font-weight: 600;">
                                        <?php echo esc_html(safe_get($tag, 'text')); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Info Sections -->
                    <?php 
                    $info_sections = safe_get($about_section, 'info_sections', array());
                    if (!empty($info_sections)) : 
                    ?>
                        <div class="info-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                            <?php foreach ($info_sections as $info) : ?>
                                <div>
                                    <h5 style="font-size: 0.9rem; font-weight: 700; color: #64748b; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">
                                        <?php echo esc_html(safe_get($info, 'title')); ?>
                                    </h5>
                                    <p style="color: #1e293b; line-height: 1.6; margin: 0;">
                                        <?php echo esc_html(safe_get($info, 'content')); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
        
    </main>

<?php endwhile; ?>

<style>
/* Headout-style responsive design */
.tour-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.similar-card:hover {
    transform: translateY(-3px);
}

.play-button:hover {
    background: white !important;
    transform: translate(-50%, -50%) scale(1.1) !important;
}

.tip-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Carousel Styles */
.carousel-prev:hover, .carousel-next:hover {
    background: rgba(0,0,0,0.7) !important;
    transform: translateY(-50%) scale(1.1) !important;
}

.indicator.active {
    background: white !important;
}

.indicator:hover {
    background: rgba(255,255,255,0.8) !important;
}

/* Hero Video Responsive Styles */
.hero-video {
    width: 100% !important;
    max-width: 700px !important;
}

@media (min-width: 1200px) {
    .hero-video {
        max-width: 800px !important;
    }
}

/* Responsive Grid Adjustments */
@media (max-width: 768px) {
    .category-hero > div > div {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .hero-video {
        max-width: 100% !important;
    }
    
    .tour-card {
        grid-template-columns: 1fr !important;
        min-height: auto !important;
    }
    
    .tour-image-carousel {
        height: 250px !important;
    }
    
    .hero-stats {
        gap: 1rem !important;
    }
    
    .tips-grid {
        grid-template-columns: 1fr !important;
    }
    
    .similar-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)) !important;
    }
}

@media (max-width: 640px) {
    .hero-stats {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    
    .stat-item {
        text-align: center !important;
    }
}
</style>

<script>
function changeImage(button, direction) {
    const carousel = button.closest('.tour-image-carousel');
    const images = carousel.querySelectorAll('.carousel-image');
    const indicators = carousel.querySelectorAll('.indicator');
    const currentActive = carousel.querySelector('.carousel-image.active');
    const currentIndex = parseInt(currentActive.dataset.index);
    
    let newIndex = currentIndex + direction;
    if (newIndex >= images.length) newIndex = 0;
    if (newIndex < 0) newIndex = images.length - 1;
    
    // Hide current image
    currentActive.style.opacity = '0';
    currentActive.classList.remove('active');
    indicators[currentIndex].classList.remove('active');
    indicators[currentIndex].style.background = 'rgba(255,255,255,0.5)';
    
    // Show new image
    setTimeout(() => {
        images[newIndex].style.opacity = '1';
        images[newIndex].classList.add('active');
        indicators[newIndex].classList.add('active');
        indicators[newIndex].style.background = 'white';
    }, 100);
}

function goToImage(indicator, index) {
    const carousel = indicator.closest('.tour-image-carousel');
    const images = carousel.querySelectorAll('.carousel-image');
    const indicators = carousel.querySelectorAll('.indicator');
    const currentActive = carousel.querySelector('.carousel-image.active');
    const currentIndex = parseInt(currentActive.dataset.index);
    
    if (currentIndex === index) return;
    
    // Hide current image
    currentActive.style.opacity = '0';
    currentActive.classList.remove('active');
    indicators[currentIndex].classList.remove('active');
    indicators[currentIndex].style.background = 'rgba(255,255,255,0.5)';
    
    // Show new image
    setTimeout(() => {
        images[index].style.opacity = '1';
        images[index].classList.add('active');
        indicators[index].classList.add('active');
        indicators[index].style.background = 'white';
    }, 100);
}

// Video modal functionality
function openVideoModal(videoUrl) {
    // Convert YouTube URL to embed format
    function getYouTubeEmbedUrl(url) {
        const youtubeRegex = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;
        const match = url.match(youtubeRegex);
        if (match) {
            return `https://www.youtube.com/embed/${match[1]}?autoplay=1&rel=0`;
        }
        return url; // Return original URL if not YouTube
    }
    
    const embedUrl = getYouTubeEmbedUrl(videoUrl);
    
    // Create modal
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        padding: 2rem;
    `;
    
    modal.innerHTML = `
        <div style="position: relative; width: 100%; max-width: 900px; aspect-ratio: 16/9;">
            <iframe src="${embedUrl}" 
                    style="width: 100%; height: 100%; border: none; border-radius: 15px;"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
            </iframe>
            <button onclick="this.closest('div').remove()" 
                    style="position: absolute; top: -15px; right: -15px; width: 40px; height: 40px; border-radius: 50%; background: white; border: none; cursor: pointer; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                ×
            </button>
        </div>
    `;
    
    // Close modal when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function escapeHandler(e) {
        if (e.key === 'Escape') {
            modal.remove();
            document.removeEventListener('keydown', escapeHandler);
        }
    });
    
    document.body.appendChild(modal);
}
</script>

<?php get_footer(); ?>
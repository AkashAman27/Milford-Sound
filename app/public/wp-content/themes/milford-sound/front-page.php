<?php get_header(); ?>

<?php
// Get the homepage ACF flexible content
$flexible_content = get_field('flexible_content');

// Debug: Show flexible content data for administrators
if (current_user_can('administrator')) {
    echo '<!-- DEBUG: Flexible Content Data: ' . print_r($flexible_content, true) . ' -->';
    echo '<!-- DEBUG: Post ID: ' . get_the_ID() . ' -->';
    echo '<!-- DEBUG: Template: front-page.php -->';
}

if ($flexible_content) :
    foreach ($flexible_content as $section) :
        $layout = $section['acf_fc_layout'];
        
        switch ($layout) :
            case 'hero_section':
                ?>
                <!-- Hero Section -->
                <section class="hero-section" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; text-align: center; overflow: hidden; min-height: 80vh; display: flex; align-items: center;">
                    
                    <?php 
                    $bg_image = safe_get($section, 'hero_background_image', safe_get($section, 'background_image'));
                    $bg_video = safe_get($section, 'hero_background_video', safe_get($section, 'background_video'));
                    ?>
                    
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
                    
                    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 10;">
                        <div class="hero-content">
                            
                            <?php if (safe_get($section, 'badge_text')) : ?>
                                <div class="hero-badge" style="background: rgba(255,255,255,0.2); padding: 0.5rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 2rem;">
                                    <?php echo esc_html($section['badge_text']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'title')) : ?>
                                <h1 class="hero-title" style="font-size: clamp(3rem, 8vw, 6rem); font-weight: 900; margin-bottom: 2rem; line-height: 1.1;">
                                    <?php 
                                    $title = $section['title'];
                                    $highlight_word = safe_get($section, 'highlight_word');
                                    
                                    if ($highlight_word) {
                                        $title = str_replace($highlight_word, '<span style="color: #2dd4bf;">' . $highlight_word . '</span>', $title);
                                    }
                                    
                                    echo wp_kses($title, array('span' => array('style' => array())));
                                    ?>
                                </h1>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'description')) : ?>
                                <p class="hero-description" style="font-size: 1.5rem; margin-bottom: 3rem; opacity: 0.9; line-height: 1.6; max-width: 800px; margin-left: auto; margin-right: auto;">
                                    <?php echo esc_html($section['description']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'buttons') && !empty($section['buttons'])) : ?>
                                <div class="hero-buttons" style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                                    <?php foreach ($section['buttons'] as $button) : ?>
                                        <?php
                                        $btn_style = safe_get($button, 'style', safe_get($button, 'button_style', 'primary'));
                                        $btn_class = ($btn_style === 'primary') 
                                            ? 'background: #2dd4bf; color: white;' 
                                            : 'background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);';
                                        ?>
                                        <a href="<?php echo esc_url(safe_get(safe_get($button, 'link'), 'url', safe_get(safe_get($button, 'button_link'), 'url', '#'))); ?>" 
                                           style="<?php echo $btn_class; ?> padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"
                                           <?php 
                                           $link_target = safe_get(safe_get($button, 'link'), 'target', safe_get(safe_get($button, 'button_link'), 'target'));
                                           if ($link_target) echo 'target="' . esc_attr($link_target) . '"'; 
                                           ?>>
                                            <?php if (safe_get($button, 'icon')) : ?>
                                                <?php echo esc_html($button['icon']); ?> 
                                            <?php endif; ?>
                                            <?php echo esc_html(safe_get($button, 'text', safe_get($button, 'button_text', 'Button'))); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </section>
                <?php
                break;
                
            case 'stats_section':
                ?>
                <!-- Stats Section -->
                <section class="stats-section" style="padding: 4rem 0; background: #f8fafc;">
                    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                        <div class="stats-container" style="display: grid; grid-template-columns: 1fr 2fr; gap: 4rem; align-items: center;">
                            
                            <!-- Weather Info -->
                            <div class="weather-info" style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <?php if (safe_get($section, 'title')) : ?>
                                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem;">
                                        🌊 <?php echo esc_html($section['title']); ?>
                                    </h3>
                                <?php endif; ?>
                                
                                <?php if (safe_get($section, 'subtitle')) : ?>
                                    <p style="color: #64748b; margin-bottom: 1.5rem;"><?php echo esc_html($section['subtitle']); ?></p>
                                <?php endif; ?>
                                
                                <?php if (safe_get($section, 'weather_items') && !empty($section['weather_items'])) : ?>
                                    <div class="weather-details" style="display: grid; gap: 1rem;">
                                        <?php foreach ($section['weather_items'] as $item) : ?>
                                            <div class="weather-item" style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; background: #f8fafc; border-radius: 10px;">
                                                <span style="font-size: 1.25rem;"><?php echo esc_html(safe_get($item, 'icon')); ?></span>
                                                <span style="font-weight: 600; color: #1e293b;"><?php echo esc_html(safe_get($item, 'text')); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Statistics -->
                            <?php if (safe_get($section, 'statistics') && !empty($section['statistics'])) : ?>
                                <div class="stats-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                                    <?php foreach ($section['statistics'] as $stat) : ?>
                                        <div class="stat-item" style="text-align: center; background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            <?php if (safe_get($stat, 'stat_icon', safe_get($stat, 'icon'))) : ?>
                                                <div style="font-size: 2rem; margin-bottom: 1rem;"><?php echo esc_html(safe_get($stat, 'stat_icon', safe_get($stat, 'icon'))); ?></div>
                                            <?php endif; ?>
                                            <span class="stat-number" style="display: block; font-size: 2.5rem; font-weight: 800; color: #2dd4bf; margin-bottom: 0.5rem;">
                                                <?php echo esc_html(safe_get($stat, 'stat_number', safe_get($stat, 'number'))); ?>
                                            </span>
                                            <span class="stat-label" style="font-size: 0.9rem; color: #64748b; font-weight: 600;">
                                                <?php echo esc_html(safe_get($stat, 'stat_label', safe_get($stat, 'label'))); ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                </section>
                <?php
                break;
                
            case 'features_section':
                ?>
                <!-- Features Section -->
                <section class="features-section" style="padding: 6rem 0; background: white;">
                    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; text-align: center;">
                        
                        <?php if (safe_get($section, 'badge')) : ?>
                            <div class="section-badge" style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 0.5rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 2rem;">
                                <?php echo esc_html($section['badge']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'title')) : ?>
                            <h2 class="section-title" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 2rem; color: #1e293b; line-height: 1.2;">
                                <?php echo esc_html($section['title']); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'description')) : ?>
                            <p class="section-description" style="font-size: 1.25rem; color: #64748b; margin-bottom: 4rem; max-width: 800px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                                <?php echo esc_html($section['description']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'features') && !empty($section['features'])) : ?>
                            <div class="features-carousel-container" style="position: relative; overflow: hidden;">
                                <!-- Carousel Navigation Arrows -->
                                <button class="features-nav prev" onclick="scrollFeatures(-1)" style="position: absolute; left: -20px; top: 50%; transform: translateY(-50%); background: white; border: none; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #64748b; transition: all 0.3s ease;">
                                    ←
                                </button>
                                <button class="features-nav next" onclick="scrollFeatures(1)" style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); background: white; border: none; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #64748b; transition: all 0.3s ease;">
                                    →
                                </button>
                                
                                <!-- Features Carousel -->
                                <div class="features-carousel" id="featuresCarousel" style="display: flex; gap: 2rem; overflow-x: auto; scroll-behavior: smooth; padding: 1rem 0; scrollbar-width: none; -ms-overflow-style: none;">
                                    <?php foreach ($section['features'] as $feature) : ?>
                                        <div class="feature-card" style="background: #f8fafc; padding: 3rem 2rem; border-radius: 20px; text-align: center; transition: transform 0.3s ease; min-width: 300px; max-width: 300px; flex-shrink: 0;">
                                        
                                        <?php if (safe_get($feature, 'image')) : ?>
                                            <div style="width: 80px; height: 80px; margin: 0 auto 2rem; border-radius: 50%; overflow: hidden;">
                                                <img src="<?php echo esc_url($feature['image']['sizes']['thumbnail']); ?>" 
                                                     alt="<?php echo esc_attr($feature['image']['alt']); ?>"
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        <?php else : ?>
                                            <div class="feature-icon" style="width: 80px; height: 80px; margin: 0 auto 2rem; background: <?php echo esc_attr(safe_get($feature, 'color', '#2dd4bf')); ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                                                <?php echo esc_html(safe_get($feature, 'feature_icon', '⭐')); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (safe_get($feature, 'feature_title')) : ?>
                                            <h3 class="feature-title" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">
                                                <?php echo esc_html($feature['feature_title']); ?>
                                            </h3>
                                        <?php endif; ?>
                                        
                                        <?php if (safe_get($feature, 'feature_description')) : ?>
                                            <p class="feature-description" style="color: #64748b; line-height: 1.6;">
                                                <?php echo esc_html($feature['feature_description']); ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Add Features Carousel JavaScript -->
                            <script>
                            function scrollFeatures(direction) {
                                const carousel = document.getElementById('featuresCarousel');
                                const scrollAmount = 320; // Card width (300px) + gap (20px)
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
                            
                            // Auto-scroll functionality for features
                            let featuresAutoScrollInterval;
                            let featuresCurrentIndex = 0;
                            
                            function startFeaturesAutoScroll() {
                                featuresAutoScrollInterval = setInterval(() => {
                                    const carousel = document.getElementById('featuresCarousel');
                                    const containerWidth = carousel.parentElement.clientWidth;
                                    const cardWidth = 320; // Card width + gap
                                    const maxScroll = carousel.scrollWidth - containerWidth;
                                    
                                    // Check if we're at or near the end
                                    if (carousel.scrollLeft >= maxScroll - 50) {
                                        // Jump back to start smoothly
                                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                                        featuresCurrentIndex = 0;
                                    } else {
                                        // Continue scrolling right
                                        featuresCurrentIndex++;
                                        carousel.scrollTo({ left: featuresCurrentIndex * cardWidth, behavior: 'smooth' });
                                    }
                                }, 4500); // Change feature every 4.5 seconds
                            }
                            
                            function stopFeaturesAutoScroll() {
                                clearInterval(featuresAutoScrollInterval);
                            }
                            
                            // Initialize features auto-scroll when page loads
                            document.addEventListener('DOMContentLoaded', function() {
                                const featuresCarousel = document.getElementById('featuresCarousel');
                                if (featuresCarousel && featuresCarousel.children.length > 0) {
                                    startFeaturesAutoScroll();
                                    
                                    // Pause auto-scroll on hover
                                    const featuresContainer = document.querySelector('.features-carousel-container');
                                    if (featuresContainer) {
                                        featuresContainer.addEventListener('mouseenter', stopFeaturesAutoScroll);
                                        featuresContainer.addEventListener('mouseleave', startFeaturesAutoScroll);
                                    }
                                }
                            });
                            </script>
                            
                            <!-- Additional CSS for features carousel -->
                            <style>
                            .features-carousel::-webkit-scrollbar {
                                display: none;
                            }
                            
                            .features-nav:hover {
                                background: #f8fafc !important;
                                transform: translateY(-50%) scale(1.1) !important;
                                box-shadow: 0 6px 25px rgba(0,0,0,0.15) !important;
                                color: #2dd4bf !important;
                            }
                            
                            .feature-card:hover {
                                transform: translateY(-10px);
                                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                            }
                            
                            @media (max-width: 768px) {
                                .features-nav {
                                    display: none !important;
                                }
                                
                                .feature-card {
                                    min-width: 280px !important;
                                    max-width: 280px !important;
                                    padding: 2rem 1.5rem !important;
                                }
                            }
                            
                            @media (min-width: 1200px) {
                                .features-carousel-container {
                                    max-width: 1000px;
                                    margin: 0 auto;
                                }
                            }
                            </style>
                        <?php endif; ?>
                        
                    </div>
                </section>
                <?php
                break;
                
            case 'tours_section':
                ?>
                <!-- Tours Section -->
                <section class="tours-section" style="padding: 6rem 0; background: #f8fafc;" id="tours">
                    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; text-align: center;">
                        
                        <?php if (safe_get($section, 'badge')) : ?>
                            <div class="section-badge" style="background: linear-gradient(135deg, #22c55e, #16a34a); color: white; padding: 0.5rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 2rem;">
                                <?php echo esc_html($section['badge']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'title')) : ?>
                            <h2 class="section-title" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 4rem; color: #1e293b;">
                                <?php echo esc_html($section['title']); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'tours') && !empty($section['tours'])) : ?>
                            <div class="tours-carousel-container" style="position: relative; overflow: hidden;">
                                <!-- Carousel Navigation Arrows -->
                                <button class="carousel-nav prev" onclick="scrollTours(-1)" style="position: absolute; left: -20px; top: 50%; transform: translateY(-50%); background: white; border: none; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #64748b; transition: all 0.3s ease;">
                                    ←
                                </button>
                                <button class="carousel-nav next" onclick="scrollTours(1)" style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); background: white; border: none; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #64748b; transition: all 0.3s ease;">
                                    →
                                </button>
                                
                                <!-- Tours Carousel -->
                                <div class="tours-carousel" id="toursCarousel" style="display: flex; gap: 1.5rem; overflow-x: auto; scroll-behavior: smooth; padding: 1rem 0; scrollbar-width: none; -ms-overflow-style: none;">
                                    <?php foreach ($section['tours'] as $tour) : ?>
                                        <div class="tour-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; position: relative; min-width: 320px; max-width: 320px; flex-shrink: 0; height: 550px; display: flex; flex-direction: column;">
                                        
                                        <?php if (safe_get($tour, 'badge')) : ?>
                                            <?php
                                            $badge_color = safe_get($tour, 'badge_color', 'popular');
                                            $badge_colors = array(
                                                'popular' => 'background: linear-gradient(135deg, #22c55e, #16a34a);',
                                                'premium' => 'background: linear-gradient(135deg, #8b5cf6, #7c3aed);',
                                                'adventure' => 'background: linear-gradient(135deg, #f59e0b, #f97316);',
                                                'new' => 'background: linear-gradient(135deg, #3b82f6, #2563eb);'
                                            );
                                            ?>
                                            <div class="tour-badge" style="<?php echo $badge_colors[$badge_color]; ?> color: white; padding: 0.5rem 1rem; border-radius: 0 0 15px 0; position: absolute; top: 0; left: 0; font-size: 0.8rem; font-weight: 600; z-index: 2;">
                                                <?php echo esc_html($tour['badge']); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="tour-image" style="height: 180px; background: linear-gradient(135deg, #e2e8f0, #cbd5e1); display: flex; align-items: center; justify-content: center; position: relative;">
                                            <?php if (safe_get($tour, 'image')) : ?>
                                                <img src="<?php echo esc_url($tour['image']['sizes']['medium_large']); ?>" 
                                                     alt="<?php echo esc_attr($tour['image']['alt']); ?>"
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else : ?>
                                                <span style="font-size: 4rem; color: #64748b;">
                                                    <?php echo esc_html(safe_get($tour, 'icon', '🎯')); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="tour-content" style="padding: 1.5rem; display: flex; flex-direction: column; flex: 1;">
                                            
                                            <!-- Main content area that can grow -->
                                            <div class="tour-info" style="flex: 1;">
                                                <div class="tour-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                                <?php if (safe_get($tour, 'title')) : ?>
                                                    <h3 class="tour-title" style="font-size: 1.1rem; font-weight: 700; color: #1e293b; flex: 1; text-align: left; line-height: 1.3;">
                                                        <?php echo esc_html($tour['title']); ?>
                                                    </h3>
                                                <?php endif; ?>
                                                
                                                <?php if (safe_get($tour, 'duration')) : ?>
                                                    <span class="tour-duration" style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; font-weight: 600; margin-left: 1rem;">
                                                        <?php echo esc_html($tour['duration']); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <?php if (safe_get($tour, 'price')) : ?>
                                                <div class="tour-price" style="font-size: 1.5rem; font-weight: 800; color: #2dd4bf; margin-bottom: 1rem;">
                                                    <?php echo esc_html($tour['price']); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (safe_get($tour, 'description')) : ?>
                                                <p class="tour-description" style="color: #64748b; margin-bottom: 1rem; line-height: 1.5; font-size: 0.9rem;">
                                                    <?php echo esc_html(strlen($tour['description']) > 80 ? substr($tour['description'], 0, 80) . '...' : $tour['description']); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if (safe_get($tour, 'details') && !empty($tour['details'])) : ?>
                                                <div class="tour-details" style="display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; font-size: 0.9rem; color: #64748b;">
                                                    <?php foreach ($tour['details'] as $detail) : ?>
                                                        <div class="tour-detail" style="display: flex; align-items: center; gap: 0.25rem;">
                                                            <span><?php echo esc_html(safe_get($detail, 'icon')); ?></span>
                                                            <span><?php echo esc_html(safe_get($detail, 'text')); ?></span>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                                <?php if (safe_get($tour, 'rating') && safe_get($tour, 'reviews')) : ?>
                                                    <div class="tour-rating" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; font-size: 0.9rem;">
                                                        <span class="stars" style="color: #fbbf24;">⭐</span>
                                                        <span style="font-weight: 600; color: #1e293b;"><?php echo esc_html($tour['rating']); ?></span>
                                                        <span style="color: #64748b;">(<?php echo esc_html(number_format($tour['reviews'])); ?>)</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- CTA Button - Fixed at bottom -->
                                            <?php if (safe_get($tour, 'link')) : ?>
                                                <a href="<?php echo esc_url(safe_get($tour['link'], 'url', '#')); ?>" 
                                                   class="btn btn-primary tour-cta-btn" 
                                                   style="background: #2dd4bf; color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s ease; width: 100%; text-align: center; box-sizing: border-box;"
                                                   <?php if (safe_get($tour['link'], 'target')) echo 'target="' . esc_attr($tour['link']['target']) . '"'; ?>>
                                                    <?php echo esc_html(safe_get($tour, 'button_text', 'Book Now')); ?> →
                                                </a>
                                            <?php endif; ?>
                                            
                                        </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Add Carousel JavaScript -->
                            <script>
                            function scrollTours(direction) {
                                const carousel = document.getElementById('toursCarousel');
                                const scrollAmount = 335; // Card width (320px) + gap (15px)
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
                            
                            // Auto-scroll functionality (only left to right)
                            let autoScrollInterval;
                            let currentIndex = 0;
                            
                            function startAutoScroll() {
                                autoScrollInterval = setInterval(() => {
                                    const carousel = document.getElementById('toursCarousel');
                                    const totalCards = carousel.children.length;
                                    const containerWidth = carousel.parentElement.clientWidth;
                                    const cardWidth = 335; // Card width + gap
                                    const maxScroll = carousel.scrollWidth - containerWidth;
                                    
                                    // Check if we're at or near the end
                                    if (carousel.scrollLeft >= maxScroll - 50) {
                                        // Jump back to start smoothly
                                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                                        currentIndex = 0;
                                    } else {
                                        // Continue scrolling right
                                        currentIndex++;
                                        carousel.scrollTo({ left: currentIndex * cardWidth, behavior: 'smooth' });
                                    }
                                }, 4000); // Change slide every 4 seconds
                            }
                            
                            function stopAutoScroll() {
                                clearInterval(autoScrollInterval);
                            }
                            
                            // Initialize auto-scroll when page loads
                            document.addEventListener('DOMContentLoaded', function() {
                                startAutoScroll();
                                
                                // Pause auto-scroll on hover
                                const carousel = document.getElementById('toursCarousel');
                                const container = document.querySelector('.tours-carousel-container');
                                
                                if (container) {
                                    container.addEventListener('mouseenter', stopAutoScroll);
                                    container.addEventListener('mouseleave', startAutoScroll);
                                }
                            });
                            </script>
                            
                            <!-- Hide scrollbar -->
                            <style>
                            .tours-carousel::-webkit-scrollbar {
                                display: none;
                            }
                            
                            .carousel-nav:hover {
                                background: #f8fafc !important;
                                transform: translateY(-50%) scale(1.1) !important;
                                box-shadow: 0 6px 25px rgba(0,0,0,0.15) !important;
                            }
                            
                            .tour-card:hover {
                                transform: translateY(-5px);
                            }
                            
                            .tour-cta-btn:hover {
                                background: #1eb5a6 !important;
                                transform: translateY(-2px);
                                box-shadow: 0 4px 15px rgba(45, 212, 191, 0.3);
                            }
                            
                            @media (max-width: 768px) {
                                .carousel-nav {
                                    display: none !important;
                                }
                                
                                .tours-carousel {
                                    padding: 1rem !important;
                                }
                                
                                .tour-card {
                                    min-width: 280px !important;
                                    max-width: 280px !important;
                                    height: 500px !important;
                                }
                            }
                            
                            @media (min-width: 1200px) {
                                .tours-carousel-container {
                                    max-width: 1000px;
                                    margin: 0 auto;
                                }
                            }
                            </style>
                        <?php endif; ?>
                        
                    </div>
                </section>
                <?php
                break;
                
            case 'testimonials_section':
                ?>
                <!-- Testimonials Section -->
                <section class="testimonials-section" style="padding: 6rem 0; background: white;">
                    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; text-align: center;">
                        
                        <?php if (safe_get($section, 'title')) : ?>
                            <h2 class="section-title" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 4rem; color: #1e293b;">
                                <?php echo esc_html($section['title']); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'testimonials') && !empty($section['testimonials'])) : ?>
                            <div class="testimonials-carousel-container" style="position: relative; overflow: hidden;">
                                <!-- Carousel Navigation Arrows -->
                                <button class="testimonials-nav prev" onclick="scrollTestimonials(-1)" style="position: absolute; left: -20px; top: 50%; transform: translateY(-50%); background: white; border: none; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #64748b; transition: all 0.3s ease;">
                                    ←
                                </button>
                                <button class="testimonials-nav next" onclick="scrollTestimonials(1)" style="position: absolute; right: -20px; top: 50%; transform: translateY(-50%); background: white; border: none; border-radius: 50%; width: 50px; height: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); cursor: pointer; z-index: 10; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #64748b; transition: all 0.3s ease;">
                                    →
                                </button>
                                
                                <!-- Testimonials Carousel -->
                                <div class="testimonials-carousel" id="testimonialsCarousel" style="display: flex; gap: 2rem; overflow-x: auto; scroll-behavior: smooth; padding: 1rem 0; scrollbar-width: none; -ms-overflow-style: none;">
                                    <?php foreach ($section['testimonials'] as $testimonial) : ?>
                                        <div class="testimonial-card" style="background: #f8fafc; padding: 2rem; border-radius: 20px; text-align: left; min-width: 350px; max-width: 350px; flex-shrink: 0; height: 280px; display: flex; flex-direction: column;">
                                        
                                        <!-- Testimonial content that grows -->
                                        <div class="testimonial-content" style="flex: 1;">
                                            <?php if (safe_get($testimonial, 'rating')) : ?>
                                                <div class="testimonial-rating" style="margin-bottom: 1rem;">
                                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                        <span style="color: <?php echo $i <= $testimonial['rating'] ? '#fbbf24' : '#e5e7eb'; ?>;">⭐</span>
                                                    <?php endfor; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (safe_get($testimonial, 'text')) : ?>
                                                <blockquote style="font-style: italic; color: #64748b; margin-bottom: 1.5rem; line-height: 1.6; font-size: 1rem;">
                                                    "<?php echo esc_html(strlen($testimonial['text']) > 120 ? substr($testimonial['text'], 0, 120) . '...' : $testimonial['text']); ?>"
                                                </blockquote>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="testimonial-author" style="display: flex; align-items: center; gap: 1rem;">
                                            <?php if (safe_get($testimonial, 'avatar')) : ?>
                                                <div style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden;">
                                                    <img src="<?php echo esc_url($testimonial['avatar']['sizes']['thumbnail']); ?>" 
                                                         alt="<?php echo esc_attr($testimonial['avatar']['alt']); ?>"
                                                         style="width: 100%; height: 100%; object-fit: cover;">
                                                </div>
                                            <?php else : ?>
                                                <div style="width: 50px; height: 50px; border-radius: 50%; background: #2dd4bf; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                                    <?php echo esc_html(substr(safe_get($testimonial, 'name', 'U'), 0, 1)); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div>
                                                <?php if (safe_get($testimonial, 'name')) : ?>
                                                    <div style="font-weight: 600; color: #1e293b;">
                                                        <?php echo esc_html($testimonial['name']); ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php if (safe_get($testimonial, 'location')) : ?>
                                                    <div style="font-size: 0.9rem; color: #64748b;">
                                                        <?php echo esc_html($testimonial['location']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Add Testimonials Carousel JavaScript -->
                            <script>
                            function scrollTestimonials(direction) {
                                const carousel = document.getElementById('testimonialsCarousel');
                                const scrollAmount = 370; // Card width (350px) + gap (20px)
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
                            
                            // Auto-scroll functionality for testimonials
                            let testimonialsAutoScrollInterval;
                            let testimonialsCurrentIndex = 0;
                            
                            function startTestimonialsAutoScroll() {
                                testimonialsAutoScrollInterval = setInterval(() => {
                                    const carousel = document.getElementById('testimonialsCarousel');
                                    const containerWidth = carousel.parentElement.clientWidth;
                                    const cardWidth = 370; // Card width + gap
                                    const maxScroll = carousel.scrollWidth - containerWidth;
                                    
                                    // Check if we're at or near the end
                                    if (carousel.scrollLeft >= maxScroll - 50) {
                                        // Jump back to start smoothly
                                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                                        testimonialsCurrentIndex = 0;
                                    } else {
                                        // Continue scrolling right
                                        testimonialsCurrentIndex++;
                                        carousel.scrollTo({ left: testimonialsCurrentIndex * cardWidth, behavior: 'smooth' });
                                    }
                                }, 5000); // Change testimonial every 5 seconds
                            }
                            
                            function stopTestimonialsAutoScroll() {
                                clearInterval(testimonialsAutoScrollInterval);
                            }
                            
                            // Initialize testimonials auto-scroll when page loads
                            document.addEventListener('DOMContentLoaded', function() {
                                startTestimonialsAutoScroll();
                                
                                // Pause auto-scroll on hover
                                const testimonialsContainer = document.querySelector('.testimonials-carousel-container');
                                
                                if (testimonialsContainer) {
                                    testimonialsContainer.addEventListener('mouseenter', stopTestimonialsAutoScroll);
                                    testimonialsContainer.addEventListener('mouseleave', startTestimonialsAutoScroll);
                                }
                            });
                            </script>
                            
                            <!-- Additional CSS for testimonials -->
                            <style>
                            .testimonials-carousel::-webkit-scrollbar {
                                display: none;
                            }
                            
                            .testimonials-nav:hover {
                                background: #f8fafc !important;
                                transform: translateY(-50%) scale(1.1) !important;
                                box-shadow: 0 6px 25px rgba(0,0,0,0.15) !important;
                            }
                            
                            .testimonial-card:hover {
                                transform: translateY(-5px);
                                transition: transform 0.3s ease;
                            }
                            
                            @media (max-width: 768px) {
                                .testimonials-nav {
                                    display: none !important;
                                }
                                
                                .testimonial-card {
                                    min-width: 300px !important;
                                    max-width: 300px !important;
                                    height: 250px !important;
                                }
                            }
                            
                            @media (min-width: 1200px) {
                                .testimonials-carousel-container {
                                    max-width: 1100px;
                                    margin: 0 auto;
                                }
                            }
                            </style>
                        <?php endif; ?>
                        
                    </div>
                </section>
                <?php
                break;
                
            case 'cta_section':
                ?>
                <!-- CTA Section -->
                <section class="cta-section" style="padding: 6rem 0; background: linear-gradient(135deg, #2dd4bf, #3b82f6); color: white; text-align: center;">
                    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 0 2rem;">
                        
                        <?php if (safe_get($section, 'badge')) : ?>
                            <div class="cta-badge" style="background: rgba(255,255,255,0.2); padding: 0.5rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 2rem;">
                                <?php echo esc_html($section['badge']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'title')) : ?>
                            <h2 class="cta-title" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 2rem; line-height: 1.2;">
                                <?php echo esc_html($section['title']); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'description')) : ?>
                            <p class="cta-description" style="font-size: 1.25rem; margin-bottom: 3rem; opacity: 0.9; line-height: 1.6;">
                                <?php echo esc_html($section['description']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'buttons') && !empty($section['buttons'])) : ?>
                            <div class="cta-buttons" style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 3rem;">
                                <?php foreach ($section['buttons'] as $button) : ?>
                                    <?php
                                    $btn_style = safe_get($button, 'style', 'primary');
                                    $btn_class = ($btn_style === 'primary') 
                                        ? 'background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);' 
                                        : 'background: white; color: #2dd4bf;';
                                    ?>
                                    <a href="<?php echo esc_url(safe_get(safe_get($button, 'link'), 'url', '#')); ?>" 
                                       style="<?php echo $btn_class; ?> padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;"
                                       <?php if (safe_get(safe_get($button, 'link'), 'target')) echo 'target="' . esc_attr($button['link']['target']) . '"'; ?>>
                                        <?php if (safe_get($button, 'icon')) : ?>
                                            <?php echo esc_html($button['icon']); ?> 
                                        <?php endif; ?>
                                        <?php echo esc_html(safe_get($button, 'text', 'Button')); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (safe_get($section, 'features') && !empty($section['features'])) : ?>
                            <div class="cta-features" style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                                <?php foreach ($section['features'] as $feature) : ?>
                                    <div class="cta-feature" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; opacity: 0.9;">
                                        <span><?php echo esc_html(safe_get($feature, 'icon', '✓')); ?></span>
                                        <span><?php echo esc_html(safe_get($feature, 'text')); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </section>
                <?php
                break;
                
        endswitch;
    endforeach;
    
else :
    // Fallback content if no flexible content is set
    ?>
    <!-- Default Homepage Content -->
    <section class="hero-section" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; text-align: center; min-height: 80vh; display: flex; align-items: center;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
            <div class="hero-badge" style="background: rgba(255,255,255,0.2); padding: 0.5rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 2rem;">
                UNESCO World Heritage Site
            </div>
            <h1 style="font-size: clamp(3rem, 8vw, 6rem); font-weight: 900; margin-bottom: 2rem; line-height: 1.1;">
                Experience the<br>
                <span style="color: #2dd4bf;">Eighth Wonder</span><br>
                of the World
            </h1>
            <p style="font-size: 1.5rem; margin-bottom: 3rem; opacity: 0.9; line-height: 1.6; max-width: 800px; margin-left: auto; margin-right: auto;">
                Discover Milford Sound's breathtaking fjords, cascading waterfalls, and pristine wilderness. Configure your homepage content using ACF fields.
            </p>
            <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px; margin-top: 3rem;">
                <h3 style="margin-bottom: 1rem;">🎛️ Setup Required</h3>
                <p style="opacity: 0.9; margin-bottom: 1.5rem;">Add content to your homepage using the flexible content fields in the WordPress admin.</p>
                <?php if (current_user_can('administrator')) : ?>
                    <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.9rem;">
                        <strong>Debug Info:</strong><br>
                        Post ID: <?php echo get_the_ID(); ?><br>
                        Template: front-page.php<br>
                        Flexible Content: <?php echo $flexible_content ? 'Found' : 'Not Found'; ?>
                    </div>
                <?php endif; ?>
                <a href="<?php echo admin_url('post.php?post=' . get_option('page_on_front') . '&action=edit'); ?>" style="background: white; color: #2dd4bf; padding: 1rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600;">
                    Edit Homepage Content →
                </a>
            </div>
        </div>
    </section>
    <?php
endif;
?>

<!-- Latest Blog Posts Section (Always shown) -->
<section class="latest-blog-section" style="padding: 6rem 0; background: #f8fafc;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
        <div style="text-align: center; margin-bottom: 4rem;">
            <div class="section-badge" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 0.5rem 1.5rem; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 2rem;">Latest Updates</div>
            <h2 class="section-title" style="font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; margin-bottom: 2rem; color: #1e293b;">From Our <span style="color: #2dd4bf;">Blog</span></h2>
            <p class="section-description" style="font-size: 1.25rem; color: #64748b; max-width: 600px; margin: 0 auto; line-height: 1.6;">Stay updated with the latest travel tips, stories, and news from Milford Sound</p>
        </div>
        
        <?php
        $latest_posts = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post_status' => 'publish'
        ));
        
        if ($latest_posts->have_posts()) :
        ?>
            <div class="blog-preview-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                    <article class="blog-preview-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: transform 0.3s ease;">
                        <?php if (has_post_thumbnail()) : ?>
                            <div style="height: 200px; overflow: hidden;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large', array('style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;')); ?>
                                </a>
                            </div>
                        <?php else : ?>
                            <div style="height: 200px; background: linear-gradient(135deg, #e2e8f0, #cbd5e1); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 3rem;">
                                📝
                            </div>
                        <?php endif; ?>
                        
                        <div style="padding: 2rem;">
                            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: #64748b;">
                                <span>📅 <?php echo get_the_date('M j'); ?></span>
                                <span>🏷️ <?php the_category(', '); ?></span>
                            </div>
                            
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b; line-height: 1.4;">
                                <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit;">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
                            <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">
                                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                            </p>
                            
                            <a href="<?php the_permalink(); ?>" style="color: #2dd4bf; font-weight: 600; text-decoration: none;">
                                Read More →
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div style="text-align: center;">
                <a href="<?php echo home_url('/blog'); ?>" class="btn btn-primary" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                    View All Blog Posts →
                </a>
            </div>
            
        <?php else : ?>
            <div style="text-align: center; padding: 3rem; background: white; border-radius: 20px;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
                <h3 style="color: #1e293b; margin-bottom: 1rem;">No Blog Posts Yet</h3>
                <p style="color: #64748b; margin-bottom: 2rem;">We're working on some amazing content for you!</p>
                <a href="<?php echo home_url('/blog'); ?>" class="btn btn-secondary" style="background: #64748b; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                    Visit Blog Page →
                </a>
            </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    </div>
</section>

<style>
/* Homepage ACF Styles */
.blog-preview-card:hover {
    transform: translateY(-5px);
}

.blog-preview-card:hover img {
    transform: scale(1.05);
}

.feature-card:hover {
    transform: translateY(-3px);
}

.tour-card:hover {
    transform: translateY(-5px);
}

.btn:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .stats-container {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .stats-grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .features-grid {
        grid-template-columns: 1fr !important;
    }
    
    .tours-grid {
        grid-template-columns: 1fr !important;
    }
    
    .testimonials-grid {
        grid-template-columns: 1fr !important;
    }
    
    .cta-buttons {
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .cta-features {
        flex-direction: column !important;
        gap: 1rem !important;
    }
}
</style>

<?php get_footer(); ?>
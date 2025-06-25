<?php
/*
Template Name: Homepage Template
*/

get_header(); ?>

<main class="main-content homepage-flexible">
    
    <?php if (have_rows('flexible_content')) : ?>
        <?php while (have_rows('flexible_content')) : the_row(); ?>
            
            <?php if (get_row_layout() == 'hero_section') : ?>
                <!-- Hero Section -->
                <section class="hero-section-flexible" style="position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; text-align: center; color: white; overflow: hidden;">
                    
                    <?php 
                    $bg_image = get_sub_field('background_image');
                    $bg_video = get_sub_field('background_video');
                    ?>
                    
                    <!-- Background -->
                    <?php if ($bg_video) : ?>
                        <video autoplay muted loop style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2;">
                            <source src="<?php echo esc_url($bg_video); ?>" type="video/mp4">
                        </video>
                    <?php elseif ($bg_image) : ?>
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-image: url('<?php echo esc_url($bg_image['url']); ?>'); background-size: cover; background-position: center; z-index: -2;"></div>
                    <?php endif; ?>
                    
                    <!-- Gradient Overlay -->
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(45, 212, 191, 0.8) 0%, rgba(59, 130, 246, 0.7) 50%, rgba(30, 64, 175, 0.8) 100%); z-index: -1;"></div>
                    
                    <div class="hero-content" style="max-width: 800px; padding: 2rem; z-index: 2;">
                        
                        <?php if ($badge_text = get_sub_field('badge_text')) : ?>
                            <div class="hero-badge" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); padding: 0.5rem 1.5rem; border-radius: 50px; margin-bottom: 2rem; display: inline-block; font-size: 0.9rem; font-weight: 500;">
                                <?php echo esc_html($badge_text); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($title = get_sub_field('title')) : ?>
                            <h1 class="hero-title" style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; line-height: 1.2; margin-bottom: 1.5rem;">
                                <?php 
                                $highlight_word = get_sub_field('highlight_word');
                                if ($highlight_word) {
                                    $highlighted_title = str_replace($highlight_word, '<span style="color: #2dd4bf;">' . $highlight_word . '</span>', $title);
                                    echo wp_kses_post(nl2br($highlighted_title));
                                } else {
                                    echo wp_kses_post(nl2br($title));
                                }
                                ?>
                            </h1>
                        <?php endif; ?>
                        
                        <?php if ($description = get_sub_field('description')) : ?>
                            <p class="hero-description" style="font-size: 1.25rem; margin-bottom: 3rem; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (have_rows('buttons')) : ?>
                            <div class="hero-buttons" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                                <?php while (have_rows('buttons')) : the_row(); ?>
                                    <?php 
                                    $button_text = get_sub_field('text');
                                    $button_icon = get_sub_field('icon');
                                    $button_link = get_sub_field('link');
                                    $button_style = get_sub_field('style');
                                    
                                    if ($button_link && $button_text) :
                                    ?>
                                        <a href="<?php echo esc_url($button_link['url']); ?>" 
                                           class="btn btn-<?php echo esc_attr($button_style); ?>"
                                           style="padding: 1rem 2rem; border-radius: 50px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; font-size: 1rem; <?php echo $button_style === 'primary' ? 'background: #2dd4bf; color: white;' : 'background: rgba(255,255,255,0.2); color: white; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);'; ?>"
                                           <?php if ($button_link['target']) echo 'target="' . esc_attr($button_link['target']) . '"'; ?>>
                                            <?php if ($button_icon) : ?>
                                                <span><?php echo esc_html($button_icon); ?></span>
                                            <?php endif; ?>
                                            <?php echo esc_html($button_text); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </section>

            <?php elseif (get_row_layout() == 'stats_section') : ?>
                <!-- Stats Section -->
                <section class="stats-section-flexible" style="background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 100%); color: white; padding: 2rem 0;">
                    <div class="stats-container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                        
                        <?php if ($title = get_sub_field('title')) : ?>
                            <div class="weather-info" style="text-align: center; margin-bottom: 2rem;">
                                <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;"><?php echo esc_html($title); ?></h3>
                                
                                <?php if ($subtitle = get_sub_field('subtitle')) : ?>
                                    <p style="opacity: 0.9;"><?php echo esc_html($subtitle); ?></p>
                                <?php endif; ?>
                                
                                <?php if (have_rows('weather_items')) : ?>
                                    <div class="weather-details" style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; margin-top: 1rem;">
                                        <?php while (have_rows('weather_items')) : the_row(); ?>
                                            <div class="weather-item" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                                                <span><?php echo esc_html(get_sub_field('icon')); ?></span>
                                                <span><?php echo esc_html(get_sub_field('text')); ?></span>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                        <?php endif; ?>
                        
                        <?php if (have_rows('statistics')) : ?>
                            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 2rem;">
                                <?php while (have_rows('statistics')) : the_row(); ?>
                                    <div class="stat-item" style="text-align: center;">
                                        <?php if ($icon = get_sub_field('icon')) : ?>
                                            <div style="font-size: 2rem; margin-bottom: 0.5rem;"><?php echo esc_html($icon); ?></div>
                                        <?php endif; ?>
                                        <span class="stat-number" style="font-size: 2.5rem; font-weight: 800; color: #2dd4bf; display: block; margin-bottom: 0.5rem;">
                                            <?php echo esc_html(get_sub_field('number')); ?>
                                        </span>
                                        <span class="stat-label" style="font-size: 1rem; opacity: 0.9;">
                                            <?php echo esc_html(get_sub_field('label')); ?>
                                        </span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </section>

            <?php elseif (get_row_layout() == 'features_section') : ?>
                <!-- Features Section -->
                <section class="features-section-flexible" style="padding: 6rem 0; background: #f8fafc;">
                    <div class="features-container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; text-align: center;">
                        
                        <?php if ($badge = get_sub_field('badge')) : ?>
                            <div class="section-badge" style="background: rgba(45, 212, 191, 0.1); color: #2dd4bf; padding: 0.5rem 1.5rem; border-radius: 50px; margin-bottom: 2rem; display: inline-block; font-size: 0.9rem; font-weight: 600;">
                                <?php echo esc_html($badge); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($title = get_sub_field('title')) : ?>
                            <h2 class="section-title" style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 1rem; color: #1e293b;">
                                <?php echo wp_kses_post(str_replace('Unmissable', '<span style="color: #2dd4bf;">Unmissable</span>', $title)); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ($description = get_sub_field('description')) : ?>
                            <p class="section-description" style="font-size: 1.25rem; color: #64748b; margin-bottom: 4rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (have_rows('features')) : ?>
                            <div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-top: 4rem;">
                                <?php while (have_rows('features')) : the_row(); ?>
                                    <?php
                                    $feature_image = get_sub_field('image');
                                    $feature_color = get_sub_field('color') ?: '#2dd4bf';
                                    ?>
                                    <div class="feature-card" style="background: white; padding: 3rem 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                                        
                                        <?php if ($feature_image) : ?>
                                            <div class="feature-image" style="width: 80px; height: 80px; border-radius: 20px; margin: 0 auto 2rem; overflow: hidden;">
                                                <img src="<?php echo esc_url($feature_image['url']); ?>" 
                                                     alt="<?php echo esc_attr($feature_image['alt']); ?>"
                                                     style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        <?php elseif ($icon = get_sub_field('icon')) : ?>
                                            <div class="feature-icon" style="width: 80px; height: 80px; border-radius: 20px; margin: 0 auto 2rem; display: flex; align-items: center; justify-content: center; font-size: 2rem; background: linear-gradient(135deg, <?php echo esc_attr($feature_color); ?>, <?php echo esc_attr($feature_color); ?>99);">
                                                <?php echo esc_html($icon); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($title = get_sub_field('title')) : ?>
                                            <h3 class="feature-title" style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #1e293b;">
                                                <?php echo esc_html($title); ?>
                                            </h3>
                                        <?php endif; ?>
                                        
                                        <?php if ($description = get_sub_field('description')) : ?>
                                            <p class="feature-description" style="color: #64748b; line-height: 1.6;">
                                                <?php echo esc_html($description); ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </section>

            <?php elseif (get_row_layout() == 'tours_section') : ?>
                <!-- Tours Section -->
                <section class="tours-section-flexible" style="padding: 6rem 0; background: white;">
                    <div class="tours-container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                        
                        <?php if ($badge = get_sub_field('badge')) : ?>
                            <div class="section-badge" style="background: rgba(45, 212, 191, 0.1); color: #2dd4bf; padding: 0.5rem 1.5rem; border-radius: 50px; margin-bottom: 2rem; display: inline-block; font-size: 0.9rem; font-weight: 600; text-align: center; width: 100%;">
                                <?php echo esc_html($badge); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($title = get_sub_field('title')) : ?>
                            <h2 class="section-title" style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 3rem; color: #1e293b; text-align: center;">
                                <?php echo esc_html($title); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (have_rows('tours')) : ?>
                            <div class="tours-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-top: 3rem;">
                                <?php while (have_rows('tours')) : the_row(); ?>
                                    <?php
                                    $tour_image = get_sub_field('image');
                                    $badge_color = get_sub_field('badge_color');
                                    $badge_colors = [
                                        'popular' => '#22c55e',
                                        'premium' => '#8b5cf6', 
                                        'adventure' => '#f59e0b',
                                        'new' => '#3b82f6'
                                    ];
                                    ?>
                                    <div class="tour-card" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition: transform 0.3s ease; position: relative;">
                                        
                                        <?php if ($badge = get_sub_field('badge')) : ?>
                                            <div class="tour-badge" style="position: absolute; top: 1rem; left: 1rem; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; color: white; z-index: 1; background: <?php echo esc_attr($badge_colors[$badge_color] ?? '#22c55e'); ?>;">
                                                <?php echo esc_html($badge); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="tour-image" style="height: 250px; position: relative; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: #94a3b8; <?php echo $tour_image ? 'background: url(' . esc_url($tour_image['url']) . ') center/cover;' : 'background: #e2e8f0;'; ?>">
                                            <?php if (!$tour_image && ($icon = get_sub_field('icon'))) : ?>
                                                <?php echo esc_html($icon); ?>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="tour-content" style="padding: 2rem;">
                                            
                                            <div class="tour-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                                <?php if ($title = get_sub_field('title')) : ?>
                                                    <h3 class="tour-title" style="font-size: 1.5rem; font-weight: 700; color: #1e293b;">
                                                        <?php echo esc_html($title); ?>
                                                    </h3>
                                                <?php endif; ?>
                                                
                                                <?php if ($duration = get_sub_field('duration')) : ?>
                                                    <span class="tour-duration" style="color: #64748b; font-size: 0.9rem;">
                                                        <?php echo esc_html($duration); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <?php if ($price = get_sub_field('price')) : ?>
                                                <div class="tour-price" style="font-size: 1.25rem; font-weight: 700; color: #2dd4bf; margin-bottom: 1rem;">
                                                    <?php echo esc_html($price); ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($description = get_sub_field('description')) : ?>
                                                <p class="tour-description" style="color: #64748b; margin-bottom: 2rem; line-height: 1.6;">
                                                    <?php echo esc_html($description); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <?php if (have_rows('details')) : ?>
                                                <div class="tour-details" style="display: flex; gap: 1rem; margin-bottom: 2rem; font-size: 0.9rem; color: #64748b; flex-wrap: wrap;">
                                                    <?php while (have_rows('details')) : the_row(); ?>
                                                        <div class="tour-detail" style="display: flex; align-items: center; gap: 0.3rem;">
                                                            <span><?php echo esc_html(get_sub_field('icon')); ?></span>
                                                            <span><?php echo esc_html(get_sub_field('text')); ?></span>
                                                        </div>
                                                    <?php endwhile; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($rating = get_sub_field('rating')) : ?>
                                                <div class="tour-rating" style="display: flex; align-items: center; gap: 0.3rem; margin-bottom: 2rem;">
                                                    <span class="stars" style="color: #fbbf24;">⭐</span>
                                                    <span><?php echo esc_html($rating); ?></span>
                                                    <?php if ($reviews = get_sub_field('reviews')) : ?>
                                                        <span>(<?php echo esc_html(number_format($reviews)); ?>)</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($link = get_sub_field('link')) : ?>
                                                <a href="<?php echo esc_url($link['url']); ?>" 
                                                   class="btn btn-primary"
                                                   style="background: #2dd4bf; color: white; padding: 0.75rem 1.5rem; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-block; transition: background 0.3s ease;"
                                                   <?php if ($link['target']) echo 'target="' . esc_attr($link['target']) . '"'; ?>>
                                                    <?php echo esc_html($link['title'] ?: 'Book Now →'); ?>
                                                </a>
                                            <?php endif; ?>
                                            
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </section>

            <?php elseif (get_row_layout() == 'testimonials_section') : ?>
                <!-- Testimonials Section -->
                <section class="testimonials-section-flexible" style="padding: 6rem 0; background: #f8fafc;">
                    <div class="testimonials-container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                        
                        <?php if ($title = get_sub_field('title')) : ?>
                            <h2 style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 3rem; color: #1e293b; text-align: center;">
                                <?php echo esc_html($title); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if (have_rows('testimonials')) : ?>
                            <div class="testimonials-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                                <?php while (have_rows('testimonials')) : the_row(); ?>
                                    <?php $avatar = get_sub_field('avatar'); ?>
                                    <div class="testimonial-card" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                                        
                                        <?php if ($rating = get_sub_field('rating')) : ?>
                                            <div class="testimonial-rating" style="margin-bottom: 1rem;">
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <span style="color: <?php echo $i <= $rating ? '#fbbf24' : '#e5e7eb'; ?>;">⭐</span>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($text = get_sub_field('text')) : ?>
                                            <blockquote style="font-style: italic; color: #64748b; margin-bottom: 2rem; line-height: 1.6;">
                                                "<?php echo esc_html($text); ?>"
                                            </blockquote>
                                        <?php endif; ?>
                                        
                                        <div class="testimonial-author" style="display: flex; align-items: center; gap: 1rem;">
                                            <?php if ($avatar) : ?>
                                                <img src="<?php echo esc_url($avatar['url']); ?>" 
                                                     alt="<?php echo esc_attr($avatar['alt']); ?>"
                                                     style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                            <?php else : ?>
                                                <div style="width: 50px; height: 50px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #64748b;">👤</div>
                                            <?php endif; ?>
                                            
                                            <div>
                                                <?php if ($name = get_sub_field('name')) : ?>
                                                    <div style="font-weight: 600; color: #1e293b;"><?php echo esc_html($name); ?></div>
                                                <?php endif; ?>
                                                <?php if ($location = get_sub_field('location')) : ?>
                                                    <div style="font-size: 0.9rem; color: #64748b;"><?php echo esc_html($location); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </section>

            <?php elseif (get_row_layout() == 'cta_section') : ?>
                <!-- CTA Section -->
                <section class="cta-section-flexible" style="padding: 6rem 0; background: linear-gradient(135deg, #2dd4bf 0%, #3b82f6 50%, #1e40af 100%); color: white; text-align: center;">
                    <div class="cta-container" style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
                        
                        <?php if ($badge = get_sub_field('badge')) : ?>
                            <div class="cta-badge" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); padding: 0.5rem 1.5rem; border-radius: 50px; margin-bottom: 2rem; display: inline-block; font-size: 0.9rem; font-weight: 500;">
                                <?php echo esc_html($badge); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($title = get_sub_field('title')) : ?>
                            <h2 class="cta-title" style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">
                                <?php echo esc_html($title); ?>
                            </h2>
                        <?php endif; ?>
                        
                        <?php if ($description = get_sub_field('description')) : ?>
                            <p class="cta-description" style="font-size: 1.25rem; margin-bottom: 3rem; opacity: 0.9;">
                                <?php echo esc_html($description); ?>
                            </p>
                        <?php endif; ?>
                        
                        <?php if (have_rows('buttons')) : ?>
                            <div class="cta-buttons" style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem;">
                                <?php while (have_rows('buttons')) : the_row(); ?>
                                    <?php 
                                    $button_text = get_sub_field('text');
                                    $button_icon = get_sub_field('icon');
                                    $button_link = get_sub_field('link');
                                    $button_style = get_sub_field('style');
                                    
                                    if ($button_link && $button_text) :
                                    ?>
                                        <a href="<?php echo esc_url($button_link['url']); ?>" 
                                           class="btn btn-<?php echo esc_attr($button_style); ?>"
                                           style="padding: 1rem 2rem; border-radius: 50px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; font-size: 1rem; <?php echo $button_style === 'primary' ? 'background: #2dd4bf; color: white;' : 'background: rgba(255,255,255,0.2); color: white; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);'; ?>"
                                           <?php if ($button_link['target']) echo 'target="' . esc_attr($button_link['target']) . '"'; ?>>
                                            <?php if ($button_icon) : ?>
                                                <span><?php echo esc_html($button_icon); ?></span>
                                            <?php endif; ?>
                                            <?php echo esc_html($button_text); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (have_rows('features')) : ?>
                            <div class="cta-features" style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; font-size: 0.9rem; opacity: 0.9;">
                                <?php while (have_rows('features')) : the_row(); ?>
                                    <div class="cta-feature" style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span><?php echo esc_html(get_sub_field('icon')); ?></span>
                                        <span><?php echo esc_html(get_sub_field('text')); ?></span>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </section>

            <?php endif; ?>
            
        <?php endwhile; ?>
    <?php else : ?>
        <!-- Default Content -->
        <section style="padding: 6rem 0; text-align: center;">
            <div style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
                <h1 style="font-size: 3rem; margin-bottom: 2rem; color: #1e293b;">Welcome to Milford Sound</h1>
                <p style="font-size: 1.25rem; color: #64748b; margin-bottom: 3rem;">Use the flexible content fields to build your homepage sections.</p>
                <a href="<?php echo admin_url('post.php?post=' . get_the_ID() . '&action=edit'); ?>" style="background: #2dd4bf; color: white; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 600;">
                    Edit Page Content →
                </a>
            </div>
        </section>
    <?php endif; ?>
    
</main>

<style>
/* Hover Effects */
.feature-card:hover {
    transform: translateY(-5px);
}

.tour-card:hover {
    transform: translateY(-5px);
}

.testimonial-card:hover {
    transform: translateY(-3px);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.btn-primary:hover {
    background: #22c55e !important;
}

.btn-secondary:hover {
    background: rgba(255,255,255,0.3) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-buttons {
        flex-direction: column !important;
        align-items: center !important;
    }
    
    .weather-details {
        flex-direction: column !important;
        gap: 1rem !important;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
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

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr !important;
    }
    
    .tour-details {
        flex-direction: column !important;
        gap: 0.5rem !important;
    }
}
</style>

<?php get_footer(); ?>
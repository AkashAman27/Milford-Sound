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
                <!-- Modern Hero Section with Tailwind CSS -->
                <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-primary via-secondary to-purple-600">
                    
                    <?php 
                    $bg_image = safe_get($section, 'hero_background_image', safe_get($section, 'background_image'));
                    $bg_video = safe_get($section, 'hero_background_video', safe_get($section, 'background_video'));
                    ?>
                    
                    <!-- Background Elements -->
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-secondary/30 to-purple-600/20 animate-gradient-x"></div>
                    
                    <?php if ($bg_image) : ?>
                        <div class="absolute inset-0 z-0">
                            <img src="<?php echo esc_url($bg_image['url']); ?>" 
                                 alt="Hero Background" 
                                 class="w-full h-full object-cover opacity-30 scale-105 animate-pulse">
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($bg_video) : ?>
                        <div class="absolute inset-0 z-0">
                            <?php if (strpos($bg_video, 'youtube.com') !== false || strpos($bg_video, 'youtu.be') !== false) : ?>
                                <?php
                                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $bg_video, $matches);
                                $video_id = $matches[1] ?? '';
                                ?>
                                <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($video_id); ?>&controls=0&showinfo=0&rel=0&modestbranding=1&playsinline=1&iv_load_policy=3" 
                                        frameborder="0" 
                                        allow="autoplay; encrypted-media" 
                                        class="w-full h-full object-cover opacity-40 pointer-events-none scale-105">
                                </iframe>
                            <?php else : ?>
                                <video autoplay muted loop playsinline class="w-full h-full object-cover opacity-40 pointer-events-none scale-105">
                                    <source src="<?php echo esc_url($bg_video); ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                        </div>
                        <!-- Video Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-br from-black/50 via-black/30 to-black/60 z-10"></div>
                    <?php endif; ?>
                    
                    <!-- Floating Elements -->
                    <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-bounce delay-1000"></div>
                    <div class="absolute bottom-32 right-16 w-16 h-16 bg-primary/20 rounded-full blur-lg animate-pulse delay-500"></div>
                    <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-secondary/15 rounded-full blur-md animate-bounce delay-1500"></div>
                    
                    <!-- Main Content -->
                    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <div class="space-y-8 animate-fade-in-up">
                            
                            <?php if (safe_get($section, 'badge_text')) : ?>
                                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-lg border border-white/20 px-6 py-3 rounded-full text-sm font-semibold text-white shadow-lg animate-fade-in-down">
                                    <div class="w-2 h-2 bg-primary rounded-full animate-pulse"></div>
                                    <?php echo esc_html($section['badge_text']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'title')) : ?>
                                <h1 class="text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black text-white leading-tight tracking-tight animate-fade-in-up" style="animation-delay: 0.2s;">
                                    <?php 
                                    $title = $section['title'];
                                    $highlight_word = safe_get($section, 'highlight_word');
                                    
                                    if ($highlight_word) {
                                        $title = str_replace($highlight_word, '<span class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent animate-pulse">' . $highlight_word . '</span>', $title);
                                    }
                                    
                                    echo wp_kses($title, array('span' => array('class' => array())));
                                    ?>
                                </h1>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'description')) : ?>
                                <p class="text-xl md:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed font-light animate-fade-in-up" style="animation-delay: 0.4s;">
                                    <?php echo esc_html($section['description']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'buttons') && !empty($section['buttons'])) : ?>
                                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center pt-8 animate-fade-in-up" style="animation-delay: 0.6s;">
                                    <?php foreach ($section['buttons'] as $index => $button) : ?>
                                        <?php
                                        $btn_style = safe_get($button, 'style', safe_get($button, 'button_style', 'primary'));
                                        $btn_classes = ($btn_style === 'primary') 
                                            ? 'bg-gradient-to-r from-primary to-secondary text-white shadow-2xl shadow-primary/50 hover:shadow-primary/70 hover:scale-105' 
                                            : 'bg-white/10 border-2 border-white/30 text-white backdrop-blur-lg hover:bg-white/20 hover:border-white/50';
                                        ?>
                                        <a href="<?php echo esc_url(safe_get(safe_get($button, 'link'), 'url', safe_get(safe_get($button, 'button_link'), 'url', '#'))); ?>" 
                                           class="<?php echo $btn_classes; ?> px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:-translate-y-1 group inline-flex items-center gap-3 min-w-[200px] justify-center animate-scale-in"
                                           style="animation-delay: <?php echo 0.8 + ($index * 0.1); ?>s;"
                                           <?php 
                                           $link_target = safe_get(safe_get($button, 'link'), 'target', safe_get(safe_get($button, 'button_link'), 'target'));
                                           if ($link_target) echo 'target="' . esc_attr($link_target) . '"'; 
                                           ?>>
                                            <?php if (safe_get($button, 'icon')) : ?>
                                                <span class="text-xl"><?php echo esc_html($button['icon']); ?></span>
                                            <?php endif; ?>
                                            <span><?php echo esc_html(safe_get($button, 'text', safe_get($button, 'button_text', 'Button'))); ?></span>
                                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Scroll Indicator -->
                            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                                <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                                    <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </section>
                <?php
                break;
                
            case 'stats_section':
                ?>
                <!-- Ultra-Modern Stats Section -->
                <section class="py-24 bg-gradient-to-br from-white via-blue-50 to-indigo-50 relative overflow-hidden">
                    <!-- Animated Background Elements -->
                    <div class="absolute inset-0">
                        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
                        <div class="absolute -top-20 -left-20 w-40 h-40 bg-primary/10 rounded-full blur-3xl animate-pulse"></div>
                        <div class="absolute -bottom-20 -right-20 w-60 h-60 bg-secondary/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
                    </div>
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 items-center">
                            
                            <!-- Weather/Info Panel -->
                            <div class="lg:col-span-2">
                                <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 shadow-2xl border border-white/50 hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-2 animate-fade-in-up">
                                    <?php if (safe_get($section, 'title')) : ?>
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center text-white text-2xl">
                                                🌊
                                            </div>
                                            <h3 class="text-2xl font-black text-gray-900">
                                                <?php echo esc_html($section['title']); ?>
                                            </h3>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (safe_get($section, 'subtitle')) : ?>
                                        <p class="text-gray-600 text-lg leading-relaxed mb-6">
                                            <?php echo esc_html($section['subtitle']); ?>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if (safe_get($section, 'weather_items') && !empty($section['weather_items'])) : ?>
                                        <div class="space-y-4">
                                            <?php foreach ($section['weather_items'] as $index => $item) : ?>
                                                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl hover:from-primary/10 hover:to-secondary/10 transition-all duration-300 animate-scale-in" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                                                    <div class="text-2xl">
                                                        <?php echo esc_html(safe_get($item, 'icon')); ?>
                                                    </div>
                                                    <span class="font-semibold text-gray-800">
                                                        <?php echo esc_html(safe_get($item, 'text')); ?>
                                                    </span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Modern Statistics Grid -->
                            <?php if (safe_get($section, 'statistics') && !empty($section['statistics'])) : ?>
                                <div class="lg:col-span-3">
                                    <div class="grid grid-cols-2 gap-6">
                                        <?php foreach ($section['statistics'] as $index => $stat) : ?>
                                            <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 text-center shadow-xl border border-white/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 hover:scale-105 group animate-fade-in-up" style="animation-delay: <?php echo ($index * 0.15) + 0.2; ?>s;">
                                                
                                                <!-- Icon with Gradient Background -->
                                                <?php if (safe_get($stat, 'stat_icon', safe_get($stat, 'icon'))) : ?>
                                                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center text-white text-3xl mb-6 mx-auto group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                        <?php echo esc_html(safe_get($stat, 'stat_icon', safe_get($stat, 'icon'))); ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- Animated Number -->
                                                <div class="stat-number text-4xl md:text-5xl font-black bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent mb-3 group-hover:from-primary group-hover:to-secondary transition-all duration-500" data-target="<?php echo esc_attr(preg_replace('/[^0-9]/', '', safe_get($stat, 'stat_number', safe_get($stat, 'number')))); ?>">
                                                    <?php echo esc_html(safe_get($stat, 'stat_number', safe_get($stat, 'number'))); ?>
                                                </div>
                                                
                                                <!-- Label -->
                                                <div class="text-gray-600 font-semibold text-sm uppercase tracking-wide group-hover:text-gray-800 transition-colors duration-300">
                                                    <?php echo esc_html(safe_get($stat, 'stat_label', safe_get($stat, 'label'))); ?>
                                                </div>
                                                
                                                <!-- Decorative Line -->
                                                <div class="w-16 h-1 bg-gradient-to-r from-primary to-secondary rounded-full mx-auto mt-4 group-hover:w-24 transition-all duration-300"></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                    
                    <!-- Counter Animation Script -->
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const observerOptions = {
                            threshold: 0.7,
                            rootMargin: '0px 0px -50px 0px'
                        };
                        
                        const observer = new IntersectionObserver((entries) => {
                            entries.forEach(entry => {
                                if (entry.isIntersecting) {
                                    animateNumber(entry.target);
                                }
                            });
                        }, observerOptions);
                        
                        document.querySelectorAll('.stat-number').forEach(stat => {
                            observer.observe(stat);
                        });
                        
                        function animateNumber(element) {
                            const target = parseInt(element.dataset.target) || 0;
                            const increment = target / 100;
                            let current = 0;
                            
                            const timer = setInterval(() => {
                                current += increment;
                                if (current >= target) {
                                    current = target;
                                    clearInterval(timer);
                                }
                                
                                const displayValue = Math.floor(current);
                                const originalText = element.textContent;
                                const suffix = originalText.replace(/[0-9]/g, '');
                                element.textContent = displayValue + suffix;
                            }, 20);
                        }
                    });
                    </script>
                </section>
                <?php
                break;
                
            case 'features_section':
                ?>
                <!-- Ultra-Modern Features Section -->
                <section class="py-24 bg-white relative overflow-hidden">
                    <!-- Animated Background -->
                    <div class="absolute inset-0">
                        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-primary/5 to-secondary/10 rounded-full blur-3xl"></div>
                        <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-purple-500/5 to-pink-500/10 rounded-full blur-3xl"></div>
                    </div>
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        
                        <!-- Section Header -->
                        <div class="text-center mb-20">
                            <?php if (safe_get($section, 'badge')) : ?>
                                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-full text-sm font-semibold mb-6 shadow-lg animate-fade-in-down">
                                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    <?php echo esc_html($section['badge']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'title')) : ?>
                                <h2 class="text-5xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight animate-fade-in-up">
                                    <?php echo esc_html($section['title']); ?>
                                </h2>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'description')) : ?>
                                <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
                                    <?php echo esc_html($section['description']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full mt-8 animate-scale-in"></div>
                        </div>
                        
                        <?php if (safe_get($section, 'features') && !empty($section['features'])) : ?>
                            <!-- Modern Features Container -->
                            <div class="relative group">
                                
                                <!-- Enhanced Navigation -->
                                <button class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-white/90 backdrop-blur-xl hover:bg-white text-gray-700 hover:text-primary w-14 h-14 rounded-2xl shadow-2xl hover:shadow-primary/20 transition-all duration-500 transform hover:scale-110 opacity-0 group-hover:opacity-100 flex items-center justify-center border border-gray-200/50" onclick="scrollFeatures(-1)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                
                                <button class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-white/90 backdrop-blur-xl hover:bg-white text-gray-700 hover:text-primary w-14 h-14 rounded-2xl shadow-2xl hover:shadow-primary/20 transition-all duration-500 transform hover:scale-110 opacity-0 group-hover:opacity-100 flex items-center justify-center border border-gray-200/50" onclick="scrollFeatures(1)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Premium Features Carousel -->
                                <div class="features-carousel overflow-x-auto scrollbar-hide flex gap-8 pb-6 scroll-smooth" id="featuresCarousel">
                                    <?php foreach ($section['features'] as $index => $feature) : ?>
                                        <div class="feature-card flex-none w-80 bg-gradient-to-br from-white to-gray-50 rounded-3xl p-8 text-center shadow-xl hover:shadow-2xl border border-gray-100 transition-all duration-700 transform hover:-translate-y-3 hover:rotate-1 group/card animate-fade-in-up" style="animation-delay: <?php echo $index * 0.15; ?>s;">
                                            
                                            <!-- Modern Icon -->
                                            <div class="mb-8">
                                                <?php if (safe_get($feature, 'image')) : ?>
                                                    <div class="w-20 h-20 mx-auto rounded-3xl overflow-hidden ring-4 ring-primary/10 group-hover/card:ring-primary/30 transition-all duration-300">
                                                        <img src="<?php echo esc_url($feature['image']['sizes']['thumbnail']); ?>" 
                                                             alt="<?php echo esc_attr($feature['image']['alt']); ?>"
                                                             class="w-full h-full object-cover">
                                                    </div>
                                                <?php else : ?>
                                                    <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center text-4xl text-white shadow-xl group-hover/card:scale-110 transition-transform duration-300" style="background: <?php echo esc_attr(safe_get($feature, 'color', 'linear-gradient(135deg, #2dd4bf, #3b82f6)')); ?>;">
                                                        <?php echo esc_html(safe_get($feature, 'feature_icon', '⭐')); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Title -->
                                            <?php if (safe_get($feature, 'feature_title')) : ?>
                                                <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover/card:text-primary transition-colors duration-300">
                                                    <?php echo esc_html($feature['feature_title']); ?>
                                                </h3>
                                            <?php endif; ?>
                                            
                                            <!-- Description -->
                                            <?php if (safe_get($feature, 'feature_description')) : ?>
                                                <p class="text-gray-600 leading-relaxed group-hover/card:text-gray-700 transition-colors duration-300">
                                                    <?php echo esc_html($feature['feature_description']); ?>
                                                </p>
                                            <?php endif; ?>
                                            
                                            <!-- Decorative Element -->
                                            <div class="mt-6 w-16 h-1 bg-gradient-to-r from-primary to-secondary rounded-full mx-auto group-hover/card:w-24 transition-all duration-300"></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Add Features Carousel JavaScript -->
                            <script>
                            function scrollFeatures(direction) {
                                const carousel = document.getElementById('featuresCarousel');
                                const cardWidth = 352; // w-80 (320px) + gap-8 (32px)
                                const currentScroll = carousel.scrollLeft;
                                
                                carousel.scrollTo({
                                    left: currentScroll + (direction * cardWidth),
                                    behavior: 'smooth'
                                });
                            }
                            
                            // Enhanced auto-scroll for features
                            let featuresAutoScrollInterval;
                            let featuresCurrentIndex = 0;
                            
                            function startFeaturesAutoScroll() {
                                const carousel = document.getElementById('featuresCarousel');
                                if (!carousel || carousel.children.length <= 1) return;
                                
                                featuresAutoScrollInterval = setInterval(() => {
                                    const containerWidth = carousel.offsetWidth;
                                    const cardWidth = 352;
                                    const maxScroll = carousel.scrollWidth - containerWidth;
                                    
                                    if (carousel.scrollLeft >= maxScroll - 10) {
                                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                                        featuresCurrentIndex = 0;
                                    } else {
                                        featuresCurrentIndex++;
                                        carousel.scrollTo({ 
                                            left: featuresCurrentIndex * cardWidth, 
                                            behavior: 'smooth' 
                                        });
                                    }
                                }, 5000); // Change every 5 seconds
                            }
                            
                            function stopFeaturesAutoScroll() {
                                clearInterval(featuresAutoScrollInterval);
                            }
                            
                            // Initialize features
                            document.addEventListener('DOMContentLoaded', function() {
                                const carousel = document.getElementById('featuresCarousel');
                                const container = carousel?.parentElement;
                                
                                if (carousel && container) {
                                    startFeaturesAutoScroll();
                                    
                                    container.addEventListener('mouseenter', stopFeaturesAutoScroll);
                                    container.addEventListener('mouseleave', startFeaturesAutoScroll);
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
                <!-- Modern Tours Section with Tailwind CSS -->
                <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50" id="tours">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        
                        <!-- Section Header -->
                        <div class="text-center mb-16">
                            <?php if (safe_get($section, 'badge')) : ?>
                                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-primary to-secondary text-white px-6 py-3 rounded-full text-sm font-semibold mb-6 shadow-lg">
                                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    <?php echo esc_html($section['badge']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (safe_get($section, 'title')) : ?>
                                <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-4 leading-tight">
                                    <?php echo esc_html($section['title']); ?>
                                </h2>
                            <?php endif; ?>
                            
                            <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full mb-8"></div>
                        </div>
                        
                        <?php if (safe_get($section, 'tours') && !empty($section['tours'])) : ?>
                            <!-- Tours Carousel Container -->
                            <div class="relative group">
                                
                                <!-- Navigation Arrows -->
                                <button class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-white/90 backdrop-blur-lg hover:bg-white text-gray-700 hover:text-primary w-12 h-12 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110 opacity-0 group-hover:opacity-100 flex items-center justify-center" onclick="scrollTours(-1)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                
                                <button class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-white/90 backdrop-blur-lg hover:bg-white text-gray-700 hover:text-primary w-12 h-12 rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110 opacity-0 group-hover:opacity-100 flex items-center justify-center" onclick="scrollTours(1)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Tours Carousel -->
                                <div class="tours-carousel overflow-x-auto scrollbar-hide flex gap-6 pb-4 scroll-smooth" id="toursCarousel">
                                    <?php foreach ($section['tours'] as $index => $tour) : ?>
                                        <div class="tour-card flex-none w-80 bg-white rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 group/card animate-fade-in-up" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                                            
                                            <!-- Card Image -->
                                            <div class="relative h-48 overflow-hidden">
                                                <?php if (safe_get($tour, 'image')) : ?>
                                                    <img src="<?php echo esc_url($tour['image']['sizes']['medium_large']); ?>" 
                                                         alt="<?php echo esc_attr($tour['image']['alt']); ?>"
                                                         class="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110">
                                                <?php else : ?>
                                                    <div class="w-full h-full bg-gradient-to-br from-primary/20 to-secondary/20 flex items-center justify-center">
                                                        <span class="text-6xl">
                                                            <?php echo esc_html(safe_get($tour, 'icon', '🎯')); ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- Gradient Overlay -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                                
                                                <!-- Badge -->
                                                <?php if (safe_get($tour, 'badge')) : ?>
                                                    <?php
                                                    $badge_color = safe_get($tour, 'badge_color', 'popular');
                                                    $badge_classes = array(
                                                        'popular' => 'bg-gradient-to-r from-green-500 to-green-600',
                                                        'premium' => 'bg-gradient-to-r from-purple-500 to-purple-600',
                                                        'adventure' => 'bg-gradient-to-r from-orange-500 to-orange-600',
                                                        'new' => 'bg-gradient-to-r from-blue-500 to-blue-600'
                                                    );
                                                    ?>
                                                    <div class="absolute top-4 left-4 <?php echo $badge_classes[$badge_color]; ?> text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">
                                                        <?php echo esc_html($tour['badge']); ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- Duration -->
                                                <?php if (safe_get($tour, 'duration')) : ?>
                                                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-700 px-3 py-1.5 rounded-full text-xs font-semibold">
                                                        <?php echo esc_html($tour['duration']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Card Content -->
                                            <div class="p-6 flex flex-col h-80">
                                                
                                                <!-- Title & Price -->
                                                <div class="mb-4">
                                                    <?php if (safe_get($tour, 'title')) : ?>
                                                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover/card:text-primary transition-colors duration-300">
                                                            <?php echo esc_html($tour['title']); ?>
                                                        </h3>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (safe_get($tour, 'price')) : ?>
                                                        <div class="text-2xl font-black text-primary">
                                                            <?php echo esc_html($tour['price']); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <!-- Description -->
                                                <?php if (safe_get($tour, 'description')) : ?>
                                                    <p class="text-gray-600 text-sm leading-relaxed mb-4 flex-grow line-clamp-3">
                                                        <?php echo esc_html($tour['description']); ?>
                                                    </p>
                                                <?php endif; ?>
                                                
                                                <!-- Tour Details -->
                                                <?php if (safe_get($tour, 'details') && !empty($tour['details'])) : ?>
                                                    <div class="flex flex-wrap gap-3 mb-4">
                                                        <?php foreach (array_slice($tour['details'], 0, 3) as $detail) : ?>
                                                            <div class="flex items-center gap-1 text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">
                                                                <span><?php echo esc_html(safe_get($detail, 'icon')); ?></span>
                                                                <span><?php echo esc_html(safe_get($detail, 'text')); ?></span>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- Rating -->
                                                <?php if (safe_get($tour, 'rating') && safe_get($tour, 'reviews')) : ?>
                                                    <div class="flex items-center gap-2 mb-6">
                                                        <div class="flex items-center">
                                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                                <svg class="w-4 h-4 <?php echo $i <= floor($tour['rating']) ? 'text-yellow-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                            <?php endfor; ?>
                                                        </div>
                                                        <span class="text-sm font-semibold text-gray-900"><?php echo esc_html($tour['rating']); ?></span>
                                                        <span class="text-sm text-gray-500">(<?php echo esc_html(number_format($tour['reviews'])); ?>)</span>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <!-- CTA Button -->
                                                <?php if (safe_get($tour, 'link')) : ?>
                                                    <a href="<?php echo esc_url(safe_get($tour['link'], 'url', '#')); ?>" 
                                                       class="w-full bg-gradient-to-r from-primary to-secondary text-white py-3 px-6 rounded-xl font-bold text-center transition-all duration-300 transform hover:scale-105 hover:shadow-lg group/button"
                                                       <?php if (safe_get($tour['link'], 'target')) echo 'target="' . esc_attr($tour['link']['target']) . '"'; ?>>
                                                        <span class="flex items-center justify-center gap-2">
                                                            <?php echo esc_html(safe_get($tour, 'button_text', 'Book Now')); ?>
                                                            <svg class="w-4 h-4 transition-transform duration-300 group-hover/button:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                <?php endif; ?>
                                                
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Scroll Indicators -->
                                <div class="flex justify-center mt-8 space-x-2" id="tour-indicators">
                                    <!-- Indicators will be generated by JavaScript -->
                                </div>
                                
                            </div>
                            
                            <!-- Modern Carousel JavaScript -->
                            <script>
                            function scrollTours(direction) {
                                const carousel = document.getElementById('toursCarousel');
                                const cardWidth = 344; // 320px (w-80) + 24px (gap-6)
                                const currentScroll = carousel.scrollLeft;
                                
                                if (direction === 1) {
                                    carousel.scrollTo({
                                        left: currentScroll + cardWidth,
                                        behavior: 'smooth'
                                    });
                                } else {
                                    carousel.scrollTo({
                                        left: currentScroll - cardWidth,
                                        behavior: 'smooth'
                                    });
                                }
                                updateIndicators();
                            }
                            
                            // Enhanced auto-scroll with indicators
                            let toursAutoScrollInterval;
                            let toursCurrentIndex = 0;
                            
                            function updateIndicators() {
                                const carousel = document.getElementById('toursCarousel');
                                const indicators = document.getElementById('tour-indicators');
                                const cards = carousel.children;
                                const containerWidth = carousel.offsetWidth;
                                const cardWidth = 344;
                                const visibleCards = Math.floor(containerWidth / cardWidth);
                                const totalSlides = Math.max(1, cards.length - visibleCards + 1);
                                
                                // Clear existing indicators
                                indicators.innerHTML = '';
                                
                                // Create indicators
                                for (let i = 0; i < totalSlides; i++) {
                                    const indicator = document.createElement('button');
                                    indicator.className = `w-3 h-3 rounded-full transition-all duration-300 ${
                                        i === Math.floor(carousel.scrollLeft / cardWidth) 
                                            ? 'bg-primary shadow-lg' 
                                            : 'bg-gray-300 hover:bg-gray-400'
                                    }`;
                                    indicator.addEventListener('click', () => {
                                        carousel.scrollTo({
                                            left: i * cardWidth,
                                            behavior: 'smooth'
                                        });
                                        setTimeout(updateIndicators, 300);
                                    });
                                    indicators.appendChild(indicator);
                                }
                            }
                            
                            function startToursAutoScroll() {
                                const carousel = document.getElementById('toursCarousel');
                                if (!carousel || carousel.children.length <= 1) return;
                                
                                toursAutoScrollInterval = setInterval(() => {
                                    const containerWidth = carousel.offsetWidth;
                                    const cardWidth = 344;
                                    const maxScroll = carousel.scrollWidth - containerWidth;
                                    
                                    if (carousel.scrollLeft >= maxScroll - 10) {
                                        // Reset to beginning with smooth transition
                                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                                        toursCurrentIndex = 0;
                                    } else {
                                        // Scroll to next card
                                        toursCurrentIndex++;
                                        carousel.scrollTo({ 
                                            left: toursCurrentIndex * cardWidth, 
                                            behavior: 'smooth' 
                                        });
                                    }
                                    
                                    setTimeout(updateIndicators, 300);
                                }, 5000); // Change every 5 seconds
                            }
                            
                            function stopToursAutoScroll() {
                                clearInterval(toursAutoScrollInterval);
                            }
                            
                            // Initialize enhanced carousel
                            document.addEventListener('DOMContentLoaded', function() {
                                const carousel = document.getElementById('toursCarousel');
                                const container = carousel?.parentElement;
                                
                                if (carousel && container) {
                                    // Initialize indicators
                                    updateIndicators();
                                    
                                    // Start auto-scroll
                                    startToursAutoScroll();
                                    
                                    // Pause on hover
                                    container.addEventListener('mouseenter', stopToursAutoScroll);
                                    container.addEventListener('mouseleave', startToursAutoScroll);
                                    
                                    // Update indicators on scroll
                                    carousel.addEventListener('scroll', () => {
                                        clearTimeout(carousel.scrollTimeout);
                                        carousel.scrollTimeout = setTimeout(updateIndicators, 150);
                                    });
                                    
                                    // Update indicators on resize
                                    window.addEventListener('resize', () => {
                                        setTimeout(updateIndicators, 100);
                                    });
                                }
                            });
                            </script>
                        <?php endif; ?>
                        
                    </div>
                </section>
                <?php
                break;
                
            case 'testimonials_section':
                ?>
                <!-- Ultra-Modern Testimonials Section -->
                <section class="py-24 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
                    <!-- Animated Background Elements -->
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-primary/10 to-secondary/10 rounded-full blur-3xl animate-pulse"></div>
                        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-purple-400/10 to-pink-400/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
                    </div>
                    
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                        
                        <!-- Section Header -->
                        <div class="text-center mb-20">
                            <?php if (safe_get($section, 'title')) : ?>
                                <h2 class="text-5xl md:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 mb-6 leading-tight animate-fade-in-up">
                                    <?php echo esc_html($section['title']); ?>
                                </h2>
                            <?php endif; ?>
                            
                            <div class="w-32 h-1.5 bg-gradient-to-r from-primary via-secondary to-purple-500 mx-auto rounded-full mb-8 animate-scale-in"></div>
                            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
                                Discover what our adventurers say about their unforgettable Milford Sound experiences
                            </p>
                        </div>
                        
                        <?php if (safe_get($section, 'testimonials') && !empty($section['testimonials'])) : ?>
                            <!-- Modern Testimonials Container -->
                            <div class="relative group">
                                
                                <!-- Enhanced Navigation Arrows -->
                                <button class="absolute left-4 top-1/2 -translate-y-1/2 z-30 bg-white/90 backdrop-blur-xl hover:bg-white text-gray-700 hover:text-primary w-14 h-14 rounded-2xl shadow-2xl hover:shadow-primary/20 transition-all duration-500 transform hover:scale-110 opacity-0 group-hover:opacity-100 flex items-center justify-center border border-gray-200/50" onclick="scrollTestimonials(-1)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                
                                <button class="absolute right-4 top-1/2 -translate-y-1/2 z-30 bg-white/90 backdrop-blur-xl hover:bg-white text-gray-700 hover:text-primary w-14 h-14 rounded-2xl shadow-2xl hover:shadow-primary/20 transition-all duration-500 transform hover:scale-110 opacity-0 group-hover:opacity-100 flex items-center justify-center border border-gray-200/50" onclick="scrollTestimonials(1)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Premium Testimonials Carousel -->
                                <div class="testimonials-carousel overflow-x-auto scrollbar-hide flex gap-8 pb-6 scroll-smooth" id="testimonialsCarousel">
                                    <?php foreach ($section['testimonials'] as $index => $testimonial) : ?>
                                        <div class="testimonial-card flex-none w-96 bg-white/70 backdrop-blur-lg rounded-3xl p-8 shadow-xl hover:shadow-2xl border border-white/50 transition-all duration-700 transform hover:-translate-y-3 hover:rotate-1 group/card animate-fade-in-up" style="animation-delay: <?php echo $index * 0.15; ?>s;">
                                            
                                            <!-- Quote Icon -->
                                            <div class="mb-6">
                                                <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center shadow-lg group-hover/card:scale-110 transition-transform duration-300">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            
                                            <!-- Rating Stars -->
                                            <?php if (safe_get($testimonial, 'rating')) : ?>
                                                <div class="flex items-center gap-1 mb-6">
                                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                        <svg class="w-5 h-5 <?php echo $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-300'; ?> transition-colors duration-300" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    <?php endfor; ?>
                                                    <span class="ml-2 text-sm font-semibold text-gray-700"><?php echo esc_html($testimonial['rating']); ?>/5</span>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <!-- Testimonial Text -->
                                            <?php if (safe_get($testimonial, 'text')) : ?>
                                                <blockquote class="text-gray-700 text-lg leading-relaxed mb-8 font-medium italic group-hover/card:text-gray-800 transition-colors duration-300">
                                                    "<?php echo esc_html($testimonial['text']); ?>"
                                                </blockquote>
                                            <?php endif; ?>
                                            
                                            <!-- Author Section -->
                                            <div class="flex items-center gap-4 mt-auto">
                                                <!-- Avatar -->
                                                <div class="relative">
                                                    <?php if (safe_get($testimonial, 'avatar')) : ?>
                                                        <div class="w-14 h-14 rounded-full overflow-hidden ring-4 ring-primary/20 group-hover/card:ring-primary/40 transition-all duration-300">
                                                            <img src="<?php echo esc_url($testimonial['avatar']['sizes']['thumbnail']); ?>" 
                                                                 alt="<?php echo esc_attr($testimonial['avatar']['alt']); ?>"
                                                                 class="w-full h-full object-cover">
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-lg ring-4 ring-primary/20 group-hover/card:ring-primary/40 transition-all duration-300">
                                                            <?php echo esc_html(substr(safe_get($testimonial, 'name', 'U'), 0, 1)); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <!-- Verified Badge -->
                                                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center ring-2 ring-white">
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                
                                                <!-- Author Info -->
                                                <div class="flex-1">
                                                    <?php if (safe_get($testimonial, 'name')) : ?>
                                                        <div class="font-bold text-gray-900 text-lg group-hover/card:text-primary transition-colors duration-300">
                                                            <?php echo esc_html($testimonial['name']); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if (safe_get($testimonial, 'location')) : ?>
                                                        <div class="text-gray-500 text-sm flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            </svg>
                                                            <?php echo esc_html($testimonial['location']); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <!-- Modern Testimonials JavaScript -->
                            <script>
                            function scrollTestimonials(direction) {
                                const carousel = document.getElementById('testimonialsCarousel');
                                const cardWidth = 416; // 384px (w-96) + 32px (gap-8)
                                const currentScroll = carousel.scrollLeft;
                                
                                carousel.scrollTo({
                                    left: currentScroll + (direction * cardWidth),
                                    behavior: 'smooth'
                                });
                            }
                            
                            // Enhanced auto-scroll for testimonials
                            let testimonialsAutoScrollInterval;
                            let testimonialsCurrentIndex = 0;
                            
                            function startTestimonialsAutoScroll() {
                                const carousel = document.getElementById('testimonialsCarousel');
                                if (!carousel || carousel.children.length <= 1) return;
                                
                                testimonialsAutoScrollInterval = setInterval(() => {
                                    const containerWidth = carousel.offsetWidth;
                                    const cardWidth = 416;
                                    const maxScroll = carousel.scrollWidth - containerWidth;
                                    
                                    if (carousel.scrollLeft >= maxScroll - 10) {
                                        carousel.scrollTo({ left: 0, behavior: 'smooth' });
                                        testimonialsCurrentIndex = 0;
                                    } else {
                                        testimonialsCurrentIndex++;
                                        carousel.scrollTo({ 
                                            left: testimonialsCurrentIndex * cardWidth, 
                                            behavior: 'smooth' 
                                        });
                                    }
                                }, 6000); // Change every 6 seconds
                            }
                            
                            function stopTestimonialsAutoScroll() {
                                clearInterval(testimonialsAutoScrollInterval);
                            }
                            
                            // Initialize testimonials
                            document.addEventListener('DOMContentLoaded', function() {
                                const carousel = document.getElementById('testimonialsCarousel');
                                const container = carousel?.parentElement;
                                
                                if (carousel && container) {
                                    startTestimonialsAutoScroll();
                                    
                                    container.addEventListener('mouseenter', stopTestimonialsAutoScroll);
                                    container.addEventListener('mouseleave', startTestimonialsAutoScroll);
                                }
                            });
                            </script>
                        <?php endif; ?>
                        
                    </div>
                </section>
                <?php
                break;
                
            case 'cta_section':
                ?>
                <!-- Ultra-Modern CTA Section -->
                <section class="relative py-32 overflow-hidden bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900">
                    <!-- Animated Background -->
                    <div class="absolute inset-0">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/20 via-secondary/20 to-purple-600/20 animate-gradient-x"></div>
                        
                        <!-- Floating Orbs -->
                        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/10 rounded-full blur-3xl animate-pulse"></div>
                        <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-500"></div>
                        
                        <!-- Grid Pattern -->
                        <div class="absolute inset-0 bg-grid-white/[0.02] bg-grid-pattern"></div>
                    </div>
                    
                    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        
                        <!-- Badge -->
                        <?php if (safe_get($section, 'badge')) : ?>
                            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-xl border border-white/20 px-8 py-4 rounded-full text-white font-semibold mb-8 shadow-2xl animate-fade-in-down">
                                <div class="w-3 h-3 bg-primary rounded-full animate-ping"></div>
                                <?php echo esc_html($section['badge']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Title -->
                        <?php if (safe_get($section, 'title')) : ?>
                            <h2 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-8 leading-tight animate-fade-in-up">
                                <span class="bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent">
                                    <?php echo esc_html($section['title']); ?>
                                </span>
                            </h2>
                        <?php endif; ?>
                        
                        <!-- Description -->
                        <?php if (safe_get($section, 'description')) : ?>
                            <p class="text-xl md:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-12 animate-fade-in-up" style="animation-delay: 0.2s;">
                                <?php echo esc_html($section['description']); ?>
                            </p>
                        <?php endif; ?>
                        
                        <!-- Buttons -->
                        <?php if (safe_get($section, 'buttons') && !empty($section['buttons'])) : ?>
                            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-16 animate-fade-in-up" style="animation-delay: 0.4s;">
                                <?php foreach ($section['buttons'] as $index => $button) : ?>
                                    <?php
                                    $btn_style = safe_get($button, 'style', 'primary');
                                    $btn_classes = ($btn_style === 'primary') 
                                        ? 'bg-white text-gray-900 hover:bg-gray-100 shadow-2xl hover:shadow-white/20' 
                                        : 'bg-white/10 text-white border-2 border-white/30 hover:bg-white/20 hover:border-white/50 backdrop-blur-xl';
                                    ?>
                                    <a href="<?php echo esc_url(safe_get(safe_get($button, 'link'), 'url', '#')); ?>" 
                                       class="<?php echo $btn_classes; ?> px-10 py-5 rounded-2xl font-bold text-lg transition-all duration-500 transform hover:scale-105 hover:-translate-y-2 group min-w-[250px] animate-scale-in"
                                       style="animation-delay: <?php echo 0.6 + ($index * 0.1); ?>s;"
                                       <?php if (safe_get(safe_get($button, 'link'), 'target')) echo 'target="' . esc_attr($button['link']['target']) . '"'; ?>>
                                        <span class="flex items-center justify-center gap-3">
                                            <?php if (safe_get($button, 'icon')) : ?>
                                                <span class="text-2xl"><?php echo esc_html($button['icon']); ?></span>
                                            <?php endif; ?>
                                            <span><?php echo esc_html(safe_get($button, 'text', 'Button')); ?></span>
                                            <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Modern Features -->
                        <?php if (safe_get($section, 'features') && !empty($section['features'])) : ?>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-fade-in-up" style="animation-delay: 0.8s;">
                                <?php foreach ($section['features'] as $index => $feature) : ?>
                                    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-500 hover:bg-white/20 animate-scale-in" style="animation-delay: <?php echo 1 + ($index * 0.1); ?>s;">
                                        <div class="text-4xl mb-4">
                                            <?php echo esc_html(safe_get($feature, 'icon', '✓')); ?>
                                        </div>
                                        <h3 class="text-white font-bold text-lg mb-2">
                                            <?php echo esc_html(safe_get($feature, 'title', safe_get($feature, 'text'))); ?>
                                        </h3>
                                        <?php if (safe_get($feature, 'description')) : ?>
                                            <p class="text-white/80 text-sm">
                                                <?php echo esc_html($feature['description']); ?>
                                            </p>
                                        <?php endif; ?>
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
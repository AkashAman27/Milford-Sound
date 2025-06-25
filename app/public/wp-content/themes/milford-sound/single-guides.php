<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    // Get ACF fields
    $guide_overview = get_field('guide_overview');
    $guide_quick_facts = get_field('guide_quick_facts');
    $guide_sections = get_field('guide_sections');
    $guide_checklist = get_field('guide_checklist');
    $guide_costs = get_field('guide_costs');
    $guide_timing = get_field('guide_timing');
    $guide_resources = get_field('guide_resources');
    $guide_author = get_field('guide_author');
    
    // Guide categories
    $guide_categories = get_the_terms(get_the_ID(), 'guide_category');
    
    // Guide type colors
    $type_colors = array(
        'planning' => '#3b82f6',
        'activities' => '#22c55e',
        'accommodation' => '#f59e0b',
        'transportation' => '#8b5cf6',
        'dining' => '#ef4444',
        'photography' => '#ec4899',
        'weather' => '#06b6d4',
        'budget' => '#10b981',
        'family' => '#f97316',
        'adventure' => '#84cc16'
    );
    
    $guide_color = $type_colors[$guide_overview['guide_type']] ?? '#2dd4bf';
    ?>

    <main class="main-content single-guide">
        
        <!-- Guide Header -->
        <header class="guide-header" style="position: relative; padding: 8rem 0 4rem; background: linear-gradient(135deg, <?php echo esc_attr($guide_color); ?> 0%, #3b82f6 100%); color: white; overflow: hidden;">
            
            <?php if (has_post_thumbnail()) : ?>
                <div class="guide-bg-image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.3; z-index: -1;">
                    <?php the_post_thumbnail('full', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                </div>
            <?php endif; ?>
            
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; position: relative; z-index: 2;">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem; align-items: center;">
                    
                    <!-- Guide Info -->
                    <div class="guide-info">
                        
                        <!-- Guide Categories -->
                        <?php if ($guide_categories) : ?>
                            <div class="guide-categories" style="margin-bottom: 1rem;">
                                <?php foreach ($guide_categories as $category) : ?>
                                    <span style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">
                                        <?php echo esc_html($category->name); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <h1 class="guide-title" style="font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; margin-bottom: 1.5rem; line-height: 1.2;">
                            <?php the_title(); ?>
                        </h1>
                        
                        <?php if ($guide_overview) : ?>
                            <div class="guide-meta" style="display: flex; gap: 2rem; flex-wrap: wrap; opacity: 0.9; margin-bottom: 2rem;">
                                <?php if ($guide_overview['guide_type']) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>📋</span>
                                        <span><?php echo esc_html(ucfirst(str_replace('_', ' ', $guide_overview['guide_type']))); ?></span>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($guide_overview['guide_difficulty']) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>📊</span>
                                        <span><?php echo esc_html(ucfirst(str_replace('_', ' ', $guide_overview['guide_difficulty']))); ?></span>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($guide_overview['estimated_reading_time']) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>⏱️</span>
                                        <span><?php echo esc_html($guide_overview['estimated_reading_time']); ?> min read</span>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($guide_overview['last_updated']) : ?>
                                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span>🔄</span>
                                        <span>Updated <?php echo date('M Y', strtotime($guide_overview['last_updated'])); ?></span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="guide-excerpt" style="font-size: 1.25rem; opacity: 0.9; line-height: 1.6;">
                            <?php the_excerpt(); ?>
                        </div>
                        
                    </div>
                    
                    <!-- Quick Facts Card -->
                    <?php if ($guide_quick_facts && !empty($guide_quick_facts)) : ?>
                        <div class="quick-facts-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2);">
                            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center;">Quick Facts</h3>
                            
                            <div class="facts-grid" style="display: grid; gap: 1rem;">
                                <?php foreach ($guide_quick_facts as $fact) : ?>
                                    <div class="fact-item" style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">
                                        <span style="display: flex; align-items: center; gap: 0.5rem; opacity: 0.9;">
                                            <span><?php echo esc_html($fact['fact_icon']); ?></span>
                                            <span><?php echo esc_html($fact['fact_label']); ?></span>
                                        </span>
                                        <span style="font-weight: 600;"><?php echo esc_html($fact['fact_value']); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </header>

        <!-- Guide Content -->
        <div class="guide-content" style="padding: 4rem 0; background: #f8fafc;">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 4rem; align-items: start;">
                    
                    <!-- Main Content -->
                    <div class="guide-main">
                        
                        <!-- Guide Introduction -->
                        <section class="guide-introduction" style="margin-bottom: 4rem;">
                            <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); line-height: 1.8; font-size: 1.1rem;">
                                <?php the_content(); ?>
                            </div>
                        </section>

                        <!-- Guide Sections -->
                        <?php if ($guide_sections && !empty($guide_sections)) : ?>
                            <?php foreach ($guide_sections as $index => $section) : ?>
                                <section class="guide-section" style="margin-bottom: 4rem;">
                                    <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                        
                                        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b; display: flex; align-items: center; gap: 1rem;">
                                            <?php if ($section['section_icon']) : ?>
                                                <span style="font-size: 2.5rem;"><?php echo esc_html($section['section_icon']); ?></span>
                                            <?php endif; ?>
                                            <?php echo esc_html($section['section_title']); ?>
                                        </h2>
                                        
                                        <div class="section-content" style="margin-bottom: 2rem;">
                                            <?php echo wp_kses_post($section['section_content']); ?>
                                        </div>
                                        
                                        <?php if ($section['section_tips'] && !empty($section['section_tips'])) : ?>
                                            <div class="section-tips" style="display: grid; gap: 1rem; margin-top: 2rem;">
                                                <?php foreach ($section['section_tips'] as $tip) : ?>
                                                    <div class="tip-item" style="background: #f8fafc; padding: 1.5rem; border-radius: 15px; border-left: 4px solid <?php echo esc_attr($guide_color); ?>;">
                                                        <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                                            <span style="font-size: 1.5rem; flex-shrink: 0;">
                                                                <?php
                                                                $tip_icons = array(
                                                                    'tip' => '💡',
                                                                    'warning' => '⚠️',
                                                                    'money' => '💰',
                                                                    'time' => '⏰',
                                                                    'pro' => '🔥'
                                                                );
                                                                echo esc_html($tip_icons[$tip['tip_type']] ?? '💡');
                                                                ?>
                                                            </span>
                                                            <p style="color: #1e293b; line-height: 1.6; margin: 0;">
                                                                <?php echo esc_html($tip['tip_content']); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                    </div>
                                </section>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Travel Checklist -->
                        <?php if ($guide_checklist) : ?>
                            <section class="guide-checklist-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">Travel Checklist</h2>
                                
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
                                    
                                    <?php if ($guide_checklist['before_you_go'] && !empty($guide_checklist['before_you_go'])) : ?>
                                        <div class="checklist-section" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                                                <span>✅</span> Before You Go
                                            </h3>
                                            <ul style="list-style: none; padding: 0;">
                                                <?php foreach ($guide_checklist['before_you_go'] as $item) : ?>
                                                    <li style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; padding: 0.5rem; border-radius: 8px; background: #f8fafc;">
                                                        <span style="color: <?php echo esc_attr($guide_color); ?>; font-weight: 600;">
                                                            <?php echo $item['item_priority'] === 'essential' ? '🔴' : ($item['item_priority'] === 'recommended' ? '🟡' : '🟢'); ?>
                                                        </span>
                                                        <span style="color: #1e293b;"><?php echo esc_html($item['checklist_item']); ?></span>
                                                        <span style="font-size: 0.8rem; color: #64748b; margin-left: auto;"><?php echo esc_html(ucfirst($item['item_priority'])); ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($guide_checklist['packing_list'] && !empty($guide_checklist['packing_list'])) : ?>
                                        <div class="packing-section" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                                                <span>🎒</span> Packing List
                                            </h3>
                                            
                                            <?php
                                            // Group items by category
                                            $packed_items = array();
                                            foreach ($guide_checklist['packing_list'] as $item) {
                                                $category = $item['packing_category'] ?: 'other';
                                                $packed_items[$category][] = $item;
                                            }
                                            
                                            foreach ($packed_items as $category => $items) :
                                            ?>
                                                <div style="margin-bottom: 1.5rem;">
                                                    <h4 style="font-size: 1rem; font-weight: 600; color: <?php echo esc_attr($guide_color); ?>; margin-bottom: 0.75rem; text-transform: capitalize;">
                                                        <?php echo esc_html(str_replace('_', ' ', $category)); ?>
                                                    </h4>
                                                    <ul style="list-style: none; padding: 0; margin-left: 1rem;">
                                                        <?php foreach ($items as $item) : ?>
                                                            <li style="color: #64748b; margin-bottom: 0.5rem; font-size: 0.9rem;">
                                                                • <?php echo esc_html($item['packing_item']); ?>
                                                                <?php if ($item['packing_season']) : ?>
                                                                    <span style="font-size: 0.8rem; color: #94a3b8; margin-left: 0.5rem;">
                                                                        (<?php echo implode(', ', $item['packing_season']); ?>)
                                                                    </span>
                                                                <?php endif; ?>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Cost Information -->
                        <?php if ($guide_costs) : ?>
                            <section class="guide-costs-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">Budget & Costs</h2>
                                
                                <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                    
                                    <?php if ($guide_costs['sample_budgets'] && !empty($guide_costs['sample_budgets'])) : ?>
                                        <div class="budget-overview" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                                            <?php foreach ($guide_costs['sample_budgets'] as $budget) : ?>
                                                <div class="budget-card" style="background: #f8fafc; padding: 2rem; border-radius: 15px; text-align: center; border: 2px solid transparent;">
                                                    <h3 style="font-size: 1.25rem; font-weight: 700; color: <?php echo esc_attr($guide_color); ?>; margin-bottom: 1rem; text-transform: capitalize;">
                                                        <?php echo esc_html(str_replace('_', ' ', $budget['budget_type'])); ?>
                                                    </h3>
                                                    <div style="font-size: 2rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;">
                                                        <?php echo esc_html($budget['daily_budget']); ?>
                                                    </div>
                                                    <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5;">
                                                        <?php echo esc_html($budget['budget_breakdown']); ?>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($guide_costs['budget_categories'] && !empty($guide_costs['budget_categories'])) : ?>
                                        <div class="budget-breakdown">
                                            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: #1e293b;">Detailed Cost Breakdown</h3>
                                            <div style="display: grid; gap: 1.5rem;">
                                                <?php foreach ($guide_costs['budget_categories'] as $category) : ?>
                                                    <div class="budget-category" style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 1.5rem;">
                                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                                            <h4 style="font-size: 1.1rem; font-weight: 600; color: #1e293b; margin: 0;">
                                                                <?php echo esc_html($category['category_name']); ?>
                                                            </h4>
                                                            <span style="font-weight: 700; color: <?php echo esc_attr($guide_color); ?>;">
                                                                <?php echo esc_html($category['budget_range']); ?>
                                                            </span>
                                                        </div>
                                                        <?php if ($category['budget_tips']) : ?>
                                                            <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5; margin: 0;">
                                                                💡 <?php echo esc_html($category['budget_tips']); ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Timing & Seasons -->
                        <?php if ($guide_timing) : ?>
                            <section class="guide-timing-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">When to Visit</h2>
                                
                                <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                    
                                    <?php if ($guide_timing['best_time_overall']) : ?>
                                        <div class="best-time-banner" style="background: <?php echo esc_attr($guide_color); ?>; color: white; padding: 2rem; border-radius: 15px; text-align: center; margin-bottom: 3rem;">
                                            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">Best Time to Visit</h3>
                                            <p style="font-size: 1.25rem; opacity: 0.9; margin: 0;"><?php echo esc_html($guide_timing['best_time_overall']); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($guide_timing['seasonal_breakdown'] && !empty($guide_timing['seasonal_breakdown'])) : ?>
                                        <div class="seasonal-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                                            <?php foreach ($guide_timing['seasonal_breakdown'] as $season) : ?>
                                                <div class="season-card" style="border: 1px solid #e2e8f0; border-radius: 15px; padding: 2rem;">
                                                    <h4 style="font-size: 1.25rem; font-weight: 700; color: <?php echo esc_attr($guide_color); ?>; margin-bottom: 1rem;">
                                                        <?php echo esc_html(str_replace('_', ' ', $season['season_name'])); ?>
                                                    </h4>
                                                    
                                                    <?php if ($season['season_weather']) : ?>
                                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; color: #64748b;">
                                                            <span>🌡️</span>
                                                            <span><?php echo esc_html($season['season_weather']); ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($season['season_pros']) : ?>
                                                        <div style="margin-bottom: 1rem;">
                                                            <h5 style="font-size: 0.9rem; font-weight: 600; color: #22c55e; margin-bottom: 0.5rem;">✓ Pros</h5>
                                                            <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5; margin: 0;"><?php echo esc_html($season['season_pros']); ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($season['season_cons']) : ?>
                                                        <div style="margin-bottom: 1rem;">
                                                            <h5 style="font-size: 0.9rem; font-weight: 600; color: #ef4444; margin-bottom: 0.5rem;">✗ Cons</h5>
                                                            <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5; margin: 0;"><?php echo esc_html($season['season_cons']); ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($season['season_activities']) : ?>
                                                        <div>
                                                            <h5 style="font-size: 0.9rem; font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;">🎯 Best For</h5>
                                                            <p style="color: #64748b; font-size: 0.9rem; line-height: 1.5; margin: 0;"><?php echo esc_html($season['season_activities']); ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                            </section>
                        <?php endif; ?>

                        <!-- Additional Resources -->
                        <?php if ($guide_resources) : ?>
                            <section class="guide-resources-section" style="margin-bottom: 4rem;">
                                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem; color: #1e293b;">Additional Resources</h2>
                                
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                                    
                                    <?php if ($guide_resources['useful_links'] && !empty($guide_resources['useful_links'])) : ?>
                                        <div class="useful-links" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                                                <span>🔗</span> Useful Links
                                            </h3>
                                            <?php foreach ($guide_resources['useful_links'] as $link) : ?>
                                                <div class="resource-link" style="padding: 1rem 0; border-bottom: 1px solid #f1f5f9;">
                                                    <a href="<?php echo esc_url($link['link_url']); ?>" target="_blank" style="text-decoration: none; color: <?php echo esc_attr($guide_color); ?>; font-weight: 600;">
                                                        <?php echo esc_html($link['link_title']); ?> ↗
                                                    </a>
                                                    <?php if ($link['link_description']) : ?>
                                                        <p style="color: #64748b; font-size: 0.9rem; margin: 0.5rem 0 0 0;"><?php echo esc_html($link['link_description']); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($guide_resources['recommended_apps'] && !empty($guide_resources['recommended_apps'])) : ?>
                                        <div class="recommended-apps" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                                                <span>📱</span> Recommended Apps
                                            </h3>
                                            <?php foreach ($guide_resources['recommended_apps'] as $app) : ?>
                                                <div class="app-item" style="padding: 1rem 0; border-bottom: 1px solid #f1f5f9;">
                                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                                                        <span style="font-weight: 600; color: #1e293b;"><?php echo esc_html($app['app_name']); ?></span>
                                                        <span style="font-size: 0.8rem; padding: 0.25rem 0.5rem; border-radius: 10px; background: <?php echo $app['app_cost'] === 'free' ? '#dcfce7' : ($app['app_cost'] === 'paid' ? '#fee2e2' : '#fef3c7'); ?>; color: <?php echo $app['app_cost'] === 'free' ? '#166534' : ($app['app_cost'] === 'paid' ? '#dc2626' : '#d97706'); ?>;">
                                                            <?php echo esc_html(ucfirst($app['app_cost'])); ?>
                                                        </span>
                                                    </div>
                                                    <p style="color: #64748b; font-size: 0.9rem; margin: 0;"><?php echo esc_html($app['app_purpose']); ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                </div>
                                
                                <?php if ($guide_resources['downloadable_resources'] && !empty($guide_resources['downloadable_resources'])) : ?>
                                    <div class="downloadable-resources" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-top: 2rem;">
                                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b; display: flex; align-items: center; gap: 0.5rem;">
                                            <span>📥</span> Download Resources
                                        </h3>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                                            <?php foreach ($guide_resources['downloadable_resources'] as $resource) : ?>
                                                <div class="download-item" style="border: 1px dashed #cbd5e1; padding: 1.5rem; border-radius: 10px; text-align: center;">
                                                    <div style="font-size: 2rem; margin-bottom: 1rem;">📄</div>
                                                    <h4 style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;"><?php echo esc_html($resource['resource_title']); ?></h4>
                                                    <?php if ($resource['resource_description']) : ?>
                                                        <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;"><?php echo esc_html($resource['resource_description']); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($resource['resource_file']) : ?>
                                                        <a href="<?php echo esc_url($resource['resource_file']['url']); ?>" download style="background: <?php echo esc_attr($guide_color); ?>; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.9rem; font-weight: 600;">
                                                            Download PDF
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </section>
                        <?php endif; ?>
                        
                    </div>

                    <!-- Sidebar -->
                    <aside class="guide-sidebar">
                        
                        <!-- Guide Author Info -->
                        <?php if ($guide_author) : ?>
                            <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">About the Author</h3>
                                
                                <div class="author-info" style="text-align: center; margin-bottom: 1.5rem;">
                                    <div style="width: 80px; height: 80px; border-radius: 50%; background: <?php echo esc_attr($guide_color); ?>; color: white; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700; margin: 0 auto 1rem;">
                                        <?php echo substr(get_the_author(), 0, 1); ?>
                                    </div>
                                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 0.5rem;"><?php the_author(); ?></div>
                                    <?php if ($guide_author['author_visits']) : ?>
                                        <div style="color: #64748b; font-size: 0.9rem;">Visited <?php echo esc_html($guide_author['author_visits']); ?></div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($guide_author['author_expertise']) : ?>
                                    <p style="color: #64748b; line-height: 1.6; font-size: 0.9rem; margin-bottom: 1rem;"><?php echo esc_html($guide_author['author_expertise']); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($guide_author['author_specialties']) : ?>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                        <?php foreach ($guide_author['author_specialties'] as $specialty) : ?>
                                            <span style="background: #f1f5f9; color: #64748b; padding: 0.25rem 0.75rem; border-radius: 15px; font-size: 0.8rem;">
                                                <?php echo esc_html(str_replace('_', ' ', $specialty)); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Guide Categories -->
                        <?php if ($guide_categories) : ?>
                            <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 2rem;">
                                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Guide Topics</h3>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                    <?php foreach ($guide_categories as $category) : ?>
                                        <a href="<?php echo get_category_link($category->term_id); ?>" style="background: <?php echo esc_attr($guide_color); ?>; color: white; padding: 0.5rem 1rem; border-radius: 25px; font-size: 0.8rem; font-weight: 600; text-decoration: none;">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Contact Information -->
                        <div class="sidebar-widget" style="background: linear-gradient(135deg, <?php echo esc_attr($guide_color); ?>, #3b82f6); color: white; padding: 2rem; border-radius: 15px; margin-bottom: 2rem; text-align: center;">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Need More Help?</h3>
                            <p style="opacity: 0.9; margin-bottom: 1.5rem; font-size: 0.9rem;">Questions about this guide? Our travel experts are here to help!</p>
                            <div style="margin-bottom: 1rem;">
                                <div style="font-weight: 600; margin-bottom: 0.5rem;">📞 +64 3 123 4567</div>
                                <div style="font-size: 0.9rem; opacity: 0.8;">Available 8am - 6pm NZST</div>
                            </div>
                            <a href="mailto:guides@milfordsound.co" style="background: rgba(255,255,255,0.2); color: white; padding: 0.75rem 1.5rem; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                                ✉️ Email Us
                            </a>
                        </div>

                        <!-- Related Guides -->
                        <div class="sidebar-widget" style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">Related Guides</h3>
                            
                            <?php
                            // Get related guides
                            $related_guides = new WP_Query(array(
                                'post_type' => 'guides',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID())
                            ));
                            
                            if ($related_guides->have_posts()) :
                                while ($related_guides->have_posts()) : $related_guides->the_post();
                                    $related_guide_overview = get_field('guide_overview');
                            ?>
                                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #f1f5f9;">
                                    <div style="flex-shrink: 0;">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('thumbnail', array('style' => 'width: 60px; height: 60px; object-fit: cover; border-radius: 8px;')); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div style="flex: 1;">
                                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: #1e293b; font-weight: 600; font-size: 0.9rem; line-height: 1.4;">
                                            <?php echo wp_trim_words(get_the_title(), 6); ?>
                                        </a>
                                        <?php if ($related_guide_overview && $related_guide_overview['estimated_reading_time']) : ?>
                                            <div style="color: <?php echo esc_attr($guide_color); ?>; font-size: 0.8rem; margin-top: 0.25rem;">
                                                <?php echo esc_html($related_guide_overview['estimated_reading_time']); ?> min read
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            endif; 
                            ?>
                        </div>
                        
                    </aside>
                    
                </div>
            </div>
        </div>
        
    </main>

<?php endwhile; ?>

<style>
/* Guide Page Specific Styles */
.quick-facts-card:hover {
    transform: translateY(-3px);
    background: rgba(255,255,255,0.15) !important;
}

.tip-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.season-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.budget-card:hover {
    border-color: <?php echo esc_attr($guide_color); ?> !important;
    background: #ffffff !important;
    transform: translateY(-3px);
}

.resource-link:hover {
    background: #f8fafc;
    padding-left: 1rem;
    padding-right: 1rem;
    margin-left: -1rem;
    margin-right: -1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .guide-header > div > div {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .guide-content > div > div {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }
    
    .budget-overview {
        grid-template-columns: 1fr !important;
    }
    
    .seasonal-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php get_footer(); ?>
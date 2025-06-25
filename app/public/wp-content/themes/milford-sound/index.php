<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <div class="hero-badge">UNESCO World Heritage Site</div>
        <h1 class="hero-title">
            Experience the<br>
            <span class="highlight">Eighth Wonder</span><br>
            of the World
        </h1>
        <p class="hero-description">
            Discover Milford Sound's breathtaking fjords, cascading waterfalls, and pristine wilderness. Where towering peaks meet crystal-clear waters in New Zealand's most spectacular natural wonder.
        </p>
        <div class="hero-buttons">
            <a href="#tours" class="btn btn-primary">📅 Book Your Adventure</a>
            <a href="#video" class="btn btn-secondary">▶️ Watch Video Tour</a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="stats-container">
        <div class="weather-info">
            <h3>🌊 Today's Conditions</h3>
            <p>Perfect for cruising</p>
            <div class="weather-details">
                <div class="weather-item">
                    <span>🌡️</span>
                    <span>18°C</span>
                </div>
                <div class="weather-item">
                    <span>💨</span>
                    <span>Light winds</span>
                </div>
                <div class="weather-item">
                    <span>🌊</span>
                    <span>Calm seas</span>
                </div>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number">1692m</span>
                <span class="stat-label">Mitre Peak Height</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">15km</span>
                <span class="stat-label">Fjord Length</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">161m</span>
                <span class="stat-label">Stirling Falls</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">5M+</span>
                <span class="stat-label">Annual Visitors</span>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="features-container">
        <div class="section-badge">World Heritage Wonder</div>
        <h2 class="section-title">Why Milford Sound is <span style="color: #2dd4bf;">Unmissable</span></h2>
        <p class="section-description">
            Carved by glaciers over millions of years, Milford Sound offers an otherworldly experience where dramatic landscapes meet pristine wilderness in perfect harmony.
        </p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon mountains">🏔️</div>
                <h3 class="feature-title">Towering Peaks</h3>
                <p class="feature-description">
                    Marvel at Mitre Peak rising 1,692 meters straight from the water, creating one of the most photographed landscapes on Earth.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon water">🌊</div>
                <h3 class="feature-title">Pristine Waters</h3>
                <p class="feature-description">
                    Cruise through mirror-like fjord waters that reflect towering cliffs, creating a sense of infinite depth and tranquility.
                </p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon falls">💧</div>
                <h3 class="feature-title">Spectacular Falls</h3>
                <p class="feature-description">
                    Witness the thunderous Stirling Falls and Lady Bowen Falls cascading 161 meters into the fjord with incredible force.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Tours Section -->
<section class="tours-section" id="tours">
    <div class="tours-container">
        <div class="section-badge">Most Popular</div>
        <h2 class="section-title">Choose Your Adventure</h2>
        
        <div class="tours-grid">
            <div class="tour-card">
                <div class="tour-badge popular">Most Popular</div>
                <div class="tour-image">🚢</div>
                <div class="tour-content">
                    <div class="tour-header">
                        <h3 class="tour-title">Scenic Nature Cruise</h3>
                        <span class="tour-duration">2 hours</span>
                    </div>
                    <div class="tour-price">From $89 per person</div>
                    <p class="tour-description">
                        Experience Milford Sound's majesty aboard our comfortable vessels with expert commentary, wildlife spotting, and waterfall encounters.
                    </p>
                    <div class="tour-details">
                        <div class="tour-detail">⏰ 2 hours</div>
                        <div class="tour-detail">👥 All ages</div>
                        <div class="tour-rating">
                            <span class="stars">⭐</span>
                            <span>4.8 (2,341)</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary">Book Now →</a>
                </div>
            </div>
            
            <div class="tour-card">
                <div class="tour-badge premium">Premium</div>
                <div class="tour-image">🚁</div>
                <div class="tour-content">
                    <div class="tour-header">
                        <h3 class="tour-title">Helicopter Adventure</h3>
                        <span class="tour-duration">45 min</span>
                    </div>
                    <div class="tour-price">From $299 per person</div>
                    <p class="tour-description">
                        Soar above Milford Sound for breathtaking aerial perspectives of the fjord, waterfalls, and surrounding peaks from a bird's eye view.
                    </p>
                    <div class="tour-details">
                        <div class="tour-detail">⏰ 45 min</div>
                        <div class="tour-detail">👥 6 max</div>
                        <div class="tour-rating">
                            <span class="stars">⭐</span>
                            <span>4.9 (856)</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary">Book Now →</a>
                </div>
            </div>
            
            <div class="tour-card">
                <div class="tour-badge adventure">Adventure</div>
                <div class="tour-image">🛶</div>
                <div class="tour-content">
                    <div class="tour-header">
                        <h3 class="tour-title">Kayak Exploration</h3>
                        <span class="tour-duration">3 hours</span>
                    </div>
                    <div class="tour-price">From $149 per person</div>
                    <p class="tour-description">
                        Paddle through serene waters for an intimate encounter with Milford Sound's wildlife, waterfalls, and pristine wilderness.
                    </p>
                    <div class="tour-details">
                        <div class="tour-detail">⏰ 3 hours</div>
                        <div class="tour-detail">👥 12+ years</div>
                        <div class="tour-rating">
                            <span class="stars">⭐</span>
                            <span>4.7 (1,203)</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary">Book Now →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Guides Section -->
<section class="guides-section">
    <div class="guides-container">
        <div class="guides-content">
            <div class="guides-text">
                <h2>Everything You Need to Know</h2>
                <p>Make the most of your Milford Sound adventure with our comprehensive planning guide, insider tips, and essential information for an unforgettable experience.</p>
                
                <ul class="guides-list">
                    <li class="guide-item">
                        <div class="guide-icon">📍</div>
                        <div class="guide-content">
                            <h3>Getting There</h3>
                            <p>Multiple transport options from Queenstown and Te Anau, including scenic drives and coach tours.</p>
                        </div>
                    </li>
                    
                    <li class="guide-item">
                        <div class="guide-icon">⏰</div>
                        <div class="guide-content">
                            <h3>Best Time to Visit</h3>
                            <p>Year-round destination with each season offering unique experiences and weather conditions.</p>
                        </div>
                    </li>
                    
                    <li class="guide-item">
                        <div class="guide-icon">🎒</div>
                        <div class="guide-content">
                            <h3>What to Bring</h3>
                            <p>Weather-appropriate clothing, camera, and comfortable walking shoes for the ultimate experience.</p>
                        </div>
                    </li>
                </ul>
                
                <div class="guides-cta">
                    <h3>📞 Need Help Planning?</h3>
                    <p>Call our experts: +64 3 123 4567</p>
                    <a href="#" class="btn btn-secondary">Download Complete Guide →</a>
                </div>
            </div>
            
            <div class="guides-image">
                <div style="height: 400px; background: linear-gradient(135deg, #e2e8f0, #cbd5e1); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: #64748b;">
                    🗺️
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="cta-container">
        <div class="cta-badge">Limited Time Offer</div>
        <h2 class="cta-title">Ready for the Adventure of a Lifetime?</h2>
        <p class="cta-description">
            Join thousands of travelers who have discovered the magic of Milford Sound. Book now and save up to 20% on selected tours this season.
        </p>
        <div class="cta-buttons">
            <a href="#" class="btn btn-primary">📅 Book Your Tour Today</a>
            <a href="#" class="btn btn-secondary">💬 Talk to an Expert</a>
        </div>
        <div class="cta-features">
            <div class="cta-feature">
                <span>✓</span>
                <span>Free cancellation up to 24 hours before</span>
            </div>
            <div class="cta-feature">
                <span>✓</span>
                <span>Best price guarantee</span>
            </div>
            <div class="cta-feature">
                <span>✓</span>
                <span>Instant confirmation</span>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

</body>
</html>
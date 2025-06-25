<?php
/**
 * This file demonstrates how to add sample ACF data to a tour post
 * Run this once to populate a tour with sample data
 */

// Debug ACF data function
if (isset($_GET['debug_acf_data']) && current_user_can('manage_options') && !wp_doing_ajax()) {
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : get_the_ID();
    
    if ($post_id && get_post_type($post_id) === 'tours') {
        echo '<div style="background: #f0f0f1; padding: 20px; margin: 20px; border-radius: 5px; font-family: monospace;">';
        echo '<h3>ACF Debug for Tour ID: ' . $post_id . '</h3>';
        
        $all_fields = get_fields($post_id);
        echo '<pre>' . print_r($all_fields, true) . '</pre>';
        
        echo '<h4>Individual Field Tests:</h4>';
        echo '<p><strong>tour_overview:</strong> ' . print_r(get_field('tour_overview', $post_id), true) . '</p>';
        echo '<p><strong>tour_gallery:</strong> ' . (get_field('tour_gallery', $post_id) ? 'EXISTS' : 'EMPTY') . '</p>';
        echo '<p><strong>tour_highlights:</strong> ' . (get_field('tour_highlights', $post_id) ? 'EXISTS' : 'EMPTY') . '</p>';
        echo '</div>';
        return;
    }
}

// Only run if specifically requested, user has admin permissions, and not during AJAX
if (isset($_GET['populate_tour_data']) && current_user_can('manage_options') && !wp_doing_ajax()) {
    
    // Get the current post ID (or specify one)
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : get_the_ID();
    
    if ($post_id && get_post_type($post_id) === 'tours') {
        
        // Sample tour overview data
        $tour_overview = array(
            'tour_price' => 'From $149 per person',
            'tour_duration' => '2.5 hours',
            'tour_group_size' => 'Max 12 people',
            'tour_difficulty' => 'easy',
            'tour_availability' => 'year_round'
        );
        update_field('tour_overview', $tour_overview, $post_id);
        
        // Sample tour highlights
        $tour_highlights = array(
            array(
                'highlight_icon' => '🏔️',
                'highlight_title' => 'Mitre Peak Views',
                'highlight_description' => 'Get up close to the iconic Mitre Peak, one of the most photographed mountains in New Zealand.'
            ),
            array(
                'highlight_icon' => '🌊',
                'highlight_title' => 'Pristine Waters',
                'highlight_description' => 'Cruise through crystal-clear fjord waters surrounded by towering cliffs.'
            ),
            array(
                'highlight_icon' => '💧',
                'highlight_title' => 'Stunning Waterfalls',
                'highlight_description' => 'Marvel at the magnificent Stirling Falls and Lady Bowen Falls.'
            )
        );
        update_field('tour_highlights', $tour_highlights, $post_id);
        
        // Sample tour itinerary
        $tour_itinerary = array(
            array(
                'itinerary_time' => '9:00 AM',
                'itinerary_activity' => 'Departure from Milford Sound Terminal',
                'itinerary_description' => 'Board our comfortable cruise vessel and begin your fjord adventure.',
                'itinerary_location' => 'Milford Sound Terminal'
            ),
            array(
                'itinerary_time' => '9:30 AM',
                'itinerary_activity' => 'Mitre Peak Viewing',
                'itinerary_description' => 'Cruise to the best vantage point for iconic Mitre Peak photos.',
                'itinerary_location' => 'Mitre Peak'
            ),
            array(
                'itinerary_time' => '10:30 AM',
                'itinerary_activity' => 'Stirling Falls Experience',
                'itinerary_description' => 'Get close to the thunderous 161-meter waterfall.',
                'itinerary_location' => 'Stirling Falls'
            ),
            array(
                'itinerary_time' => '11:30 AM',
                'itinerary_activity' => 'Return to Terminal',
                'itinerary_description' => 'Scenic return journey with wildlife spotting opportunities.',
                'itinerary_location' => 'Milford Sound Terminal'
            )
        );
        update_field('tour_itinerary', $tour_itinerary, $post_id);
        
        // Sample inclusions
        $tour_inclusions = array(
            array(
                'inclusion_icon' => '🚢',
                'inclusion_item' => 'Scenic cruise on modern vessel'
            ),
            array(
                'inclusion_icon' => '📷',
                'inclusion_item' => 'Professional commentary'
            ),
            array(
                'inclusion_icon' => '🧥',
                'inclusion_item' => 'Complimentary raincoats'
            ),
            array(
                'inclusion_icon' => '☕',
                'inclusion_item' => 'Hot drinks available onboard'
            )
        );
        update_field('tour_inclusions', $tour_inclusions, $post_id);
        
        // Sample booking info
        $tour_booking = array(
            'booking_advance_notice' => '24 hours',
            'cancellation_policy' => 'Free cancellation up to 24 hours before departure. No-show or cancellations within 24 hours are non-refundable.',
            'payment_options' => array('credit_card', 'paypal', 'eftpos'),
            'booking_link' => array(
                'url' => '#book-now',
                'title' => 'Book This Tour',
                'target' => ''
            )
        );
        update_field('tour_booking', $tour_booking, $post_id);
        
        // Sample reviews
        $tour_reviews = array(
            'average_rating' => 4.8,
            'total_reviews' => 127,
            'featured_reviews' => array(
                array(
                    'review_rating' => 5,
                    'review_text' => 'Absolutely breathtaking experience! The scenery was beyond words and our guide was fantastic.',
                    'reviewer_name' => 'Sarah Johnson',
                    'reviewer_location' => 'Auckland, New Zealand',
                    'review_date' => '2024-06-15'
                ),
                array(
                    'review_rating' => 5,
                    'review_text' => 'A must-do when visiting Fiordland. The waterfalls and mountain views are spectacular.',
                    'reviewer_name' => 'Mike Chen',
                    'reviewer_location' => 'Sydney, Australia', 
                    'review_date' => '2024-06-10'
                )
            )
        );
        update_field('tour_reviews', $tour_reviews, $post_id);
        
        echo '<div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin: 20px; border-radius: 4px;">';
        echo '<strong>Success!</strong> Sample ACF data has been added to tour post ID: ' . $post_id;
        echo '<br><a href="' . get_permalink($post_id) . '">View the tour</a>';
        echo '</div>';
        
    } else {
        echo '<div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; margin: 20px; border-radius: 4px;">';
        echo '<strong>Error!</strong> Invalid post ID or not a tour post.';
        echo '</div>';
    }
}
?>

<!-- Instructions -->
<div style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 20px; border-radius: 4px;">
    <h3>How to test ACF fields:</h3>
    
    <h4>Debug existing data:</h4>
    <p>1. Go to any tour post in the admin</p>
    <p>2. Add <code>?debug_acf_data=1</code> to the URL</p>
    <p><strong>Example:</strong> <code>yoursite.com/wp-admin/post.php?post=23&action=edit&debug_acf_data=1</code></p>
    
    <h4>Populate with sample data:</h4>
    <p>1. Go to any tour post in the admin</p>
    <p>2. Add <code>?populate_tour_data=1</code> to the URL</p>
    <p>3. Or use: <code>?populate_tour_data=1&post_id=YOUR_POST_ID</code></p>
    <p><strong>Example:</strong> <code>yoursite.com/wp-admin/post.php?post=23&action=edit&populate_tour_data=1</code></p>
    
    <div style="background: #e3f2fd; border: 1px solid #90caf9; color: #0d47a1; padding: 10px; margin-top: 15px; border-radius: 4px;">
        <strong>Troubleshooting:</strong> If fields aren't showing, make sure ACF Pro is active and field groups are synced.
        <br>Go to Custom Fields → Field Groups and look for any "Sync available" notices.
        <br><br><strong>Fixed Issues:</strong> All PHP "Undefined array key" warnings have been resolved using safe_get() function.
    </div>
</div>
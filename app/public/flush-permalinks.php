<?php
/**
 * Flush Permalinks
 * Access via: http://milford-sound.local/flush-permalinks.php
 */

// Load WordPress
require_once('wp-config.php');
require_once('wp-load.php');

// Check if user has permission
if (!current_user_can('manage_options')) {
    wp_die('Access denied. Admin permissions required.');
}

echo '<h2>🔄 Flushing Permalinks</h2>';

// Flush rewrite rules
flush_rewrite_rules();

echo '<div style="background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;">';
echo '<h3>✅ Permalinks Flushed Successfully</h3>';
echo '<p>Rewrite rules have been regenerated.</p>';
echo '</div>';

// Test the tour category URL
echo '<h3>🎯 Test Links:</h3>';
echo '<p><strong>Tour Category Page:</strong> <a href="http://milford-sound.local/tour-categories/tour-category/" target="_blank">http://milford-sound.local/tour-categories/tour-category/</a></p>';
echo '<p><strong>Homepage:</strong> <a href="http://milford-sound.local/" target="_blank">http://milford-sound.local/</a></p>';

echo '<h3>🔧 What to do next:</h3>';
echo '<ol>';
echo '<li>Click the tour category link above to test the page</li>';
echo '<li>The page should now load with the proper single-categories.php template</li>';
echo '<li>Hero background video/image should display correctly</li>';
echo '</ol>';

// Auto-delete for security
unlink(__FILE__);
?>
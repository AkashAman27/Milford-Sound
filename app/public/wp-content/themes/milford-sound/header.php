<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Header -->
<header class="site-header">
    <div class="header-container">
        <a href="<?php echo home_url(); ?>" class="site-logo">
            Milford Sound
        </a>
        
        <nav class="main-nav">
            <ul>
                <li><a href="<?php echo home_url(); ?>">Home</a></li>
                <li><a href="<?php echo get_permalink(797); ?>">Tours</a></li>
                <li><a href="<?php echo get_permalink(801); ?>">Blog</a></li>
                <li><a href="#guides">Guides</a></li>
                <li><a href="#quiz">Quiz</a></li>
            </ul>
        </nav>
    </div>
</header>
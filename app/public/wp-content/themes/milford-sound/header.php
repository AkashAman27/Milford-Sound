<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2dd4bf',
                        secondary: '#3b82f6',
                        accent: '#f59e0b',
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                        'fade-in-down': 'fadeInDown 0.8s ease-out forwards',
                        'scale-in': 'scaleIn 0.6s ease-out forwards',
                        'gradient-x': 'gradient-x 15s ease infinite',
                    },
                    utilities: {
                        '.scrollbar-hide': {
                            '-ms-overflow-style': 'none',
                            'scrollbar-width': 'none',
                            '&::-webkit-scrollbar': {
                                display: 'none'
                            }
                        },
                        '.line-clamp-2': {
                            'overflow': 'hidden',
                            'display': '-webkit-box',
                            '-webkit-box-orient': 'vertical',
                            '-webkit-line-clamp': '2',
                        },
                        '.line-clamp-3': {
                            'overflow': 'hidden',
                            'display': '-webkit-box',
                            '-webkit-box-orient': 'vertical',
                            '-webkit-line-clamp': '3',
                        }
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeInDown: {
                            '0%': { opacity: '0', transform: 'translateY(-30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        'gradient-x': {
                            '0%, 100%': {
                                'background-size': '200% 200%',
                                'background-position': 'left center'
                            },
                            '50%': {
                                'background-size': '200% 200%',
                                'background-position': 'right center'
                            },
                        },
                    }
                }
            }
        }
    </script>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Modern Header with Tailwind CSS -->
<header class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-lg border-b border-gray-200/50 shadow-sm transition-all duration-300" id="header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center text-white font-bold text-lg group-hover:scale-105 transition-transform duration-200">
                        M
                    </div>
                    <span class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                        Milford Sound
                    </span>
                </a>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-1">
                <a href="<?php echo home_url(); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-primary/10 transition-all duration-200 font-medium">
                    Home
                </a>
                <a href="<?php echo get_permalink(797); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-primary/10 transition-all duration-200 font-medium">
                    Tours
                </a>
                <a href="<?php echo get_permalink(801); ?>" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-primary/10 transition-all duration-200 font-medium">
                    Blog
                </a>
                <a href="#guides" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-primary/10 transition-all duration-200 font-medium">
                    Guides
                </a>
                <a href="#quiz" class="px-4 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-primary/10 transition-all duration-200 font-medium">
                    Quiz
                </a>
            </nav>
            
            <!-- CTA Button -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="#contact" class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-2.5 rounded-full font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200">
                    Book Now
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="md:hidden p-2 rounded-lg text-gray-700 hover:bg-gray-100" id="mobile-menu-btn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="md:hidden bg-white border-t border-gray-200 hidden" id="mobile-menu">
        <div class="px-4 py-3 space-y-1">
            <a href="<?php echo home_url(); ?>" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Home</a>
            <a href="<?php echo get_permalink(797); ?>" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Tours</a>
            <a href="<?php echo get_permalink(801); ?>" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Blog</a>
            <a href="#guides" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Guides</a>
            <a href="#quiz" class="block px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100">Quiz</a>
            <a href="#contact" class="block mt-4 bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-lg text-center font-semibold">Book Now</a>
        </div>
    </div>
</header>

<!-- Header Padding Spacer -->
<div class="h-16 lg:h-20"></div>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    mobileMenuBtn?.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
    
    // Header scroll effect
    const header = document.getElementById('header');
    let lastScrollY = window.scrollY;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('bg-white/95');
            header.classList.remove('bg-white/90');
        } else {
            header.classList.add('bg-white/90');
            header.classList.remove('bg-white/95');
        }
    });
});
</script>
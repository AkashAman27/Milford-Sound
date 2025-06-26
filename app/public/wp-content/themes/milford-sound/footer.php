<!-- Modern Footer with Tailwind CSS -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Brand Section -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center text-white font-bold text-lg">
                        M
                    </div>
                    <span class="text-xl font-bold">Milford Sound</span>
                </div>
                <p class="text-gray-400 leading-relaxed">
                    Your gateway to New Zealand's most spectacular fjord experience. Creating unforgettable memories since 1985.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.219-.359-1.219c0-1.142.662-1.997 1.482-1.997.699 0 1.219.526 1.219 1.156 0 .703-.219 1.764-.359 2.743-.199.937.469 1.703 1.405 1.703 1.687 0 2.984-1.781 2.984-4.357 0-2.277-1.641-3.869-3.979-3.869-2.71 0-4.301 2.034-4.301 4.134 0 .821.314 1.703.703 2.184.078.094.089.177.067.272-.074.314-.239 1.047-.272 1.193-.044.177-.141.213-.325.129-1.209-.562-1.968-2.327-1.968-3.757 0-3.002 2.184-5.763 6.281-5.763 3.297 0 5.861 2.347 5.861 5.487 0 3.27-2.063 5.901-4.926 5.901-.961 0-1.868-.499-2.177-1.155l-.592 2.26c-.214.828-.791 1.864-1.178 2.494.887.274 1.814.421 2.784.421 6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="<?php echo get_permalink(797); ?>" class="text-gray-400 hover:text-white transition-colors duration-200">All Tours</a></li>
                    <li><a href="#guides" class="text-gray-400 hover:text-white transition-colors duration-200">Travel Guides</a></li>
                    <li><a href="#quiz" class="text-gray-400 hover:text-white transition-colors duration-200">Planning Quiz</a></li>
                    <li><a href="<?php echo get_permalink(801); ?>" class="text-gray-400 hover:text-white transition-colors duration-200">Blog</a></li>
                </ul>
            </div>
            
            <!-- Support -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Support</h3>
                <ul class="space-y-2">
                    <li><a href="#faq" class="text-gray-400 hover:text-white transition-colors duration-200">FAQ</a></li>
                    <li><a href="#booking" class="text-gray-400 hover:text-white transition-colors duration-200">Booking Help</a></li>
                    <li><a href="#cancellation" class="text-gray-400 hover:text-white transition-colors duration-200">Cancellation Policy</a></li>
                    <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors duration-200">Contact Us</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Contact Info</h3>
                <ul class="space-y-3">
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                        <span class="text-gray-400">Queenstown, New Zealand</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <span class="text-gray-400">+64 3 123 4567</span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <span class="text-gray-400">info@milfordsound.co</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                &copy; <?php echo date('Y'); ?> Milford Sound. All rights reserved.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#privacy" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Privacy Policy</a>
                <a href="#terms" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Terms of Service</a>
                <a href="#sitemap" class="text-gray-400 hover:text-white text-sm transition-colors duration-200">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
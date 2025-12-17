
    </main>

    <!-- footer starts here -->
    <footer class="py-8 px-4 sm:px-6 lg:px-10 text-center">
        
        <?php if (!str_contains($_SERVER['PHP_SELF'], '/errors/maintenance.php')) { ?>
        <div id="quick-links" class="flex flex-wrap justify-center items-center gap-3 sm:gap-6 lg:gap-8 py-6 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
            <a href="<?php echo url(""); ?>" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">Home</a>
            <a href="<?php echo url("about"); ?>" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">About</a>
            <a href="<?php echo url("projects"); ?>" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">Projects</a>
            <a href="<?php echo url('blogs'); ?>" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">Blog</a>
            <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">LinkedIn</a>
            <a href="<?= SOCIAL_GITHUB; ?>" target="_blank" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">GitHub</a>
            <a href="<?= ACADEMIC_PURE; ?>" target="_blank" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">PURE</a>
            <a href="<?= ACADEMIC_ORCID; ?>" target="_blank" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">ORCID</a>
            <a href="<?= SOCIAL_MEDIUM; ?>" target="_blank" class="hover:underline hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">Medium</a>
        </div>
        <?php } ?>

        <p class="text-sm text-gray-600 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
            Design and Develop by 
            <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="font-bold hover:underline brand-text">Gulger Mallik</a>. 
            &copy; <?php echo date("Y"); ?> All Rights Reserved.
        </p>
    </footer>
</div>
    <!-- body ends -->
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= url('assets/js/app.js'); ?>"></script>
    <script>
        AOS.init();
    </script>
    <script>
        // Theme toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;
            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            
            // Function to update icon visibility
            function updateThemeIcon() {
                if (htmlElement.classList.contains('dark')) {
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                } else {
                    lightIcon.classList.add('hidden');
                    darkIcon.classList.remove('hidden');
                }
            }
            
            // Function to set theme
            function setTheme(theme) {
                if (theme === 'dark') {
                    htmlElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else if (theme === 'light') {
                    htmlElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else if (theme === 'system') {
                    localStorage.setItem('theme', 'system');
                    // Apply system preference
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        htmlElement.classList.add('dark');
                    } else {
                        htmlElement.classList.remove('dark');
                    }
                }
                updateThemeIcon();
            }
            
            // Initialize icon on page load
            updateThemeIcon();
            
            // Toggle theme on button click
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', function() {
                    const currentTheme = localStorage.getItem('theme');
                    
                    // Cycle through: light -> dark -> light
                    // If you want to include system preference, modify this logic:
                    // light -> dark -> system -> light
                    if (htmlElement.classList.contains('dark')) {
                        setTheme('light');
                    } else {
                        setTheme('dark');
                    }
                });
            }
            
            // Listen for system theme changes (if theme is set to 'system')
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (localStorage.getItem('theme') === 'system') {
                    if (e.matches) {
                        htmlElement.classList.add('dark');
                    } else {
                        htmlElement.classList.remove('dark');
                    }
                    updateThemeIcon();
                }
            });
        });
    </script>
</body>
</html>
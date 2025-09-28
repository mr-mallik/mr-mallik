
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
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= url('assets/js/app.js'); ?>"></script>
    <script>
        AOS.init();
    </script>
</html>

    </main>

    <!-- footer starts here -->
    <footer class="p-8 text-center">
        
        <?php if (!str_contains($_SERVER['PHP_SELF'], '/errors/maintenance.php')) { ?>
        <div id="quick-links" class="flex flex-row gap-8 p-4 mb-4 text-xs text-gray-600 justify-center items-center">
            <a href="<?php echo url(""); ?>" class="hover:underline">Home</a>
            <a href="<?php echo url("about"); ?>"  class="hover:underline">About</a>
            <a href="<?php echo url("projects"); ?>"  class="hover:underline">Projects</a>
            <a href="<?php echo url("stories"); ?>"  class="hover:underline">Blog</a>
            <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="hover:underline">LinkedIn</a>
            <a href="<?= SOCIAL_GITHUB; ?>" target="_blank" class="hover:underline">GitHub</a>
            <a href="<?= SOCIAL_INSTAGRAM; ?>" target="_blank" class="hover:underline">Instagram</a>
            <a href="<?= SOCIAL_MEDIUM; ?>" target="_blank" class="hover:underline">Medium</a>
        </div>
        <?php } ?>

        <p class="text-sm text-gray-600">Design and Develop by 
            <a href="<?= SOCIAL_LINKEDIN; ?>" target="_blank" class="font-bold hover:underline ">Gulger Mallik</a>. 
            &copy; <?php echo date("Y"); ?> All Rights Reserved.
        </p>
    </footer>
</div>
    <!-- body ends -->
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        AOS.init();
    </script>
</html>
<?php
require_once __DIR__ . '/partials/header.php'; # config file
?>

    <section id="home" class="container mx-auto">
        <div class="flex gap-8">
            <div class="flex w-1/2 p-10 bg-gray-800 rounded-3xl">
                <img src="https://media.licdn.com/dms/image/v2/D4E03AQElfwqbY508Og/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1729591268715?e=1747267200&v=beta&t=BUkiMNHgLPC1KYCTcfRrrfpHoBx-logWw3Xfc8GFga0" alt="Gulger Mallik" 
                    class="h-42 rounded-tl-3xl rounded-br-3xl">
                
                <div class="flex flex-col justify-center pl-10">
                    <p>Hi, I'm</p>
                    <h1 class="py-2 text-4xl font-bold flex-nowrap">Gulger Mallik.</h1>
                    <p class="text-gray-400">Software Engineer</p>
                </div>
            </div>

            <div class="flex flex-col gap-8 w-1/2">
                <div class="p-4 bg-gray-800 rounded-3xl">
                    <p> Featured work &#x2022; Achivements and Milestones </p>
                </div>
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <div class="p-4 bg-gray-800 rounded-3xl">
                            <div>
                                <p class="text-gray-500 uppercase"> More About Me </p>
                                <h2></h2>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="p-4 bg-gray-800 rounded-3xl">
                            <p> Featured work &#x2022; Achivements and Milestones </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php
require_once __DIR__ . '/partials/footer.php'; # config file
?>
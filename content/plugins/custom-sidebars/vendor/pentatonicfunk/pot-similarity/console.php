<?php
$possible_vendors = [
    __DIR__.'/../../autoload.php',
    __DIR__.'/vendor/autoload.php',
];
foreach ($possible_vendors as $file) {
    if (file_exists($file)) {
        /** @noinspection PhpIncludeInspection */
        require $file;
        $loaded = true;
        break;
    }
}

use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new \PotSimilarity\Commands\FindSimilarity());
try {
    $application->run();
} catch (Exception $e) {
    //error
}
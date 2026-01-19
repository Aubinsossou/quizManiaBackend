<?php
// === Clear Laravel cache en ligne (Laravel 12) ===

echo "<h2>Nettoyage Laravel en ligne</h2>";

// Fonction pour exécuter les commandes artisan
function runArtisan($command) {
    echo "<p>➤ Exécution : $command</p>";
    $output = [];
    $return_var = 0;
    exec("php artisan $command 2>&1", $output, $return_var);
    foreach ($output as $line) {
        echo htmlspecialchars($line) . "<br>";
    }
    echo "<hr>";
}

// Mode maintenance ON
runArtisan("down");

// Clear caches
runArtisan("cache:clear");
runArtisan("config:clear");
runArtisan("route:clear");
runArtisan("view:clear");
runArtisan("optimize:clear");

// Regénération autoload Composer
runArtisan("dump-autoload -o");

// Mode maintenance OFF
runArtisan("up");

echo "<h3>✅ Nettoyage terminé !</h3>";

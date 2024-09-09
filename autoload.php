<?php

spl_autoload_register(function ($class) {
    // Converti il namespace in un percorso di file
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // La classe non appartiene a questo namespace
        return;
    }

    // Ottieni il percorso relativo della classe
    $relative_class = substr($class, $len);

    // Sostituisci i separatori di namespace con separatori di directory
    // Aggiungi .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Se il file esiste, richiedilo
    if (file_exists($file)) {
        require $file;
    }
});
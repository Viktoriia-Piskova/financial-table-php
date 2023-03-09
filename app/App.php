<?php

declare(strict_types=1);

function getTransactionFiles(): array
{
    $files = [];

    foreach (scandir(FILES_PATH) as $file) {
        echo '<pre>' . var_dump($file) . '</pre>';
    }

    return $files;
}

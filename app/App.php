<?php

declare(strict_types=1);

function getTransactionFiles(string $dirPath): array
{
    $files = [];

    foreach (scandir($dirPath) as $file) {

        if (is_dir($file)) {
            continue;
        }

        $files[] = $dirPath . $file;
    }

    return $files;
}

function getTransaction(string $filename, ?callable $transactionHandler = null): array
{
    if (!file_exists($filename)) {
        trigger_error('File "' . $filename . '" does not exist', E_USER_ERROR);
    }

    $file = fopen($filename, 'r');

    fgetcsv($file);

    $transactions = [];

    while (($transaction = fgetcsv($file)) !== false) {
        if ($transactionHandler !== null) {
            $transactions[] = $transactionHandler($transaction);
        }
    }

    return $transactions;
}


function parseTransaction(array $transactionRecord): array
{
    [$date, $checkNumber, $description, $amount] = $transactionRecord;

    $amount = (float) str_replace([',', '$'], '', $amount);

    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount
    ];
}

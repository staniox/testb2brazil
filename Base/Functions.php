<?php
function SaveJson($json){
    $json_data = json_encode($json);
    file_put_contents($GLOBALS['BaseDir'].'articles.json', $json_data);
}

function ZipFolder($folder){

    $rootPath = realpath($folder);


    $Zip = new ZipArchive();
    $Zip->open($GLOBALS['BaseDir'].'Articles.Zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file)
    {

        if (!$file->isDir())
        {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            $Zip->addFile($filePath, $relativePath);
        }
    }
    $Zip->close();
}
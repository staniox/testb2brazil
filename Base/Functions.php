<?php

require '../vendor/autoload.php';

use Mailgun\Mailgun;


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

function SendEmail(){
    //Your credentials
    $mg = Mailgun::create('0c2244e71af340707e250f4bb488dfa6-7cd1ac2b-27b9ccbb');
    $domain = "sandbox6fed6739a354439ab6d9e8d3649a125d.mailgun.org";
//Customise the email - self explanatory
    $mg->messages()->send($domain, [
        'from'    => 'mailgun@sandbox6fed6739a354439ab6d9e8d3649a125d.mailgun.org',
        'to'      => 'brunogomes1958@gmail.com',
        'subject' => 'Articles Modificados',
        'text'    => 'segue o articles modificado',
        'attachment' => [
            ['filePath'=>'../Tmp/Articles.Zip', 'filename'=>'articles.zip']
        ]
    ]);

}

function CleanFolder($folder){
    $rootPath = realpath($folder);
    $files = glob($rootPath.'/*'); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file))
            unlink($file); // delete file
    }
}
<?php
require 'vendor/autoload.php';

use Rah\Danpu\Dump;
use Rah\Danpu\Export;
use Rah\Danpu\Import;

function export($sqlFilename,$cfg=false){
    $configFilename=ROOT.'config/db.php';
    if($cfg==false){
        if(file_exists($configFilename)){
            $cfg=require $configFilename;
        }else{
            $cfg=[
            'database_type' => 'mysql',
            'database_name' => 'test',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
            ];
        }
    }
    if(file_exists($sqlFilename)){
        unlink($sqlFilename);
    }
    try {
        $dump = new Dump;
        $dsn="mysql:dbname={$cfg['database_name']};";
        $dsn.="host={$cfg['server']}";
        $dump
            ->file($sqlFilename)
            ->dsn($dsn)
            ->user($cfg['username'])
            ->pass($cfg['password'])
            ->tmp('/tmp');
        new Export($dump);
        echo "sucesso: db exportado para $sqlFilename".PHP_EOL;
    } catch (\Exception $e) {
        echo 'erro: ' . $e->getMessage().PHP_EOL;
    }
}

function import($sqlFilename,$cfg=false){
    $configFilename=ROOT.'config/db.php';
    if($cfg==false){
        if(file_exists($configFilename)){
            $cfg=require $configFilename;
        }else{
            $cfg=[
            'database_type' => 'mysql',
            'database_name' => 'test',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
            ];
        }
    }
    if($cfg==false){
        if(file_exists($configFilename)){
            $cfg=require $configFilename;
        }else{
            $cfg=[
            'database_type' => 'mysql',
            'database_name' => 'test',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
            ];
        }
    }
    if(file_exists($sqlFilename)){
        try {
            $dump = new Dump;
            $dsn="mysql:dbname={$cfg['database_name']};";
            $dsn.="host={$cfg['server']}";
            $dump
                ->file($sqlFilename)
                ->dsn($dsn)
                ->user($cfg['username'])
                ->pass($cfg['password'])
                ->tmp('/tmp');
            new Import($dump);
            echo "sucesso: $sqlFilename importado para o db".PHP_EOL;
        } catch (\Exception $e) {
            echo 'erro: ' . $e->getMessage().PHP_EOL;
        }
    }else{
        die("erro: o arquivo $sqlFilename não existe".PHP_EOL);
    }
}

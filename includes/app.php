<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'config/database.php';


use Model\Project;

//ClassList:
define ("classList", ['Project','Blog','Publication','Quote','Degree','Contributor','Job','Award']);


//Every instance will have the same connection
$db = conectarDB();
Project::setDB($db);   //Because its static, every instance 
                //will have the same connection. 
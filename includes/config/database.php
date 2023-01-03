<?php

use function Model\debugChunk;
// $tables_names = ['research_projects','awards','blog',
//                 'blog_contributors','education','experience',
//                 'publications','quotes'];
function conectarDB() : mysqli {
    $db = new mysqli($_ENV['DB_HOST'], 
                    $_ENV['DB_USER'], 
                    $_ENV['DB_PASS'], 
                    $_ENV['DB_DB']);
    if(!$db){
        echo "Database Connection Error";
        exit;   //Evitar revelar informacion sensible.
    }
    return $db;
}



function updateDB(mysqli $dbInstance, String $tableName, $values, $id) {
    $query = "UPDATE ${tableName} SET ";
    foreach ($values as $key=>$val) {
        $query = $query . "${key}='${val}',";
    };
    $query = substr($query,0,-1) . " WHERE ${tableName}.id = $id";    
    $result = mysqli_query($dbInstance, $query);
    if($result){
        //Redirect User:
        header("Location: /admin?upd=1"); //Only works if there is no previous HTML
    }
}



function showErrors(array $arrayErrors) {
    foreach($arrayErrors as $e) {
        echo <<< DIVERRORS
            <div class="alert errormsg">
            $e
            </div>
        DIVERRORS;
    }
}

function showMsg($msg, $type="cration") {
    if ($msg==1) {
        if ($type==="creation") {
            echo <<< DIVERRORS
                <div class="alert okmsg">
                Correctly Added to the database
                </div>
            DIVERRORS;
        } elseif ($type==="update") {
            echo <<< DIVERRORS
                <div class="alert okmsg">
                correctly Updated in the database
                </div>
            DIVERRORS;
        } elseif ($type==="delete") {
            echo <<< DIVERRORS
                <div class="alert okmsg">
                Successfully Deleted from the database
                </div>
            DIVERRORS;
        }
    }

}


function sanitizeArray(mysqli $dbInstance, array $arrayValues) {
    $buffer = array();
    foreach($arrayValues as $key => $val) {
        $buffer[$key] = mysqli_real_escape_string($dbInstance, $val);
    }
    return $buffer;
}






function eliminateRecord($dbInstance, $di,$tn) {
    $query = "SELECT * FROM $tn WHERE $tn.id = $di";
    $res = mysqli_query( $dbInstance, $query );
    $resArray = mysqli_fetch_assoc($res);
    $imgName = "";
    foreach ($resArray as $key => $val) {
        if (str_contains($key, "imagen")) {
            $imgName = $val;
        }
    }
    if ($imgName) {
        unlink( "../images/" . $imgName );
    }
    
    $query = "DELETE FROM $tn WHERE $tn.id = $di";
    $res = mysqli_query( $dbInstance, $query );
    header("Location: /admin/index.php?dls=1");
}



if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle): bool {
        if ( is_string($haystack) && is_string($needle) ) {
            return '' === $needle || false !== strpos($haystack, $needle);
        } else {
            return false;
        }
    }
}



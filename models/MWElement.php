<?php
namespace Model;
use Intervention\Image\ImageManagerStatic as Image;

class MWElement {

    //DB static instance. 
    //Static because we do not want to create 1000 connections
    // for 1000 objects of this class. 
    //Proected: Cannot be accessed by the object, only in the class.
    protected static $db;
    protected static $errores = [];
    public $valuesArray;
    public $prevFileNameImg='';
    public $prevFileNameTxt='';
    protected $allowable_image_size = 5 * 1000 * 1000;
    protected $allowable_text_size = 1 * 1000 * 1000;
    public static $imgFieldName; //Name of the image field in the table
    public static $txtFieldName; //Name of the image field in the table
    public static $imgObj;
    public static $txtObj;


    //Public Methods
    //-----------------------------

    //Define connection to DB. 
    public static function setDB($database) {
        self::$db = $database;  // Use self for static attributes. 
    }

    public function getTableName() {
        return static::$tn;
    }    

    public function validate_commit(String $crudAction="create", $filesArray=null, $id=null) {
        self::$errores =    $this->validate($crudAction, $filesArray);
        
        if (empty(self::$errores)) {
            $this->commit($filesArray, $crudAction, $this->prevFileNameImg, $this->prevFileNameTxt, $id);
        } else{
            return self::$errores;
        }
    }

    public function commit($filesArray=null, String $crudAction="create", String $prevFileNameImg=null, String $prevFileNameTxt=null, $id=null) {
        //Sanitize the inputs
        $this->valuesArray = $this->sanitize($this->valuesArray);
        
        //In case there is an image, create it and process it with Intervention Image
        if (static::$imgObj && !empty($filesArray[static::$imgFieldName]["name"])) {

            //Create folder for images files
            $folderFiles = $_SERVER['DOCUMENT_ROOT'] . '/images/';
            if (!is_dir($folderFiles)) {
                mkdir($folderFiles);
            }
            //Creates the name of the image to be uploaded
            $imageName = md5(uniqid( rand(), true )) . ".jpg";
            
            //Includes the image name into the valuesArray to be inserted to the DB
            $this->valuesArray[static::$imgFieldName] = $imageName;   

            //Creates the image object, crops and resize
            $img = Image::make($filesArray[static::$imgFieldName]['tmp_name'])->fit(800, 600);
            
            //Moves image from memory to disk
            $img->save($folderFiles . $imageName);
            
            //Frees memory
            $img->destroy();

            //If we are updating a file, need to delete previous file from the server.
            if ($crudAction === "update") {
                unlink($folderFiles . $prevFileNameImg);
            }
            
        }

        if (static::$txtObj && !empty($filesArray[$this->txtFieldName]["name"])) {

            //Create folder for txt files
            $folderFiles = $_SERVER['DOCUMENT_ROOT'] . '/texts/';
            if (!is_dir($folderFiles)) {
                mkdir($folderFiles);
            }

            //Creates the name of the txt to be uploaded
            $txtName = md5(uniqid( rand(), true )) . ".txt";

            
            //Includes the image name into the valuesArray to be inserted to the DB
            $this->valuesArray[$this->txtFieldName] = $txtName;   

            //Moves the file from memory to disk. 
            move_uploaded_file($filesArray[$this->txtFieldName]['tmp_name'], $folderFiles . $txtName);

            //If we are updating a file, need to delete previous file from the server.
            if ($crudAction === "update") {
                unlink($folderFiles . $prevFileNameTxt);
            }
            
        }
        if ($crudAction === "create") {
            $this->insertarDB(self::$db, static::$tn, $this->valuesArray);
        } elseif ($crudAction === "update") {
            $this->updateDB(self::$db, static::$tn, $this->valuesArray, $id);
        }
        
    }


    public function getErrors(){
        return self::$errores;
    }

    public function validate(String $crudAction="create", $files_array=null) {
        //Validation for empty fields
        self::$errores = $this->checkEmptyFields($this->valuesArray, $crudAction);

        //If there is an image, then validate the image by size.
        if (static::$imgObj) {
            self::$errores = $this->fileValidate(self::$errores, $files_array, "image", $crudAction);
        }

        if (static::$txtObj) {
            self::$errores = $this->fileValidate(self::$errores, $files_array, "text", $crudAction);
        }
        return self::$errores;
    }



    private function sanitize($arrayVals) {
        $bufferArray = [];
        foreach($arrayVals as $key=>$val) {
            $bufferArray[$key] = self::$db->escape_string($val);
        }
        return $bufferArray;
    }   
    

    private function insertarDB($dbInstance, String $tableName, $values) {
        $valuesBuffer = array();
        foreach ($values as $val) {
            $valuesBuffer[] = "'" . $val . "'";
        };
        $query = "INSERT INTO ${tableName} ( " . implode(', ',array_keys($values)) . ") VALUES (" . implode(', ',$valuesBuffer) . ")";
        $result = $dbInstance->query($query);
    
        if($result){
            //Redirect User:
            header("Location: /admin?ins=1"); //Only works if there is no previous HTML
        }
    }

    private function updateDB($dbInstance, String $tableName, $values, $id) {
        $query = "UPDATE ${tableName} SET ";
        foreach ($values as $key=>$val) {
            $query = $query . "${key}='${val}',";
        };
        $query = substr($query,0,-1) . " WHERE ${tableName}.id = $id";
        $result = $dbInstance->query($query);
        if($result){
            //Redirect User:
            header("Location: /admin?upd=1"); //Only works if there is no previous HTML
        }
    }

    private function checkEmptyFields(array $vArray, String $crudAction="create") {
        $emptyErrors = array();
        foreach($vArray as $key => $value) {
            if (!$value) {
                $splitKey = explode('_', $key);
                
                if ($crudAction!=="update" || ($crudAction==="update" && $splitKey[0]!=="imagen" && $splitKey[1]!=="imagen")) {
                    $emptyErrors[] = $splitKey[1] . " " . $splitKey[0] . " is mandatory";
                } 
            };
        }
        return $emptyErrors;
    }


    private function fileValidate(array $errorsArray, array $fileArray, String $type="image", String $crudAction="create") {
        $buffer = $errorsArray;
        if (!$fileArray || !$fileArray[static::$imgFieldName]['name'] || $fileArray[static::$imgFieldName]['error']) {
            if ($crudAction === "create") {
                $buffer[] = "Uploading the " . $type . " file is mandatory";
            }
        } else {
            if ($type==="image") {
                if ($fileArray[static::$imgFieldName]['size'] > $this->allowable_image_size) {
                    $buffer[] = "Image is too large. Must be smaller than 5 MB";
                }
            } else {
                if ($fileArray[$this->txtFieldName]['size'] > $this->allowable_text_size) {
                    $buffer[] = "File is too large. Must be smaller than 1 mb";
                }
            }
        }   
        return $buffer;
    }


//Functions that interact with DB:


    //Function creates an instance of the same class, with no data. 
    protected static function autoInstantiate() {
        $instance = new static;
        return $instance;
    }

    //This function pulls all records from the DB and fetchs to object
    public static function pullAll() {
        $query = "SELECT * FROM " . static::$tn;
        $resultsArray =     self::poseQuery($query);
        return $resultsArray;
    }

    protected static function castObjects($resQuery) {
        $arrayObj = [];
        while ($row = $resQuery->fetch_assoc()):
            $instance = new static;
            foreach($row as $key => $val) {
                if (str_contains($key, "imagen")) {
                    $instance->valuesArray[static::$imgFieldName] = $val;
                } else {
                    $instance->valuesArray[$key] = $val;
                }
            }
            $arrayObj[] =       $instance;
        endwhile;
        return $arrayObj;
    }

    public static function poseQuery($query) {
        $res    =   self::$db->query($query);
        $res    =   self::castObjects($res);
        return $res;
    }
    

    public static function findRecord($idNumber) {
        $query = "SELECT * FROM " . static::$tn . " WHERE id = $idNumber";
        $resultsArray =     self::poseQuery($query);
        return array_shift($resultsArray);
    }

    public function syncUpdate(array $postArray, array $filesArray=null ) {
        $obj    =   new static($postArray);
        if (static::$imgObj) {
            $obj->valuesArray[static::$imgFieldName] = $this->valuesArray[static::$imgFieldName];
            $obj->prevFileNameImg = $this->valuesArray[static::$imgFieldName];
        }

        if (static::$txtObj) {
            $obj->valuesArray[static::$txtFieldName] = $this->valuesArray[static::$txtFieldName];
            $obj->prevFileNameImg = $this->valuesArray[static::$txtFieldName];
        }
        return $obj;
    }

    public function eliminateRecord($instance, $di) {
        if ($instance->valuesArray[$instance::$imgFieldName]) {
            unlink( $_SERVER['DOCUMENT_ROOT'] . '/images/' . $instance->valuesArray[$instance::$imgFieldName] );
        }

        if ($instance->valuesArray[$instance::$txtFieldName]) {
            unlink( $_SERVER['DOCUMENT_ROOT'] . '/texts/' . $instance->valuesArray[$instance::$txtFieldName] );
        }
        $ph_tn = $instance::$tn;
        $query = "DELETE FROM $ph_tn WHERE $ph_tn.id = $di";
        $res = self::$db->query($query);
        header("Location: /admin?dls=1");
    }



}
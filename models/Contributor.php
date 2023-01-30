<?php
namespace Model;

class Contributor extends MWElement {

    public static $tn = "blog_contributors";
    public static $imgObj                               = false;
    public static $txtObj                               = false;
      

    public function __construct($argsPost=[]) {
        $this->valuesArray["name_contributor"]         = $argsPost['name_contributor'] ?? '';
        
    }   

    // public function getContName($contNumber) {
    //     $query = "SELECT * FROM blog_contributors WHERE id=" . $contNumber;
    //     $res = self::$db->query($query);
    //     $res = $res->fetchAssoc();
    //     return $res['name_contributor'];
    // }

    
}
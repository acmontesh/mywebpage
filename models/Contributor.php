<?php
namespace Model;

class Contributor extends MWElement {

    public static $tn = "blog_contributors";
    public static $imgObj                               = false;
    public static $txtObj                               = false;
      

    public function __construct($argsPost=[]) {
        $this->valuesArray["name_contributor"]         = $argsPost['name_contributor'] ?? '';
        
    }   

    
}
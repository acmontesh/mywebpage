<?php
namespace Model;

class Degree extends MWElement {

    public static $tn = "education";
    public static $imgObj                               = false;
    public static $txtObj                               = false;
    public function __construct($argsPost=[]) {
        $this->valuesArray["title_degree"]         = $argsPost['title_degree'] ?? '';
        $this->valuesArray["institution_degree"]      = $argsPost['institution_degree'] ?? '';
        $this->valuesArray["city_degree"]  = $argsPost['city_degree'] ?? '';
        $this->valuesArray["date_degree"]      = $argsPost['date_degree'] ?? '';
        
    }   


    
}
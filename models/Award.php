<?php
namespace Model;

class Award extends MWElement {

    public static $tn = "awards";
    public static $imgObj                               = false;
    public static $txtObj                               = false;

    public function __construct($argsPost=[]) {
        $this->valuesArray["name_award"]            = $argsPost['name_award'] ?? '';
        $this->valuesArray["granter_award"]         = $argsPost['granter_award'] ?? '';
        $this->valuesArray["date_award"]            = $argsPost['date_award'] ?? '';
        
    }   

    
}
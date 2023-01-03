<?php
namespace Model;

class Quote extends MWElement {

    public static $tn = "quotes";
    public static $imgFieldName="imagen_quote"; //Name of the image field in the table
    public static $imgObj                               = true;
    public static $txtObj                               = false;

    public function __construct($argsPost=[]) {
        $this->valuesArray["text_quote"]         = $argsPost['text_quote'] ?? '';
        $this->valuesArray["author_quote"]      = $argsPost['author_quote'] ?? '';
        
    }   

}
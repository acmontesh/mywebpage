<?php
namespace Model;

class Publication extends MWElement {

    public static $tn = "publications";
    public static $imgObj                               = false;
    public static $txtObj                               = false;

    public function __construct($argsPost=[]) {
        $this->valuesArray["title_publication"]         = $argsPost['title_publication'] ?? '';
        $this->valuesArray["comment_publication"]      = $argsPost['comment_publication'] ?? '';
        $this->valuesArray["journal_publication"]  = $argsPost['journal_publication'] ?? '';
        
    }   


    
}
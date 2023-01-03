<?php
namespace Model;

class Job extends MWElement {

    public static $tn = "experience"; 
    public static $imgObj                               = false;
    public static $txtObj                               = false;

    public function __construct($argsPost=[]) {
        $this->valuesArray["position_job"]         = $argsPost['position_job'] ?? '';
        $this->valuesArray["duration_job"]      = $argsPost['duration_job'] ?? '';
        $this->valuesArray["company_job"]  = $argsPost['company_job'] ?? '';
        $this->valuesArray["description_job"]      = $argsPost['description_job'] ?? '';
        $this->valuesArray["current_job"]      = $argsPost['current_job'] ?? '';
        
    }   

    
}
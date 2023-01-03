<?php
namespace Model;

class Project extends MWElement {

    public static $tn = "research_projects";
    public static $imgFieldName="imagen_project"; //Name of the image field in the table
    public static $imgObj                               = true;
    public static $txtObj                               = false;
    public function __construct($argsPost=[]) {
        $this->valuesArray["title_project"]         = $argsPost['title_project'] ?? '';
        $this->valuesArray["headline_project"]      = $argsPost['headline_project'] ?? '';
        $this->valuesArray["publications_project"]  = $argsPost['publications_project'] ?? '';
        $this->valuesArray["abstract_project"]      = $argsPost['abstract_project'] ?? '';    
        
        
    }   



    
}
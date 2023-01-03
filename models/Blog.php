<?php
namespace Model;

class Blog extends MWElement {

public static $tn = "blog";
public static $imgFieldName="imagen_blog"; //Name of the image field in the table
public static $txtFieldName="article_blog"; //Name of the image field in the table
public static $imgObj                               = true;
public static $txtObj                               = true;

public function __construct($argsPost=[]) {
    $this->valuesArray["title_blog"]            = $argsPost['title_blog'] ?? '';
    $this->valuesArray["headline_blog"]         = $argsPost['headline_blog'] ?? '';
    $this->valuesArray["coauthors_blog"]        = $argsPost['coauthors_blog'] ?? '';
    
}   



}
<?php

namespace Model;

define('TEMPLATES_URL', __DIR__ . '/plantillas');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
function incluirTemplate(string $nameTemplate, bool $inicio=false) {
    include TEMPLATES_URL . "/${nameTemplate}.php";
}

function includeIconTable( String $iconType ) {
    if ($iconType==="edit") {
        echo <<<EOF
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#00abfb" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
            <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
            <line x1="16" y1="5" x2="19" y2="8" />
            </svg>
        EOF;
    } elseif ($iconType==="delete") {
        echo <<<EOF
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ff4500" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <line x1="4" y1="7" x2="20" y2="7" />
            <line x1="10" y1="11" x2="10" y2="17" />
            <line x1="14" y1="11" x2="14" y2="17" />
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>
        EOF;
    } else {
        echo <<<EOF
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate-clockwise-2" width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7bc62d" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 4.55a8 8 0 0 1 6 14.9m0 -4.45v5h5" />
            <line x1="5.63" y1="7.16" x2="5.63" y2="7.17" />
            <line x1="4.06" y1="11" x2="4.06" y2="11.01" />
            <line x1="4.63" y1="15.1" x2="4.63" y2="15.11" />
            <line x1="7.16" y1="18.37" x2="7.16" y2="18.38" />
            <line x1="11" y1="19.94" x2="11" y2="19.95" />
            </svg>
        EOF;
    }
}


function getAllRecords(){
    $responses = [];
    $responses[] = Project::pullAll();
    $responses[] = Blog::pullAll();
    $responses[] = Publication::pullAll();
    $responses[] = Quote::pullAll();
    $responses[] = Degree::pullAll();
    $responses[] = Contributor::pullAll();
    $responses[] = Job::pullAll();
    $responses[] = Award::pullAll();
    return $responses;
}


function showProjects($arrayObjs) {
    if (count($arrayObjs)>0) {
        echo "<thead>";
        foreach ($arrayObjs as $idx=>$obj) {
            
            if ($idx===0) {
                $colNames = array_keys($obj->valuesArray);
                foreach ($colNames as $colHead) {
                    echo "<th>";
                    echo explode('_', $colHead)[0];
                    echo "</th>";
                }
                echo "<th>";
                echo "Actions";
                echo "</th>";
                echo "</thead>";
                echo "<tbody>";
            }
            
            echo "<tr>";
            foreach ($colNames as $col) {
                echo "<td>";
                $val = $obj->valuesArray[$col];
                if (str_contains($col, 'imagen')) {
                    echo "<img class='image-table' src='images/$val'/>";
                } else {
                    echo strlen($val) <= 60 ? $val : substr($val, 0, 60) . " (...)";
                }
                echo "</td>";
            }
            echo "<td>";
            $id                 = $obj->valuesArray['id'];
            $tn                 = $obj->getTableName();
            
            echo "<a href='/projects/actualizar?tn=$tn&rn=$id' class='icons-adminpanel'>";
            includeIconTable("edit");
            echo "</a>";
            echo "<a href='/projects/eliminar?tn=$tn&di=$id' class='icons-adminpanel'>";
            includeIconTable("delete");
            echo "</a>";
            echo "</td>";
            echo "</tr>";
                        
        }
        echo "</tbody>";
        
    } else {
        echo "<div class='alert'>No records yet</div>";        
    }  
}


function showCols($resultAssocArray) {
    $buffer = $resultAssocArray;
    $buffer = mysqli_fetch_assoc($buffer);
    
    return $buffer;
}



if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle): bool {
        if ( is_string($haystack) && is_string($needle) ) {
            return '' === $needle || false !== strpos($haystack, $needle);
        } else {
            return false;
        }
    }
}



function includeInfoMain( $displayType, $results ) {
        
    switch ( $displayType ) {
        case "education":
            echo "<ul class='lista'>";
            foreach ($results as $edu):
                echo "<li><span>" . $edu->valuesArray["title_degree"] . "</span><br>" . $edu->valuesArray["institution_degree"] . "<br>" . $edu->valuesArray["city_degree"] . ", " . substr($edu->valuesArray["date_degree"],0,4) . "</li>";
            endforeach;    
            echo "</ul>";            
            break;

        case "experience":
            echo "<ul class='lista'>";
            foreach ($results as $exp):
                echo "<li><span>" . $exp->valuesArray["position_job"] . "</span><br>";
                echo $exp->valuesArray["current_job"] === "T" ? "Current Roll " : "For " . $exp->valuesArray["duration_job"] . " years ";
                echo "at " . $exp->valuesArray["company_job"] . "</li>";
            endforeach;    
            echo "</ul>";            
            break;

        case "awards":
            echo "<ul class='lista'>";
            foreach ($results as $awd):
                echo "<li><span>" . $awd->valuesArray["name_award"] . "</span><br>";
                echo "Granted by " . $awd->valuesArray["granter_award"] . " in " . date("F", strtotime("1995-" . substr($awd->valuesArray["date_award"],5,7) . "-01" ));
                echo ", " . substr($awd->valuesArray["date_award"],0,4);
            endforeach;    
            echo "</ul>";            
            break;
        
        case "publications":
            echo "<ul class='lista'>";
            foreach ($results as $pub):
                echo "<li><span>" . $pub->valuesArray["title_publication"] . "</span><br>";
                echo $pub->valuesArray["comment_publication"] . " - " . $pub->valuesArray["journal_publication"];
            endforeach;    
            echo "</ul>";            
            break;

        case "research_projects":
            foreach ($results as $rp):
                    $title = $rp->valuesArray["title_project"];
                    $headline = $rp->valuesArray["headline_project"];
                    $imagen = $rp->valuesArray["imagen_project"];
                    $abstract = $rp->valuesArray["abstract_project"];
                    echo <<<PROJECT
                    <div class='research-project'>
                        <h2 class="title-project">$title</h2>   
                        <div class="headline-project">
                            <h3>$headline</h3>
                            <div class="expand-info mas"></div>
                        </div>
                        <div class="contenido-project">
                            <picture>  
                                <img loading="lazy" src="/images/$imagen" alt="project_img">
                            </picture>
                            <p><span>Abstract - </span>$abstract.<br></p>
                        </div>
                    </div>
                    PROJECT;
                endforeach;
            break;

        case "blog":
            foreach ($results as $bg):
                $id = $bg->valuesArray["id"];
                $title = $bg->valuesArray["title_blog"];
                $headline = $bg->valuesArray["headline_blog"];
                $imagen = $bg->valuesArray["imagen_blog"];
                $coauthor = $bg->valuesArray["coauthors_blog"];
                $likes_blog = $bg->valuesArray["likes_blog"];
                $ttr = $bg->valuesArray["ttr_blog"];
                $tempRes = Contributor::findRecord($coauthor);
                $coauthor = $tempRes->valuesArray['name_contributor'];
                if ($coauthor!=="no") {
                    $coauthor = " and " . $coauthor;
                } else {
                    $coauthor = "";
                }

                echo <<<BLOG
                    <div class="enclosed-box blog-entry">
                        <h2>$title</h2>
                        <div class="bar-blog"></div>
                        <div class="entry"> 
                            <div class="head-espaciado">                           
                                <p class="title-entry"><span>Author(s): </span> Abraham Montes $coauthor | 2022</p>
                                <p class="title-entry"><span>Time to read : </span> $ttr min</p>
                                <div class="likes-count full">
                                    <div id="likes-count-child">
                                        <p>$likes_blog</p>
                                    </div>
                                </div>
                            </div>
                            
                            <br>
                            <div class="contenido-entry">
                                <picture>
                                    <img src="/images/$imagen" alt="blog_image">
                                </picture>
                                <p><span>About this article - </span>$headline</p>
                            </div>
                        </div>
                        <div class="contenedor-boton">
                            <a href="/article?an=$id" class="boton">Read</a>
                        </div>
                    </div>
                BLOG;
            endforeach;
            break;

        case "quotes":
            echo "<ul class='quotes'>";
            $counter = 0;
            foreach ($results as $qt):
                $text = $qt->valuesArray["text_quote"];
                $author = $qt->valuesArray["author_quote"];
                $imagen = $qt->valuesArray["imagen_quote"];

                //Adds previous - current -  next classes to the first 3 quotes.
                if ($counter===0) {
                    $sufix = " previous'";
                } elseif ($counter===1) {
                    $sufix = " current'";
                } elseif ($counter===2) {
                    $sufix = " next'";
                } else {
                    $sufix = "'";
                }

                echo "<li class='quote" . $sufix . ">";
                echo <<<QUOTES
                    <div class="quote-image" style="background-image:url(/images/$imagen)">
                    </div>
                    <div class="quote-text">
                        <img src="build/img/quotemark.svg" alt="comma" class="comma">
                        <p>$text <br><br><span> - $author</span></p>
                    </div>
                </li>
                QUOTES;
                $counter += 1;
            endforeach;
            echo "</ul>";
    }
}



function checkAuth() {
    session_start();
    if (!$_SESSION['login']) {
        header('Location: /');
    } 
}


function getInstForm($formType) {
    //Final verification and push
    switch ($formType) {

        case 'project':
            $instance = new Project($_POST);
            break;

        case 'blog':
            $instance = new Blog($_POST);
            break;

        case 'quote':
            $instance = new Quote($_POST);
            break;
        
        case 'publication':
            $instance = new Publication($_POST);
            break;

        case 'degree':
            $instance = new Degree($_POST);
            break;

        case 'contributor':
            $instance = new Contributor($_POST);
            break;

        case 'job':
            $instance = new Job($_POST);
            break;

        case 'award': 
            $instance = new Award($_POST);
            break;
    }
    return $instance;
}


function debugChunk($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function s($text) {
    $s = htmlspecialchars($text);
    return $s;
}


function getInstanceRecord(String $tname, int $rn, array $classList) {
    //Get the class whose table (Active record) corresponds to class passed thru URL:
    foreach($classList as $cl) {
        $buffer = '\Model\\' . $cl;
        if ($buffer::$tn===$tname) break;
    }

    //Finds the record and instantiates:
    $instance   =   $buffer::findRecord($rn);
    return $instance;

}


function validate_redirect(string $url) {
    $tname = filter_var( $_GET['tn'], FILTER_SANITIZE_SPECIAL_CHARS );
    $rn = filter_var( $_GET['rn'], FILTER_VALIDATE_INT );
    if((is_bool($tname) && !$tname) || (is_bool($rn) && !$rn)) {
        header("Location: $url");
    } else {
        return [$tname, $rn];
    } 
}


function getArticleNumber() {
    $an = filter_var( $_GET['an'], FILTER_VALIDATE_INT );
    if(is_bool($an) && !$an)  {
        header("Location: /");
    } else {
        return $an;
    } 
}
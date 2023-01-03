<?php
namespace Controllers;

use function Model\debugChunk;
use function Model\getAllRecords;
use function Model\validate_redirect;
use function Model\getInstanceRecord;
use function Model\getInstForm;
use MVC\Router;
use Model\Publication;
use Model\Contributor;
use Model\Project;
use Model\Quote;
use Model\Job;
use Model\Degree;
use Model\Award;
use Model\Blog;
use Intervention\Image\ImageManagerStatic as Image;

class ProjectController {
    public static function index(Router $router) {

        $responses  = getAllRecords();
        $ins        = $_GET['ins'] ?? NULL;
        $upd        = $_GET['upd'] ?? NULL;
        $dls        = $_GET['dls'] ?? NULL;
        $router->render("projects/admin",[
            'responses'=>$responses,
            'ins'=>$ins,
            'upd'=>$upd,
            'dls'=>$dls
        ]);
    }

    public static function crear(Router $router) {
        $publications = Publication::pullAll();
        $contributors = Contributor::pullAll();
        $instance = NULL;
        $errorMessages = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $instance = getInstForm($_POST['form_name']);
            $errorMessages = $instance->validate_commit("create",$_FILES);
        }        
        if(!$errorMessages) $errorMessages=[];

        $router->render("projects/crear",[
            'contributors'=>$contributors,
            'publications'=>$publications,
            'errorMessages' => $errorMessages,
            'instance'=>$instance
        ]);
    }

    public static function actualizar(Router $router) {
        list($tname, $rn) = validate_redirect('/admin');
        $instance   =   getInstanceRecord($tname, $rn, classList);
        $publications = Publication::pullAll();
        $contributors = Contributor::pullAll();
        $errorMessages = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $instance = $instance->syncUpdate($_POST,$_FILES, $instance);
            $errorMessages = $instance->validate_commit("update",$_FILES, $rn);
        }
        if(!$errorMessages) $errorMessages=[];

        $router->render('/projects/actualizar', [
            'contributors'=>$contributors,
            'publications'=>$publications,
            'errorMessages' => $errorMessages,
            'instance'=>$instance,
            'tname' => $tname,
            'rn'=>$rn
        ]);
    }


    public static function eliminar() {
        if (isset($_GET['di'])) {
            $di = filter_var( $_GET['di'], FILTER_VALIDATE_INT);
            $tn = filter_var($_GET['tn'], FILTER_SANITIZE_SPECIAL_CHARS);
            if (!is_bool($tn) && !is_bool($di)) {   
                $instance   =   getInstanceRecord($tn, $di, classList);
                $instance->eliminateRecord($instance, $di);
            }
        }
    }
}
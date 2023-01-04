<?php
namespace Controllers;

use Model\Job;
use Model\Blog;

use MVC\Router;
use Model\Award;
use Model\Quote;
use Model\Degree;
use Model\Project;
use Model\Publication;
use function Model\debugChunk;

use PHPMailer\PHPMailer\PHPMailer;
use function Model\getArticleNumber;

class PaginasController {
    public static function index( Router $router) {
        
        $projects  = Project::pullAll();
        $publications  = Publication::pullAll();
        $jobs  = Job::pullAll();
        $degrees  = Degree::pullAll();
        $awards  = Award::pullAll();
        $quotes  = Quote::pullAll();
        $blogs  = Blog::pullAll();
        $inicio = true;

        $router->render('paginas/index', [
            'projects'=>$projects,
            'jobs'=>$jobs,
            'degrees'=>$degrees,
            'awards'=>$awards,
            'quotes'=>$quotes,
            'blogs'=>$blogs,
            'publications'=>$publications,
            'inicio'=>$inicio
        ]);
    }    

    public static function curriculum( Router $router) {
        $router->render('paginas/curriculum',[            
        ]);
    }  

    public static function article( Router $router) {
        $artNumber = getArticleNumber();
        $instance = Blog::findRecord($artNumber);
        
        $router->render('paginas/article',[  
            'instance'=>$instance          
        ]);
    }  

    public static function sent(Router $router) {
        $router->render('paginas/sent', []);
    }

    public static function contact( Router $router) {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Create PHPMailer instance:
            $mail = new PHPMailer();
            //Set SMTP: Protocol for mail sending 
            $mail->isSMTP();
            $mail->Host = 'smtp.titan.email';
            $mail->SMTPAuth = true;
            $mail->Username = 'admin@abraham-montes.com';
            $mail->Password = 'TexasUSA2022!';
            $mail->SMTPSecure = 'tls'; //Transport layer security
            //tls replaces SSL (Secure socket layer).
            //Avoids interception of email
            $mail->Port = 465;


            //Set Email Content
            //**** Header */
            $mail->setFrom('admin@abraham-montes.com');
            $mail->addAddress('admin@abraham-montes.com', 'Abraham-Montes.com');
            $mail->Subject = 'New Message from Abraham-Montes.com';
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';


            //**** Content */
            $contenido = '<html> <h2>You have a new Message! </h2><br>';
            $contenido .= '<strong>From: </strong><p>' . $_POST['name'] . '</p><br>';
            $contenido .= '<strong>Email: </strong><p>' . $_POST['email'] . '</p><br>';
            $contenido .= '<strong>Message: </strong><p>' . $_POST['message'] . '</p><br>';
            $contenido .= '</html>';
            $mail->Body = $contenido;

            $contenidoAlt = 'You have a new Message!';
            $contenidoAlt .= ' From: ' . $_POST['name'];
            $contenidoAlt .= ' Email: ' . $_POST['email'];
            $contenidoAlt .= ' Message: ' . $_POST['message'];
            $mail->AltBody = $contenidoAlt;
            
            //Send Mail
            if($mail->send()) {
                header('Location: /sent');
            } 

        }
    }  
}
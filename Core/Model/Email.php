<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 03/10/2016
 * Time: 18:34
 */

namespace Projet\Model;


use PHPMailer;

class Email
{
    private $subject;
    private $body;
    private $sender;
    private $username = "Projet@Projet.org";
    private $password = "Projet2015";
    private $port = 587;
    private $defaultName = "Projet";
    private $server = "smtp.Projet.org";
    private $mail;

    private $template = "Templates/email";
    private $viewPath ="Views/";

    function __construct($content,$email,$subject=" ",$receiverName= " ",$name="Projet"){
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->CharSet = "text/html; charset=UTF-8;";
        $this->mail->SMTPAuth = true;

        $this->mail->SMTPDebug = 0;
        $this->mail->Host = $this->server;
        $this->mail->Port = $this->port;
        $this->mail->Username = $this->username;
        $this->mail->Password = $this->password;
        $this->mail->setFrom($this->username, $name);
        $this->mail->addAddress($email, $receiverName);
        $this->mail->Subject = $subject;
        $template = $this->load('templates.email',compact('content', 'email'));
        $this->mail->Body = $template;
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    }

    public function load($view, $variables = []){
        ob_start();
        extract($variables);
        $page = explode('.',$view);
        require($this->viewPath .ucfirst($page[0]).'/'.$page[1].'.php');
        $content = ob_get_clean();
        return $content;

    }

    public function setFrom($address, $name="Projet"){
        $this->mail->setFrom($address, $name);
    }

    public function setSecure($bool){
        $this->mail->SMTPSecure = $bool;
    }

    public function setTo($address, $name=""){
        $this->mail->addAddress($address, $name);
    }
    public function setSubject($subject=""){
        $this->mail->Subject = $subject;
    }
    public function setBody($body, $datas = []){
        $template = $this->load($body,$datas);
        $this->mail->Body = $template;
    }

    public function send(){
        return $this->mail->send();
    }

}
<?php 

namespace Mail;

class ModelMail {

    public function envoieMail($nom, $mail, $message, $objet = ""){
        $body = $nom." (".$mail.") \n".$message;
        mail("gr8.pufhcm.it@gmail.com",$objet,$body);
    }
}
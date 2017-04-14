<?php

namespace Utilisateur;

class ModelUtilisateur
{
    private $id;
    public $mail;
    private $mdp;
    private $admin;

	public function __construct(){	
        $nbArguments = func_num_args();
        switch($nbArguments)
        {
            case 0: // action du constructeur à 0 paramètre
                break;
			case 4 : //action du constructeur à 7 paramètres
                $this->id = func_get_arg(0);
                $this->mail = func_get_arg(1);
                $this->mdp = func_get_arg(2);
                $this->admin = func_get_arg(3);
                break;
			default:
                echo "erreur constructeur";
                die();
		}	
	}
		
	public function __get($champ)
	{
		if (property_exists($this, $champ))
			return $this->$champ;
	}
		
	public function __set ($champ, $valeur)
	{
		if (property_exists($this, $champ))
			$this->$champ = $valeur;
	}
}
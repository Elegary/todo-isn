<?php 

/**
 * Classe représentative d'un ToDo
 */


class ToDo {

    /**
    * L'ensemble des attributs du ToDo sont privés 
    */

    /** @var string $_title Le titre du ToDo */
    private $_title;

    /** @var string $_details Les détails du ToDo */
    private $_details;

    /** @var string $_expiration La date d'expiration du ToDo au format JJ/MM/YYYY Heure:Minute*/
    private $_expiration;

    /**
     * Construit un objet ToDo depuis les infos
     * @param string $title Le Titre du ToDo
     * @param string $details La description du ToDo
     * @param string $expiration La Date d'échéance au format JJ/MM/YYYY Heure:Minute
     */

    public function __construct($title, $details, $expiration){
        $this->_title = $title;
        $this->_details = $details;
        $this->_expiration = $expiration;
    }

     /**
     * Récupérer le titre du ToDo 
     * @return string Le titre du ToDo
     */

    public function title(){
        return $this->_title;
    }

    
     /**
     * Récupérer les détails du ToDo 
     * @return string Les détails du ToDo
     */

    public function details(){
        return $this->_details;
    }

    /**
    * Récupérer la date d'expiration du ToDo 
    * @return string La date d'expiration du ToDo
    */

    public function expiration(){
        return $this->_expiration;
    }

     /**
     * Méthode privée pour récupérer la date et heure actuelle
     * Non utilisée en production
     * @return string La date au format AAAA-MM-JJ heure:minute:seconde
     */

    private function getDate(){
        return date('Y-m-d H:i:s');
    }



}
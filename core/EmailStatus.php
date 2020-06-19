<?php


/**
 * Classe qui contient des constantes, les différents statuts que peut avoir une clé de confirmation dans la base de données
 */

class EmailStatus {
    
    /** @var int Etat "non vérifié" */
    const UNVERIFIED = 0;

    /** @var int Etat "vérifié" */
    const VERIFIED = 1;

    /** @var int Etat "clé invalide" */
    const INVALID_KEY = 2;
    
}
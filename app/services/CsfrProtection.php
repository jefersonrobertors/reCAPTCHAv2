<?php

declare(strict_types=1);

namespace app\services;

class CsfrProtection {

    public static function show() : void 
    {
        $tokenSessid = bin2hex(random_bytes(32));
        
        global $session;
        $session->setSession('CSFR_TOKEN_SESSID', $tokenSessid);

        echo '<input type=\'hidden\' name=\'_TOKEN\' value=\'' . $tokenSessid . '\' />';
    }

    public static function isValidToken() : bool 
    {
        global $session;

        $isValid = false;
        if($session->getSession('CSFR_TOKEN_SESSID', null) === ($_POST['_TOKEN'] ?? "")) 
        {
            $session->removeSession('CSFR_TOKEN_SESSID');
            $isValid = true;
        }

        return $isValid;
    }
}
?>

<?php

declare(strict_types=1);

namespace app\controllers;

use app\services\CsfrProtection;
use app\utils\Flash;

final class LoginController extends Controller {

    public function main() : void {
        $this->view('login');
    }

    public function deauth() {
        global $session;
        $session->removeSession('auth');
        header('Location: /');
    }

    public function validate() : void {
        if(isset($_POST['g-recaptcha-response'], $_POST['email'], $_POST['password'])) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'secret' => $_ENV['G_RECAPTCHA_SECRET_KEY'],
                'response' => $_POST['g-recaptcha-response'] ?? '',
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]);

            $result = curl_exec($ch);

            curl_close($ch);

            $data = json_decode($result, true);
            $success = (bool) $data['success'] ?? false;

            if(!$success) {
                Flash::create('login', 'Invalid recaptcha', 'error');
                header('Location: /login');
                exit;
            }
            if(CsfrProtection::isValidToken()) {
                $email = strip_tags(trim($_POST['email']));
                $password = strip_tags(trim($_POST['password']));

                if(empty($email)) {
                    Flash::create('login', 'Field email must have a value!', 'error');
                    header('Location: /login');
                    exit;
                }
                if(empty($password)) {
                    Flash::create('login', 'Field password must have a value!', 'error');
                    header('Location: /login');
                    exit;
                }

                echo 'Token is valid';
            }
        }
    }
}
?>

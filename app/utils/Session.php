<?php

declare(strict_types=1);

namespace app\utils;

final class Session {

    public function __construct()
    {
        if(!isset($_SESSION)) session_start();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasSession(string $name) : bool {
        return isset($_SESSION[$name]);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function getSession(string $name, mixed $value = null) : mixed {
        return $this->hasSession($name) ? $_SESSION[$name] : $value;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setSession(string $name, mixed $value) : void {
        if($this->hasSession($name)) {
            $this->getSession($name);
        }
        $_SESSION[$name] = $value;
    }

    /**
     * @param string $name
     * @return void
     */
    public function removeSession(string $name) : void {
        if($this->hasSession($name)) unset($_SESSION[$name]);
    }

    /**
     * @param string $name
     * @return void
     */
    public function removeFlash(string $name) : void {
        if(isset($_SESSION['__flash'][$name])) unset($_SESSION['__flash'][$name]);
    }

    /**
     * @param string $name
     * @param array $data
     * @return void
     */
    public function addFlash(string $name, array $data) : void {
        if(!$this->hasSession('__flash')) {
            $this->setSession('__flash', []);
        }
        $this->removeFlash($name);
        
        $_SESSION['__flash'][$name] = $data;
    }
}
?>
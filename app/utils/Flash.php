<?php

declare(strict_types=1);

namespace app\utils;

final class Flash {

    /**
     * @param string $name
     * @param string $message
     * @param string $type
     * @return void
     */
    public static function create(string $name, string $message, string $type) : void {
        global $session;
        $session->addFlash($name, ['message' => $message, 'type' => $type]);
    }

    /**
     * @param string $name
     * @return void
     */
    public static function display(string $name) : void {
        global $session;
        $data = $session->getSession('__flash', []);
        if(count($data) <= 0 or !isset($data[$name])) {
            return;
        }
        $flash = (array) $data[$name];

        $message = sprintf('<div class=\'alert alert-%s\'>%s</div>', $flash['type'], $flash['message']);
        $session->removeFlash($name);

        echo $message;
    }
}
?>
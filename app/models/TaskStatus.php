<?php
class TaskStatus {
    public const TO_DO = 'To do';
    public const IN_PROGRESS = 'In progress';
    public const DONE = 'Done';

    public static function toString($status) {
        switch ($status) {
            case self::TO_DO:
                return 'To do';
            case self::IN_PROGRESS:
                return 'In progress';
            case self::DONE:
                return 'Done';
            default:
                return $status; // Devuelve el estado sin cambios si no es reconocido
        }
    }

}

// prueba
//$status = new TaskStatus();
//echo TaskStatus::TO_DO;
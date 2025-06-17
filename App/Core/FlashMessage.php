<?php
namespace App\Core;

// session_start();
 
class FlashMessage
{
     public static function set_message(string $type, string $message): void
    {
         $_SESSION['message'] = [
            'type'    => $type,
            'message' => $message
        ];
    }

     public static function get_message(): void
    {
        if (isset($_SESSION['message'])) {
            $type = $_SESSION['message']['type'];
            $text = $_SESSION['message']['message'];

            echo "<div class='text-center'><div class='alert alert-$type'>$text</div></div>";
            unset($_SESSION['message']);  
        }
    }
}

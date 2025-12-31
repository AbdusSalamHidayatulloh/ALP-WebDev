<?php

namespace App\Support;

class ToastMessage {
    public static function resolve(array $toast): string {
        logger("Calling types");
        return match($toast['type']) {
            ToastType::BOARD_ADDED =>
                "You've been added to {$toast['board_name']} by {$toast['actor_name']}",

            ToastType::ROLE_CHANGED =>
                "You've been changed to {$toast['role']} in {$toast['board_name']} by {$toast['actor_name']}",

            ToastType::BOARD_REMOVED =>
                "You've been removed in {$toast['board_name']} by {$toast['actor_name']}",
        };
    }
}
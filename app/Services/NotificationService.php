<?php

namespace App\Services;

use App\Models\User;

class NotificationService
{
    //Función que se encarga de obtener las notificaciones no leídas de un usuario.
    public function getUnreadNotifications(User $user)
    {
        return $user->unreadNotifications;
    }

    //Función que se encarga de marcar como leídas todas las notificaciones de un usuario.
    public function markAllAsRead(User $user)
    {
        $user->unreadNotifications->markAsRead();
    }
}

<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Notification;

class NotificationService
{

public function notify(User $user, $notification)
{

$user->notify($notification);

}

public function notifyRole(string $role, $notification)
{
    $users = User::role($role)->get();
    Notification::send($users, $notification);
}

}
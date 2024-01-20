<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Notifications\RegisteredUserNotification;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $user->notify(new RegisteredUserNotification(user: $user));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $user->notify(new PasswordResetNotification(user: $user, loginUrl: route('v1.login')));
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}

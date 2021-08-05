<?php

namespace App\Repositories;

use App\User;

class SettingsRepository
{
    public function update(User $user, $data)
    {
        $user->settings->is_dark_mode = $data->is_dark_mode;
        $user->settings->enabled_notification = $data->enabled_notification;
        $user->settings->save();
        return $user->settings;
    }
}
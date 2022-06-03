<?php

use Illuminate\Support\Facades\Route;

/*
 * Configurações
 *
 * Prefix: /admin/settings
 */

Route::prefix('')->resource('settings', 'SettingsController', ['only' => ['index']]);

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\SystemSettingsService;

class ThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $settings = new SystemSettingsService();

        $portalTheme = [
            'admin' => $settings->get('theme_admin_color', '#16a34a'),
            'faculty' => $settings->get('theme_faculty_color', '#f59e0b'),
            'student' => $settings->get('theme_student_color', '#7c3aed'),
        ];

        View::share('portalTheme', $portalTheme);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    /**
     * Display the admin settings page.
     */
    public function index()
    {
        return view('admin.settings', [
            'settings' => [
                'site_name' => config('app.name'),
                'contact_email' => config('mail.from.address', 'gerfeljay@gmail.com'),
                'maintenance_mode' => config('app.maintenance_mode', false),
            ]
        ]);
    }

    /**
     * Update site settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'maintenance_mode' => 'nullable|boolean',
        ]);

        // Update .env file
        $this->updateEnvFile([
            'APP_NAME' => $validated['site_name'],
            'ADMIN_CONTACT_EMAIL' => $validated['contact_email'],
            'MAINTENANCE_MODE' => $validated['maintenance_mode'] ? 'true' : 'false',
        ]);

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Update .env file with new values
     */
    private function updateEnvFile($data)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            
            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envFile, $envContent);
    }
} 
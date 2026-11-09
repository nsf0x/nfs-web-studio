<?php

namespace App\View\Composers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class SiteSettingComposer
{
    public function compose(View $view): void
    {
        $settings = SiteSetting::allCached();

        $waNumber  = $settings['whatsapp'] ?? '6288212743260';
        $waMessage = $settings['wa_message'] ?? 'Halo%20NFS%20Web%20Studio,%20saya%20tertarik%20membuat%20website';
        $waLink    = "https://wa.me/{$waNumber}?text={$waMessage}";

        $view->with('siteSettings', $settings)
             ->with('waLink', $waLink)
             ->with('siteName', $settings['brand_name'] ?? 'NFS Web Studio')
             ->with('siteTagline', $settings['tagline'] ?? 'Website Profesional untuk Bisnis Anda')
             ->with('sitePhone', $settings['phone'] ?? '0882-1274-3260')
             ->with('siteEmail', $settings['email'] ?? 'naufalshaflyfawwaz@gmail.com');
    }
}

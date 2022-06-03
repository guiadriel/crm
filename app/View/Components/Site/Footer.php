<?php

namespace App\View\Components\Site;

use App\Models\SiteConfig;
use Illuminate\View\Component;

class Footer extends Component
{
    public $siteconfig;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->siteconfig = SiteConfig::first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.site.footer', ['siteconfig' => $this->siteconfig]);
    }
}

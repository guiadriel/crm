<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SiteConfig;
use Artesaos\SEOTools\Facades\OpenGraph;
use SEO;

class SiteController extends Controller
{
    public $siteConfig;

    public function __construct()
    {
        $this->siteConfig = SiteConfig::first();
    }

    public function index()
    {
        $title = 'Home';
        $description = 'wemirowen owmoqwnei qmeioqi mepqpeoq eoqm oenpwnqpeqw';
        SEO::setTitle($title);
        SEO::setDescription($description);
        OpenGraph::addProperty('type', 'articles');

        return view('site.home');
    }

    public function aboutus()
    {
        return view('site.about-us');
    }

    public function contact()
    {
        return view('site.contact')->with(['siteConfig' => $this->siteConfig]);
    }

    public function courses()
    {
        return view('site.courses');
    }

    public function ie()
    {
        return view('site.ie');
    }

    public function workwithus()
    {
        return view('site.work-with-us')->with(['siteConfig' => $this->siteConfig]);
    }
}

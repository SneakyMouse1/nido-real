<?php

namespace App\Http\Controllers;

use App\Enums\DealType;
use App\Models\City;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function nosotros()
    {
        return view('public.pages.nosotros');
    }

    public function contacto()
    {
        return view('public.pages.contacto');
    }

    public function tarifas()
    {
        return view('public.pages.tarifas');
    }

    public function privacidad()
    {
        return view('public.pages.privacidad');
    }

    public function avisoLegal()
    {
        return view('public.pages.aviso-legal');
    }

    public function cookies()
    {
        return view('public.pages.cookies');
    }

    public function faq()
    {
        return view('public.pages.faq');
    }
}

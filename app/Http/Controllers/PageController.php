<?php

namespace App\Http\Controllers;

use App\Page;

class PageController extends Controller
{
    protected $custom = ['about'];

    /**
     * Display a listing of the resource.
     * @param $path
     * @return \Illuminate\View\View
     */
    public function index($path)
    {
        $page = Page::where('path', '=', $path)
            ->where('locale', '=', app()->locale)
            ->where('onoff', '=', 1)
            ->firstOrFail();

        $blade = 'static';

        if (in_array($path, $this->custom)) {
            $blade = $path;
        }

        return view('pages.' . $blade, compact('page'));
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class Language {

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app        = $app;
        $this->redirector = $redirector;
        $this->request    = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        // Make sure current locale exists.
        $locale = $this->app->getLocale();

        if (!array_key_exists($locale, $this->app->config->get('language.locales'))) {
            $segments   = $request->segments();
            $segments[0] = $this->app->config->get('app.fallback_locale');

            return $this->redirector->to(implode('/', $segments));
        }

        view()->share('locale', app()->getLocale());
        app()->locale = app()->getLocale();

        return $next($request);
    }

}

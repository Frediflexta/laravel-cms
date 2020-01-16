<?php

namespace App\Http\Middleware;

use App\Category;
use Closure;

class VerifyCategoriesExists
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (0 === Category::all()->count()) {
            session()->flash('error', 'You need to create categories first');

            return redirect(route('categories.create'));
        }

        return $next($request);
    }
}

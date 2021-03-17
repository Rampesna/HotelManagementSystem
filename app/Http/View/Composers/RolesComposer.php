<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;

class RolesComposer
{
    /**
     *
     * @var object $companies
     */
    protected $roles;

    public function __construct()
    {
        $this->roles = auth()->user()->roles();
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('roles', $this->roles);
    }
}

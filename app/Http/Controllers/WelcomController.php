<?php

namespace GL\Http\Controllers;

class WelcomController extends Controller
{
    /**
     * Index page for welcome
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }
}

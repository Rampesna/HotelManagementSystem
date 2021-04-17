<?php

namespace App\Http\Controllers\Management\Definition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DefinitionController extends Controller
{
    public function index()
    {
        return view('management.definition.index');
    }
}

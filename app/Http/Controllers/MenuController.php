<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
        public function showMenu()
        {
            $menuData = [];// Logic to fetch menu data;
            return view('layouts.sections.menu.verticalMenu')->with('verticalMenu', $menuData);
        }
}

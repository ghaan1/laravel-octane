<?php

namespace App\View\Components;

use App\Models\MenuGroup;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Navbar extends Component
{
    public $menuGroups;

    public function __construct()
    {
        $this->menuGroups = MenuGroup::with('menuItems.menuItemPermissions', 'permissions')->get();
    }

    public function render()
    {
        return view('backend.parts.sidebar', [
            'menuGroups' => $this->menuGroups,
            'user' => Auth::user()
        ]);
    }
}

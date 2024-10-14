<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Permission;

class MenuGroup extends Model
{
    use HasFactory;
    protected $table = 'menu_group';
    protected $primaryKey = 'id_menu_group';

    protected $fillable = [
        'nama_menu_group',
        'icon_menu_group',
        'id_permission_menu_group',
        'created_at',
        'updated_at',
    ];

    /**
     * Get all of the menuitem for the MenuGroup
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'id_menu_group');
    }

    public function permissions()
    {
        return $this->belongsTo(Permission::class, 'id_permission_menu_group', 'id');
    }
}

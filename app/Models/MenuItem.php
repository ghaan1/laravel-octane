<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = 'menu_item';
    protected $primaryKey = 'id_menu_item';

    protected $fillable = [
        'nama_menu_item',
        'id_menu_group',
        'id_permission_menu_item',
        'list_permission_menu_item',
        'updated_at',
    ];

    /**
     * Get the menugroup that owns the MenuItem.
     */
    public function menugroup(): BelongsTo
    {
        return $this->belongsTo(MenuGroup::class, 'id_menu_group');
    }

    /**
     * Get the permissions associated with the MenuItem.
     */
    public function menuItemPermissions()
    {
        return $this->belongsTo(Permission::class, 'id_permission_menu_item', 'id');
    }

    /**
     * Get the list_permission_menu_item attribute.
     */
    public function getListPermissionMenuItemAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Set the list_permission_menu_item attribute.
     */
    public function setListPermissionMenuItemAttribute($value)
    {
        $this->attributes['list_permission_menu_item'] = json_encode($value);
    }
}
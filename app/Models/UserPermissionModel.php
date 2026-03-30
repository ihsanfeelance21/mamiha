<?php

namespace App\Models;

use CodeIgniter\Model;

class UserPermissionModel extends Model
{
    protected $table = 'user_permissions';
    protected $primaryKey = 'id_perm';
    protected $allowedFields = ['id_user', 'menu_slug'];
}

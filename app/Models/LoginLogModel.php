<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginLogModel extends Model
{
    protected $table = 'login_logs';
    protected $primaryKey = 'id_log';
    protected $allowedFields = ['id_user', 'ip_address', 'user_agent'];
}

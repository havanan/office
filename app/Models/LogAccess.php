<?php
namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class LogAccess extends Model{

    protected $table = 'log_access';
    protected $appends = ['admin'];
    protected $guarded = ['id'];

    public function getAdminAttribute(){
        return $this->getAdmin['name'];
    }
    public function getAdmin() {
    	return $this->hasOne(User::class, 'id', 'admin_id');
    }
}

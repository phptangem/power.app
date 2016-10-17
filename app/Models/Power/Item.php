<?php

namespace App\Models\Power;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'power_item';


    public static function addItemWhere($query, $admin)
    {
        return $query->from('power_role_item')
            ->whereIn('power_role_id', function($query)use($admin){//关联权限
                $query->from('power_role_admin')
                    ->where('admin_id', '=', $admin->getKey())
                    ->select('power_role_id');
            })
            ->whereIn('power_role_id', function($query){//禁用的不能提取
                $query->from('power_role')
                    ->where('status', '=', 'enable')
                    ->select('power_role_id');
            })
            ->select('power_item_id')
            ->distinct();

    }
}

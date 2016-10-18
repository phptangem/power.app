<?php

namespace App\Models\Power;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Entity as Admin;
class Menu extends Model
{
    protected $table = 'power_menu';

    //关联处理
    public function item()
    {
        return $this->hasOne(Item::class, 'power_item_id', 'power_item_id');
    }
    //获取指定人员可用菜单
    public static function userMenus(Admin $admin)
    {
        return self::leftJoin('power_menu_level','power_menu_level.power_menu_id', '=', 'power_menu.power_menu_id')
            ->where('power_menu_level.power_menu_group_id', '=', $admin->menu_group_id)
            ->where(function($query) use($admin){
                $query->orWhere('power_menu.power_item_id', '=', '0')
                    ->orWhereIn('power_menu.power_item_id', function($query)use($admin){
                        Item::addItemWhere($query, $admin);
                    })->orWhereIn('power_menu.power_item_id', function($query){
                        $query->from('power_item')
                            ->where('status', '=', 'enable')
                            ->select('power_item_id');
                    });
            })
            ->with('item')
            ->orderBy('power_menu_level.sort','desc')
            ->get(['power_menu.*', 'power_menu_level.id as level_id','power_menu_level.parent_id']);
    }
}

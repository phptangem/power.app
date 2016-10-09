<?php
namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\Model as Eloquent;
class ModelEdit extends Services
{
    /*
    * 作用:验证处理
    * 参数:$model 要修改的Model对象或类名
    *      $input 要输入的参数，默认全部请求参数
     *     $option 要验证的参数名，默认全部
    * 返回值:bool或array(通过 array可用数据, 不通过false)
    */
    public function validation($model, array $input = [] , array $option = [])
    {

    }

    /*
    * 作用:获取Model的类名
    * 参数:$model Model对象或类名
    *
    * 返回值:string
    */
    public function getModelClass($model)
    {
        if(is_string($model)){
            return $model;
        }elseif($model instanceof Eloquent){
            return get_class($model);
        }else{
            throw new Exception('程序异常');
        }
    }
}
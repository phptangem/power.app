<?php
namespace App\Services;

use Exception,Closure,Validator;
use Illuminate\Database\Eloquent\Model as Eloquent;

use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $modelClass = $this->getModelClass($model);
        $rules = $this->getRules($modelClass);
        if(count($option)){//只修改指定参数
            $_input = array_only($input, $option);
        }else{
            $_input = array($input, array_keys($rules));
            $option = array_keys($rules);
        }
        $onlyRules = array_only($rules, $option);
        if($model instanceof Eloquent && $model->getKey()> 0){
            foreach($onlyRules as $name => &$rule){
                if(is_int(strpos($rule, 'unique:'))){//唯一处理
                    $rule = preg_replace_callback('/unique:\w+(,\w+)?/is',function($matches)use($name,$model){
                        return $matches[0] . (isset($matches[1]) ? '' : ',' . $name) . ',' . $model->getKey() . ',' . $model->getKeyName();
                    },$rule);
                }
            }
        }
        $validator = Validator::make($input, $onlyRules, [], $this->getMessages($modelClass));
        if ($validator->passes()) {//通过处理
            return $_input;
        }
        $unifyMessages = $this->getUnifyMessages($modelClass);
        //示通过的处理异常参数
        foreach ($validator->errors()->toArray() as $field => $message) {
            $this->setError('validator.' . $field, isset($unifyMessages[$field]) ? [$unifyMessages[$field]] : $message);
        }
        return false;
    }
    /*
    * 作用:修改数据
    * 参数:$model 要修改的Model对象或类名
    *      $input 要输入的参数默认全部请求参数
    *      $option 要修改的参数名,默认全部
    *      $before 写入参数数据之前回调处理，用于额外添加修改数据
    *      $after  写入修改数据之后回调处理，用于关联修改处理
    * 返回值:bool (通过true,不通过false)
    */
    public function edit($model, array $input = [], array $option = [], Closure $before = null, Closure $after = null)
    {
        $data = $this->validation($model,$input,$option);
        if($data === false){//验证失败
            return false;
        }
        if($before && $before($data, $this, $model) === false){
            return false;
        }
        //上传处理
        foreach($data as &$item){
            if($item instanceof UploadedFile){
                $item = $this->upload($item);
                if($item === false){//上传失败
                    return false;
                }
            }
        }
        if($model instanceof Eloquent){
            $model->update($data);
        }else{
            $model = $model::create($data);
        }
        if($after && $after($model,$this) === false){
            return false;
        }
        return $model;
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
    /*
    * 作用:获取数据验证规则
    * 参数:$modelClass Model类名
    * 
    * 返回值:array
    */
    public function getRules($modelClass)
    {
        return $this->getModelStaticAttribute($modelClass, '_RULES');
    }

    /*
    * 作用:获取异常说明
    * 参数:$modelClass Model类名
    * 
    * 返回值:array
    */
    public function getMessages($modelClass)
    {
        return  $this->getModelStaticAttribute($modelClass, '_MESSAGES');
    }

    /*
    * 作用:获取统一验证说明(不计较哪个条件失败,统一说明)
    * 参数:$modelClass Model类名
    * 
    * 返回值:array
    */
    public function getUnifyMessages($modelClass)
    {
        return $this->getModelStaticAttribute($modelClass, '_UNIFY_MESSAGES');
    }
    /*
    * 作用:上传处理
    * 参数:$file 上传对象
    * 
    * 返回值:bool str(成功 url 失败false)
    */
    public function upload(UploadedFile $file)
    {
        $urlPath = '/attach/files/'.date('Y/m/d');
        $directory = public_path($urlPath);
        do{
            $name = uniqid(md5(microtime())).$file->getClientOriginalExtension();
        }while(file_exists($directory.DIRECTORY_SEPARATOR.$name));
        if($target = $file->move($directory,$name)){
            return str_replace('\\', '/', Request::getSchemeAndHttpHost().$urlPath.$target->getBasename());
        }

        return $this->setError('upload', $file->getClientOriginalName().'文件上传失败');
    }
    /*
    * 作用:获取Model的静态属性
    * 参数:$modelClass Model类名
    *      $attribute 属性名
    *
    * 返回值:array
    */
    protected function getModelStaticAttribute($modelClass, $attribute)
    {
        if(isset($modelClass::$$attribute)){
            return $modelClass::$$attribute;
        }
        return [];
    }
}
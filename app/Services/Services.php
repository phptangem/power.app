<?php
namespace App\Services;

abstract class Services{
    private $service;
    private $messages = [];

    public function __construct(Services $service = null)
    {
        $this->service = $service;
    }

    //写入异常
    public function setError($key, $value)
    {
        if($this->service){
            $this->service->setError($key, $value);
        }
        array_set($this->messages, $key, $value);
        return false;
    }

    //获取异常
    public function getError($key = null, $default = null)
    {
        return array_get($this->messages, $key, $default);
    }

    //提示处理
    public function prompt($title = null, $info = null, $redirect = null, $timeout = 3)
    {
        if(count($this->messages)){
            $status = 'error';
        }else{
            $status = 'success';
        }
        if(is_null($title)){
            if($status == 'error'){
                $title = '操作失败';
            }else{
                $title = '操作成功';
            }
        }

        if(is_null($info)){
            $info = $status == 'success' ? $title : $this->messageToString($this->messages);
        }
        $message = compact('info', 'title');
        return prompt($message, $status, $redirect, $timeout);
    }

    //异常转为字符串
    private function messageToString($messages)
    {
        $map = [];
        foreach($messages as $message){
            if(is_array($message)){
                $map = array_merge($map, $this->messageToString($message));
            }else{
                array_push($map, $message);
            }
        }

        return $map;
    }
}
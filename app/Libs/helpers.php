<?php
//提示处理
if(!function_exists('prompt')){
    function prompt($message, $status = 'success', $redirect = null, $timeout = 3)
    {
        if(is_string($message)){
            $message = ['info' => $message, 'title' => $message];
        }
        $data = [
            'status' => $status,
            'message' => $message
        ];
        if($redirect == -1){
            $redirect = URL::previous();
            if($status == 'error' && Request::isMethod('post') && !Request::ajax()){
                Request::flash();
            }
        }
        if($redirect){
            $data['redirect'] = $redirect;
            if($timeout > 0 ){
                $data['timeout'] = $timeout;
            }elseif(!Request::ajax()){
                return redirect($redirect);
            }
        }
        if(Request::ajax()){
            return $data;
        }else{
            return view('prompt',$data);
        }
    }
}
if(!function_exists('')){

}
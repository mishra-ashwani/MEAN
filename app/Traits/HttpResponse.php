<?php 

namespace App\Traits;

trait HttpResponse{
    protected function success($data,$message=null,$code=200){
        return response()->json([
            'status'=>'success',
            'response'=>$message,
            'data'=>$data
        ],$code);
    }

    protected function fail($data,$message=null,$code){
        return response()->json([
            'status'=>'fail',
            'response'=>$message,
            'data'=>$data
        ],$code);
    }
}
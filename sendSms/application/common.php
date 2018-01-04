<?php
function show($status,$message){
    $result=[
        'status'=>$status,
        'message'=>$message,
    ];
    exit(json_encode($result));
}
function getSendStatus($data){
    if($data==3){
        echo '发送成功';
    }elseif($data==2){
        echo '发送失败';
    }elseif ($data==1){
        echo '等待回执';
    }
}

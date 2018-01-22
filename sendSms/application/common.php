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
function createRandomStr($length){
    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符
    $strlen = 62;
    while($length > $strlen){
        $str .= $str;
        $strlen += 62;
    }
    $str = str_shuffle($str);
    return substr($str,0,$length);
}
function addToken($arr,$appid,$key){
    ksort($arr);
    $keyy = 'appid' . $appid;
    foreach ($arr as $keys => $value) {
        $keyy .= $keys . $value;
    }
    $keyy .= 'key' . $key;
    $tokens = sha1(md5($keyy));
    return $tokens;
}
function getSign($data){
    if($data==0){
        echo '短信验证码';
    }elseif ($data==1){
        echo '短信通知';
    }elseif ($data==2){
        echo '推广短信';
    }
}






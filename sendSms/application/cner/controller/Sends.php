<?php
namespace app\cner\controller;
class Sends extends Common{
    public function index(){
            $data=array();
            $phone=input('get.phoneNumbers');
            $sendDate=input('get.SendDate');
            if($phone){
                $data['PhoneNum']=$phone;
            }
            if($sendDate){
                $data['SendDate']=intval(strtotime($sendDate));
            }
            $res=model('Searchlog')->getSms($data);
            for($i=0;$i<count($res);$i++){
                $res[$i]['bizup']=$res[$i]['PhoneNum'].','.$res[$i]['SendDate'].','.$res[$i]['BizId'].','.$res[$i]['id'].','.$res[$i]['SendStatus'];
            }
            $this->assign('sms',$res);
            return $this->fetch();
    }
    public function illustrate(){
            return $this->fetch();
    }
    public function delete(){
        $id=input('get.id');
        $res=model('Searchlog')::destroy($id);
        if($res){
            return true;
        }else{
            return show(0,'删除失败');
        }
    }
    public function test(){
        $data=input('post.');
        $validate=validate('Validates');
        if($validate->scene('checkurl')->check($data)){
            $num=input('post.num');
            $key=input('post.key');
            $url=input('post.url');
            $appid=input('post.appid');
            $sign=input('post.sign');
            $TemplateCode=input('post.TemplateCode');
            $param=input('post.param');
            $time=time();
            $arr = array('time' => $time);
            $token=addToken($arr,$appid,$key);
            $url="time=".$time."&num=".$num."&key=".$key."&appid=".$appid."&sign=".$sign."&TemplateCode=".$TemplateCode."&param=".$param."&token=$token"."&url=$url";
            $surl="http://cnereate.xyz/cner/dc/sendSms/index.php/api/Sendsms?".$url;
            $ch = curl_init ();
            curl_setopt ( $ch, CURLOPT_URL, $surl );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
            curl_setopt ( $ch, CURLOPT_POST, 1 ); //启用POST提交
            $file_contents = curl_exec ( $ch );
            return show(1,curl_exec($ch));

            curl_close ( $ch );
        }else{
            return show(0,$this->getError());
        }  
    }
}
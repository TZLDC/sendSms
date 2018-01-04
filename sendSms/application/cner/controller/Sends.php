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
    public function delete(){
        $id=input('get.id');
        $res=model('Searchlog')::destroy($id);
        if($res){
            return true;
        }else{
            return show(0,'删除失败');
        }
    }
}
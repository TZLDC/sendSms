<?php
namespace app\cner\model;
use think\Model;
use traits\model\SoftDelete;
class Searchlog extends Model{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    public function getSms($data){
        $conditions=$data;
        if(isset($data['PhoneNum'])&&$data['PhoneNum']){
            $conditions['PhoneNum']=array('like','%'.$data['PhoneNum'].'%');
        }
        if(isset($data['SendDate'])&&$data['SendDate']){
            date_default_timezone_set('PRC');
            $d=date('Y-m-d',$data['SendDate']);
            $data['SendDate']=strtotime($d);
            $conditions['SendDate']=array('between',[$data['SendDate'],$data['SendDate']+86400]);
        }
        return db('searchlog')->where($conditions)->where('delete_time','eq',0)->order('id desc')->select();
    }
}
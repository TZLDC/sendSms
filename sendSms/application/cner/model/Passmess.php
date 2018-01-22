<?php
namespace app\cner\model;
use think\Model;
use traits\model\SoftDelete;
class Passmess extends Model{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}
<?php
namespace app\api\controller;
use think\Controller;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Core\Config;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Core\Profile\DefaultProfile;
require_once EXTEND_PATH.'Aliyun\vendor\autoload.php';
class Sendsms extends Controller{
    public function __construct($accessKeyId='LTAIKVKJ7ezhvNM9', $accessKeySecret='QefmFIHmqwJI1eJ3fav1PD6VWA9V7w')
    {
        parent::__construct();
        Config::load();
        // 短信API产品名
        $product = "Dysmsapi";
        // 短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";

        // 暂时不支持多Region
        $region = "cn-hangzhou";

        // 服务结点
        $endPointName = "cn-hangzhou";

        // 初始化用户Profile实例
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

        // 增加服务结点
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

        // 初始化AcsClient用于发起请求
        $this->acsClient = new DefaultAcsClient($profile);
    }
    public function index(){
        $url=$_REQUEST['url'];
        $key=$_REQUEST['key'];
        $time=$_REQUEST['time'];
        $signame=$_REQUEST['sign'];
        $tcode=$_REQUEST['TemplateCode'];
        $r=db('passmess')->where('key',$key)->find();
        $s=db('sign')->where('Signame',$signame)->find();
        $t=db('smsmess')->where('TemplateCode',$tcode)->find();
        if($r){
            if($s&&$t){
                if($r['url']==$url){
                $key=$r['key'];
                $appid=$r['appid'];
                $arr = array('time' => $time);
                if(time()-$time<60){
                    $token=addToken($arr,$appid,$key);
                    if(input('get.token')==$token){
                        $errmess=array("VALVE:D_MC"=>"重复过滤",""=>"用户已关机","0"=>"成功","DELIVRD" => "用户短信接收成功","UNDELIVRD" => "空号、停机或关机","MX:0003" => "单个手机号码当天下行条数超过上限","REJECTD" => "短消息因某种原因被拒绝","MX:0012" => "目标号码在客户退订黑名单中","MX:0011" => "目标号码在禁1年黑名单中","BWLIST _006" => "网关黑名单","TE:0003" => "单个手机号码当天下行条数超过上限","TE:0014" => "人工审核不通过","TE:0002" => "向网关提交短信失败","TD:0001" => "网关黑名单","TD:0004" => "疑似钓鱼，请核实","TD:19" => "黑名单号码","TD:18" =>"未知运营商号码","UNDELIV" => "空号、停机或关机","MI:0013" => "停机或关机","MN:0001" => "空号、停机或关机","MK:0012" => "空号","MK:0005" => "该短消息的被叫用户的开户数据的21号增值业务属性是否支持","MK:0000" => "号码为空号","MN:0054" => "空号、停机或关机","MK:0001" => "MK0001是HLR查无此号，短信中心返回状态为无法识别被叫号码。说明用户发送的号码有误","EXPIRED" => "短消息超过有效期","MI:0024" => "停机或关机","MI:0011" => "空号、停机或关机","MC:0151" => "空号、停机或关机","IC:0001" => "停机或关机","MI:0029" => "停机或关机","MI:0005" => "空号、停机或关机","MK:0004" => "停机或关机","MI:0000" => "空号、停机或关机","MI:0022" => "移动网关的内部错误","IA:0054" => "超时未接收到响应消息","MC:0055" => "由于用户不在服务区或内存满导致发送失败","MN:0059" => "空号、停机或关机","MN:0036" => "用户当时不在服务区","MI:0004" => "空号、停机或关机","MI:0020" => "空号、停机或关机","MK:0029" => "暂时无法接通","MI:0084" => "空号、停机或关机","MK:0024" => "下发短消息时，目的手机关机，导致该短消息下发失败。","MK00001" => "手机终端是空号","MI:0017" => "空号、停机或关机","MK:0015" => "下发短消息时，手机在接收过程出现软件问题。例如，手机重启后，处理短消息部分软件没有初始化完成，此时无法正常处理短消息。","MN:0029" => "空号、停机或关机","IC:0151" => "空号、停机或关机","MN:0075" => "运营商内部错误","MK:0010" => "暂时无法接通","IC:0015" => "运营商内部错误","BEYONDN" => "运营商内部错误","MI:0055" => "空号、停机或关机","MI:0010" => "号码已失效","MC00151" => "运营商内部错误","IC:0055" => "运营商内部错误","MB:1078" => "运营商内部错误","MN00001" => "运营商内部错误","ID:0013" => "运营商内部错误","MC:0001" => "未知错误","MK:0017" => "手机内存满。","MI:0081" => "运营商内部错误","DA:0054" => "超时未接收到响应消息","MB:1042" => "SMC内存中缓存的、要下发给被叫用户的短消息数超过了该用户的最大下发数。","ERR_NUM" => "被叫号码不正确或被限制","MI:0054" => "空号、停机或关机","MK:0011" => "停机或关机","MN:0052" => "运营商内部错误","MK:0008" => "用户当前所在地区信号不好，无法接收短消息。","IA:0073" => "运营商内部错误","IA:0051" => "运营商内部错误","MK:0075" => "空号、停机或关机","MN:0022" => "空号、停机或关机","MN:0020" => "移动网关的内部错误","MI00029" => "运营商内部错误","MI:0008" => "移动网关的内部错误","MI:0012" => "非法设备","MN:0012" => "空号、停机或关机","MI:0059" => "空号、停机或关机","MN:0050" => "空号、停机或关机","MN:0017" => "短消息被拒绝","MI:0045" => "移动网关的内部错误","MN:0055" => "运营商内部错误","NOROUTE" => "查找路由失败","MI:0036" => "移动网关的内部错误","MB:1077" => "黑名单，用户在移动公司有恶意投诉记录","MK:0020" => "运营商内部错误","MK:0022" => "运营商内部错误","MN:0053" => "运营商内部错误","DB:0505" => "运营商内部错误","ID:0070" => "运营商内部错误","MX:0002" => "向上级通道提交短信失败","DB:0141" => "曾多次投诉移动或者工信部的黑名单","MA:0051" => "运营商内部错误","IB:0008" => "运营商内部错误","MI00000" => "消息在短信中心过期","DB:0164" => "运营商黑名单","MK:0013" => "空号","DB:0144" => "用户在全局黑名单中","BWLIST" => "网关黑名单","HD:19" => "网关黑名单","MI00020" => "短信下发手机终端失败ErrorinMS","MI:0041" => "运营商内部错误","MC:0055_006" => "由于用户不在服务区或内存满导致发送失败","MI:0064" => "运营商内部错误","ERR_NUM_006" => "被叫号码不正确或被限制","MI:0057" => "运营商内部错误","MI:0056" => "响应超时","MN:0098" => "运营商内部错误","MK:0036" => "来自MSC的未知错误。","MN:0019" => "运营商内部错误","MI:0030" => "运营商内部错误","MI:0023" => "运营商内部错误","MI:0002" => "运营商内部错误","MK:0019" => "MS不支持短消息终呼业务","IB:0064" => "关机","MB:1026" =>"SMC的相关运行参数（如MO速度、MT速度、短消息数、短消息实体数）已经达到了License的最大限制。","MK:0055" => "运营商内部错误","MK:0066" => "运营商内部错误","MI00022" => "手机终端内存满","IB:0009" => "运营商内部错误","MK:0006" => "运营商内部错误","MK:0053" => "运营商内部错误","MK:0023" => "运营商内部错误","MK:0045" => "运营商内部错误","MC:0055_000" => "由于用户不在服务区或内存满导致发送失败","MA:0054" => "运营商内部错误","MK:0041" => "运营商内部错误","MK:0063" => "运营商内部错误","ID:0012" => "计费地址错误","MK:0084" => "HLR返回收到未预期响应","MB:0088" => "运营商内部错误","MI00036" => "运营商内部错误","DB00144" => "目的号码在全局黑名单被拦截","MI:0099" => "vmsc返回收到未预期响应","MI:0089" => "运营商内部错误","MI:0063" => "运营商内部错误","MI:0090" => "vmsc返回远端地址不可达","MN00013" => "机终端停机","DB:0107" => "运营商内部错误","IB:0255" => "运营商内部错误","MA:0022" => "运营商内部错误","IB:0013" => "运营商内部错误","MA:0001" => "运营商内部错误","MK:0065" => "GIW超时无应答","MN:0009" => "运营商内部错误","UNKNOWN" =>"未知的短消息状态","DB:0010" => "运营商内部错误","MK:0021" => "运营商内部错误","MI:0038" =>"运营商内部错误","MI:0052" => "漫游限制","MK:0003" => "非法用户。本次短消息发送过程中，用户鉴权未通过，可能的原因是MSC认为该手机的鉴权密码非法。在维测台中的错误值为3。在ETSI GSM 0902协议中定义为9。","MK:0009" => "用户不在服务区MWDSET。","MK:0051" => "运营商内部错误","MK:0068" => "运营商内部错误","DB:0106" => "服务代码错误","MB:1031" => "短信中心回的，超出最大发送次数 可能是手机满了。","MI:0048" => "运营商内部错误","MK00011" => "手机终端没有短信业务","MK:0048" => "运营商内部错误","MK:0056" => "运营商内部错误","MK:0057" => "运营商内部错误","MK:0088" => "vmsc返回潜在的版本不匹配","TUIDING" => "运营商黑名单","HIGRISK" => "运营商黑名单","CA:0054" => "移动内部错误","MN:0041" => "当前手机处于关机、无法接通等异常状态","MK:0090" => "当前手机状态处于停机、暂时无法接通等异常状态","XL:169" => "手机号码为空号或不存在","MN:xxxx" => "M开头的移动错误代码是指Mobile，大多是因为手机端问题导致。原因有：关机，停机，信号弱，不在服务区，无效号码等等。","MK:xxxx" => "M开头的移动错误代码是指Mobile，大多是因为手机端问题导致。原因有：关机，停机，信号弱，不在服务区，无效号码等等。","MI:xxxx" => "M开头的移动错误代码是指Mobile，大多是因为手机端问题导致。原因有：关机，停机，信号弱，不在服务区，无效号码等等。","TA:169" => "空号","TC:0001" => "黑名单号码","TC:0007" => "短信内容涉及敏感词","12" => "计费地址错(空号、关机、停机、通话被限制或者转到联通秘书)","1" => "空号、号码不存在","10" => "Src_ID错(空号、关机、停机、通话被限制或者转到联通秘书)","24" => "计费号码无效（用户不在使用）","5" => "号码已停机","29" => "手机用户信息错误","13" => "业务代码未分配，根据MT话单里的接入号和业务代码找不到对应的申报项","93" => "月租鉴权失败（用户已经停机或销户）","11" => "运营商内部错误","4" => "手机关机","54" => "用户已关机","59" => "运营商内部错误","15" => "号码不在服务区","23" => "运营商内部错误","27" => "手机不支持短消息","W-BLACK" => "号码为全局黑名单","17" => "运营商内部错误","51" => "用户已关机","-37" => "用户已关机","20" => "暂时停机","55" => "号码不在服务区","67" => "号码是空号","95" => "鉴权失败因为用户销户或不存在","22" => "运营商内部错误","90" => "运营商内部错误","-74" => "运营商内部错误","2" => "运营商内部错误","104" => "运营商内部错误","86" => "号码不在服务区","50" => "停机","8" => "信息长度错","57" => "运营商内部错误","79" => "内存满","53" => "用户已关机","3" => "运营商内部错误","61" => "号码是空号","45" => "号码停机","14" => "运营商内部错误","9" => "非法序列号，包括序列号重复、序列号格式错误等","69" => "黑名单用户","89" => "号码不在服务区","64" => "号码不在服务区","88" => "号码不在服务区","98" => "暂时停机","18" => "用户未订购","36" => "号码停机","44" => "手机无短信功能","99" => "暂时停机","43" => "内存满","-43" => "内存满","118" => "手机无短信功能","52" =>"手机终端无短信接收功能","31" => "非法设备","75" => "号码限制","56" => "欠费停机","106" => "非法费用，鉴权失败","-1" => "运营商内部错误","19" => "用户未订购","148" => "运营商内部错误","48" => "运营商内部错误","63" => "运营商内部错误","73" => "运营商内部错误","70" => "号码不在服务区","32" => "运营商内部错误","40" => "运营商内部错误","110" => "运营商内部错误","116" => "运营商内部错误","21" => "运营商内部错误","219" => "用户手机终端处于关机、停机、暂时无法接听等不正常状态导致手机无法接收到短信","182" => "用户手机终端已暂停服务","124" => "用户手机终端处于关机、通话被限制、暂停服务等异常状态","101" => "手机号码为空号","105" => "当前手机状态处于停机、暂停服务、呼入被限制等异常情况","213" => "当前手机状态处于停机、暂停服务、呼入被限制等异常情况","72" => "145号段空号或者不存在","LT:0002" => "因信号原因导致联通失败。若批量失败则有可能是内容敏感词导致，需和运营商确认","UNDELIV_601" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_602" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_640" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","REJECTD_006" => "短消息因为某种原因被拒绝","UNDELIV_705" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_760" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_601" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_869" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_602" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_614" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_660" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_702" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_640" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","REJECTD_706" => "短消息因为某种原因被拒绝","EXPIRED_615" => "短消息因为某种原因被拒绝","UNDELIV_870" => "运营商内部错误","UNDELIV_702" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_815" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_771" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_711" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_627" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_814" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_660" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_612" => "运营商内部错误","UNDELIV_613" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_619" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_680" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_636" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_726" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_718" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_880" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_634" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_010" => "短消息超过有效期","EXPIRED_619" => "短消息超过有效期","EXPIRED_999" => "短消息超过有效期","UNDELIV_001" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","UNDELIV_620" => "用户因为状态不正确如处于停机、挂起等状态而导致用户无法接收到短信","EXPIRED_614" => "运营商内部错误","EXPIRED_618" => "运营商内部错误","EXPIRED_613" => "运营商内部错误","EXPIRED_617" => "运营商内部错误","UNDELIV_701" => "空号、停机或关机","UNDELIV_802" => "空号、停机或关机","UNDELIV_801" => "空号、停机或关机","MOBILE BLACK" => "号码为全局黑名单","其他" => "运营商未公布原因");
                        if (isset($_REQUEST['num'])) {
                            $res=db('searchlog')->where('PhoneNum',$_REQUEST['num'])->order('id desc')->find();
                            $ti=strtotime("now");
                            $phoneNumbers = $_REQUEST['num'];
                            $ar=$_REQUEST['param'];
                            $SignName=$signame;
                            $TemplateCode = $tcode;
                            if($ti-$res['SendDate']>60||!$res){
                                $response = $this->sendSms(
                                    $SignName, // 短信签名
                                    $TemplateCode, // 短信模板编号
                                    $phoneNumbers,// 短信接收者
                                    json_decode($ar,true)
                                );
                                date_default_timezone_set('PRC');//设定时区,注意代码位置
                                $sendDate=date('Ymd');
                                $response=json_decode(json_encode($response),TRUE);//原来$response是stdClass格式的，不能push元素进去
                                time_sleep_until(time()+10);
                                $query = $this->queryDetails($phoneNumbers,$sendDate,10,1);
                                $slog=json_decode(json_encode($query),TRUE);
                                $slog=$slog['SmsSendDetailDTOs']['SmsSendDetailDTO'][0];
                                date_default_timezone_set('PRC');
                                if(array_key_exists('ReceiveDate',$slog) ==false){
                                    $slog['ReceiveDate']='1979-1-1 0:0:0';
                                }
                                $tim=strtotime($slog['SendDate']);
                                $rtim=strtotime($slog['ReceiveDate']);
                                if($errmess[$slog['ErrCode']]!=''){$slog['ErrCode']=$errmess[$slog['ErrCode']];}
                                $data=[
                                    'SendDate'=>$tim,
                                    'SendStatus'=>$slog['SendStatus'],
                                    'ReceiveDate'=>$rtim,
                                    'ErrCode'=>$slog['ErrCode'],
                                    'TemplateCode'=>$TemplateCode,
                                    'Content'=>str_replace("\'","'",$slog['Content']),
                                    'PhoneNum'=>$phoneNumbers,
                                    'BizId'=>$response['BizId'],
                                    'code'=>$ar,
                                    'appid'=>$appid,
                                ];
                                db('searchlog')->insert($data);
                                $arr=[
                                    'message'=>$response['Message'],
                                    'code'=>$ar,
                                ];
                                return json_encode($arr);
                            }else{
                                $sres=db('searchlog')->where('PhoneNum',$phoneNumbers)->order('SendDate','desc')->find();
                                $time=input('get.time');
                                if($time-$sres['SendDate']<60){
                                    $arr=[
                                        'message'=>'OK',
                                        'code'=>$sres['code'],
                                    ];
                                    return json_encode($arr);
                                }
                            }
                        }
                        else echo '电话号码参数不能为空';
                    }else{
                        return $this->fetch('error');
                    }
                }else{
                    return '请求超时';
                }
             }else{
                return '网站匹配';
             }
            }
            else{
                return '参数错误';
            }
        }else{
            return '权限不够';
        }

    }
     
    /**
     * 发送短信范例
     *
     * @param string $signName <p>
     * 必填, 短信签名，应严格"签名名称"填写，参考：<a href="https://dysms.console.aliyun.com/dysms.htm#/sign">短信签名页</a>
     * </p>
     * @param string $templateCode <p>
     * 必填, 短信模板Code，应严格按"模板CODE"填写, 参考：<a href="https://dysms.console.aliyun.com/dysms.htm#/template">短信模板页</a>
     * (e.g. SMS_0001)
     * </p>
     * @param string $phoneNumbers 必填, 短信接收号码 (e.g. 12345678901)
     * @param array|null $templateParam <p>
     * 选填, 假如模板中存在变量需要替换则为必填项 (e.g. Array("code"=>"12345", "product"=>"阿里通信"))
     * </p>
     * @param string|null $outId [optional] 选填, 发送短信流水号 (e.g. 1234)
     * @return stdClass
     */

    public function sendSms($signName, $templateCode, $phoneNumbers, $templateParam, $outId=null) {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置雉短信接收号码
        $request->setPhoneNumbers($phoneNumbers);

        // 必填，设置签名名称
        $request->setSignName($signName);

        // 必填，设置模板CODE
        $request->setTemplateCode($templateCode);

        // 可选，设置模板参数
        if($templateParam) {
            $request->setTemplateParam(json_encode($templateParam));
        }

        // 可选，设置流水号
        if($outId) {
            $request->setOutId($outId);
        }

        // 发起访问请求
        $acsResponse = $this->acsClient->getAcsResponse($request);

        // 打印请求结果
        // var_dump($acsResponse);

        return $acsResponse;

    }

    /**
     * 查询短信发送情况范例
     *
     * @param string $phoneNumbers 必填, 短信接收号码 (e.g. 12345678901)
     * @param string $sendDate 必填，短信发送日期，格式Ymd，支持近30天记录查询 (e.g. 20170710)
     * @param int $pageSize 必填，分页大小
     * @param int $currentPage 必填，当前页码
     * @param string $bizId 选填，短信发送流水号 (e.g. abc123)
     * @return stdClass
     */
    public function queryDetails($phoneNumbers, $sendDate, $pageSize = 10, $currentPage = 1, $bizId=null) {

        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();

        // 必填，短信接收号码
        $request->setPhoneNumber($phoneNumbers);

        // 选填，短信发送流水号
        $request->setBizId($bizId);

        // 必填，短信发送日期，支持近30天记录查询，格式Ymd
        $request->setSendDate($sendDate);

        // 必填，分页大小
        $request->setPageSize($pageSize);

        // 必填，当前页码
        $request->setCurrentPage($currentPage);

        // 发起访问请求
        $acsResponse = $this->acsClient->getAcsResponse($request);

        // 打印请求结果
        // var_dump($acsResponse);

        return $acsResponse;
    }
}
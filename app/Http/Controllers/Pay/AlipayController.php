<?php

namespace App\Http\Controllers\Pay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;

class AlipayController extends Controller
{

    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath = './key/priv.key';
    public $aliPubKey = './key/ali_pub.key';

    public function __construct()
    {
        $this->app_id = env('PAT_ID');
        $this->gate_way = env('PAY_WAY');
        $this->notify_url = env('NOTIFY_PAY_URL');
        $this->return_url = env('RETURN_PAY_URL');


    }

    public function payList($o_id)
    {
        //验证订单状态 是否已支付 是否是有效订单
        $order_info = OrderModel::where(['o_id'=>$o_id])->first()->toArray();

//判断订单是否已被支付
        if($order_info['is_pay']==1){
            header('refresh:2,url=/orderList');
            die("订单已支付，请勿重复支付");
        }
//判断订单是否已被删除
        if($order_info['is_delete']==1){
            header('refresh:2,url=/orderList');
            die("订单已被删除，无法支付");
        }



//业务参数
        $bizcont = [
            'subject'           => 'Lening-Order: ' .$o_id,
            'out_trade_no'      => $o_id,
            'total_amount'      => $order_info['o_amount'] / 100,
            'product_code'      => 'QUICK_WAP_WAY',

        ];

//公共参数
        $data = [
            'app_id'   => $this->app_id,
            'method'   => 'alipay.trade.wap.pay',
            'format'   => 'JSON',
            'charset'   => 'utf-8',
            'sign_type'   => 'RSA2',
            'timestamp'   => date('Y-m-d H:i:s'),
            'version'   => '1.0',
            'notify_url'   => $this->notify_url,        //异步通知地址
            'return_url'   => $this->return_url,        // 同步通知地址
            'biz_content'   => json_encode($bizcont),
        ];

//签名
        $sign = $this->rsaSign($data);
        $data['sign'] = $sign;
        $param_str = '?';
        foreach($data as $k=>$v){
            $param_str .= $k.'='.urlencode($v) . '&';
        }

        $url = rtrim($param_str,'&');
        $url = $this->gate_way . $url;
        header("Location:".$url);

    }

    public function rsaSign($params)
    {
        return $this->sign($this->getSignContent($params));
    }

    protected function sign($data)
    {

        $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
        $res = openssl_get_privatekey($priKey);

        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);

        if (!$this->checkEmpty($this->rsaPrivateKeyFilePath)) {
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }


    public function getSignContent($params)
    {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    protected function checkEmpty($value)
    {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }


    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset)
    {

        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }


        return $data;
    }

    /**
     * 同步
     */
     public function sync()
     {
         header('Refresh:2;url=/orderList');
         echo "订单： ".$_GET['out_trade_no'] . ' 支付成功，正在跳转';

     }

    /**
     * 支付宝异步通知
     */
    public function async()
    {

       $data = json_encode($_POST);
    $log_str = '>>>> ' . date('Y-m-d H:i:s') . $data . "<<<<\n\n";
        //记录日志
        //$json = '{"gmt_create":"2019-01-17 08:46:48","charset":"utf-8","seller_email":"tdxtdh9861@sandbox.com","subject":"Lening-Order: 46","sign":"kynTq+CZPX6YnYcNWpzL1wvID\/LDkFJ0XvDzVmxLurO\/bt0grJzb5p+\/OhySTHDsgpZZ272b\/6oTvSJzr3Z9lOpfZnuL2S4Jw20Zaq0W4mzjjk\/U\/LPvOHirG\/\/eJWKtBO4LLFxYAsuYptLkQtfWeQOKxGKN87TWoIJ8ybGBZA8gwueZMjRjNcPEhycKHnxlv2ZRN628dvP1AY\/MGPtekSDVlE5yhwyqx57F+6YkvZSncBHS1abtQRNOTjhCnzGcGB72a7YJdqZEPlqwAt2trOVMdVda\/mlEMoTj9+tikRlPhbpFdCgCQ9P+dme6q0ki29taRro7FCdBRrcRg62lIg==","buyer_id":"2088102177054717","invoice_amount":"30.00","notify_id":"a094c173ce9e58a20b09ccc51c93970lhd","fund_bill_list":"[{\"amount\":\"30.00\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","notify_type":"trade_status_sync","trade_status":"TRADE_SUCCESS","receipt_amount":"30.00","app_id":"2016091900549956","buyer_pay_amount":"30.00","sign_type":"RSA2","seller_id":"2088102176376944","gmt_payment":"2019-01-17 08:46:49","notify_time":"2019-01-17 08:46:50","version":"1.0","out_trade_no":"46","total_amount":"30.00","trade_no":"2019011722001454710500672019","auth_app_id":"2016091900549956","buyer_logon_id":"abr***@sandbox.com","point_amount":"0.00"}';
      // $_POST = json_decode($json , true);
      file_put_contents('logs/alipay.log', $log_str, FILE_APPEND);
        //验签
        $res = $this->verify($_POST);
        $log_str = '>>>> ' . date('Y-m-d H:i:s');
        if($res === false){
            //记录日志 验签失败
            $log_str .= " Sign Failed!<<<<< \n\n";
            file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
        }else{
            $log_str .= " Sign OK!<<<<< \n\n";
            file_put_contents('logs/alipay.log',$log_str,FILE_APPEND);
        }

        //验证订单交易状态
        if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
            //更新订单状态
            $o_id = $_POST['out_trade_no'];     //商户订单号
            $info = [
                'is_pay' => 1,       //支付状态  0未支付 1已支付
                'pay_amount' => $_POST['total_amount'] * 100,    //支付金额
                'pay_ctime' => strtotime($_POST['gmt_payment']), //支付时间
                'o_name' => $_POST['trade_no'],      //支付宝订单号
                'plat' => 1,      //平台编号 1支付宝 2微信
            ];

            OrderModel::where(['o_id' => $o_id])->update($info);
        }
        //处理订单逻辑
        $this->dealOrder($_POST);

        echo 'success';
    }
    /**
     * 处理订单逻辑 更新订单 支付状态 更新订单支付金额 支付时间
     * @param $data
     */
    public function dealOrder($data)
    {


        //加积分

        //减库存
    }

    //验签
    function verify($params)
    {
        $sign = $params['sign'];
        $params['sign_type'] = null;
        $params['sign'] = null;

        //读取公钥文件
        $pubKey = file_get_contents($this->aliPubKey);
        $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        //转换为openssl格式密钥

        $res = openssl_get_publickey($pubKey);
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

        //调用openssl内置方法验签，返回bool值

        $result = (openssl_verify($this->getSignContent($params), base64_decode($sign), $res, OPENSSL_ALGO_SHA256) === 1);
        openssl_free_key($res);

        return $result;
    }


}



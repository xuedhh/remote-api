<?php
namespace App\Console\Commands\Open;

use GuzzleHttp\Client;
use Illuminate\Console\Command;


class RequestNio extends Command
{
    protected $signature = 'request_nio';

    const REQUEST_NIO_URL = "http://app.nio.com/c/award_cn/checkin";

    public function handle()
    {
       $result = self::requestApi(self::REQUEST_NIO_URL,"post",[], ['event' => "checkin"]);
       print_r($result);die;
    }

    /**
     * 保存Http链接
     *
     * @var object
     */
    private static $_oClient = null;

    /**
     * Api请求客户端标识
     *
     * @var string
     */
    private static $_sUserAgent = 'NextevCar/5.20.5 (iPhone; iOS 17.0.3; Scale/3.00)';

    /**
     * 获取Http链接
     *
     * @return \GuzzleHttp\Client
     */
    private static function _getClient()
    {
        if (self::$_oClient == null) {
            self::$_oClient = new Client();
        }
        return self::$_oClient;
    }


    private static function  requestApi($p_sUri, $p_sMethod, $p_aQuery, $p_aRawPost)
    {
        $oClient = self::_getClient();
        $sUrl =  $p_sUri;
        $aOptions = [
            'headers' => [
                'User-Agent' => self::$_sUserAgent,
                'Accept-Encoding' => 'gzip',
//                'Content-Type' => 'application/json'
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Host' => 'app.nio.com',
                'Accept' => '*/*',
                'Connection' => 'keep-alive',
                'Accept-Language' => 'zh-Hans-CN;q=1',
                'kkgx2gpc' => 'Bp4rRFDjIanU2-cRxQfyI1GlQNIxpQbJZDTrojfOpYni4NXJrYw4LbRXKI-yVgYcAVgxUDIA_kHZ1k3YSpIGtguON8j56xo-Hge5Y2zx663cv9mdMZScOgz3EcF1ZAJ97U-9zlgtMisgld1tyGS_00cfukten4G_zuwrn1v..4mk1dehYX0aT52TKuZMbnjqBQ0bvYWqXFH50C7kyCQASw0HRlr6xBND0uqFPW8dSzNIzR6FdU4i47Fv7N6D7Nk3kG-jN5PXBazPcAjJwRe6fRAtNkXfI1oCXXKVN_iT6lgHojzNuEqyXLYgHncWCuWBGX7PEOmg1FIrpM276J7PBd1MtOU4Z8-HLqcRxfRhjqUYSXIfI5Ffypntww4pw_qAqcb6mWyS0MePs_ygahyBuaOF7N120gN94oTYEBWomtsryyCf2PkJzat_BL3jxji_zm_7WUpdbhfn39YabnTL3eivkvSTUTV0TDuds1DGRoeIoKc0hgwbMoUnqCtb9-Plb2qK2dIx0bWYV8hUCYQveHhFjexSCx4tNKHVi7uCB2skJLtnF9xlphOhfgmiS-s7GaWrXLONuc32P-0XawtwYTT-DmpykI5llMDMw6vJZae7KhtSothoUOMKFZ8ldbMh7yc7JCAP_pGEMH_tejvYrFeiiwmLZ1v9p8bfnYzi7MUNpgxDKWegS5tWGDkUgvEk8I7M4j1pO9hmJAx5bItVBgoqGDqGTNz12_uybNzGZwzOcmv0nTEMMmBialcsfjIMoX9fokvtKzDmF..1R2U25QP',
                'Authorization' => 'Bearer 2.0aOgNfRj5N/VtKs4WNzicXRjxPOZT0SUcA78UmvaLc0Q=',
            ],
            'connect_timeout' => 5,
            'timeout' => 5
        ];
//        if (!empty($p_aQuery)) {
            $p_aQuery = [
                'app_id' => 10002,
                'app_ver' => "5.20.5",
                'device_id' => 'e1669d177f7446b88ac78380ce11db61',
                'lang' => "zh-cn",
                'region' => 'cn',
                'timestamp' => '1698806031',
                'sign' => '30f556144500abdc7b891fccb37c6cf3',
            ];
            $aOptions['query'] = $p_aQuery;
//        }
        if (!empty($p_aRawPost)) {
            $aOptions['body'] = json_encode($p_aRawPost);
        }
        try {
            $oResponse = $oClient->request($p_sMethod, $sUrl, $aOptions);
            dd($oResponse);die;
            $aResult = json_decode($oResponse->getBody(), true);
            var_dump($aResult);die;
            if ($aResult) { // 调用成功
               return $aResult;
//                return self::returnRow($aResult);
            } else { // 调用失败
//                return self::returnLogicError('required',Error::TYPE_UNKNOWN_ERROR,'','',Error::buildToast('返回值为空或者其他错误'));
            }
        } catch (\Exception $oEx) {
            print_r($oEx->getMessage());die;
//            self::logException(__CLASS__, __FUNCTION__, $oEx);
//            return self::returnSystemError();
        }
    }

//    public static function sendFeishuRequest($p_sWebhookUrl, $p_sBuildMsgFunc = '', $p_aParams = [])
//    {
//        $aParams = call_user_func(self::class . "::" . $p_sBuildMsgFunc, $p_aParams);
//        $aRes = self::postRequest($p_sWebhookUrl, $aParams);
//        return [
//            'iStatus' => self::$_RESPONSE_STATUS_SUCCESS,
//            'mData' => $aRes
//        ];
//    }

    public static function postRequest($url, $data)
    {
        $iTryCount = 0;
        Request:
        $iTryCount++;
        $data = json_encode($data);
        $headerArray = array("Content-type:application/json;charset='utf-8'", "Accept:application/json");
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        //将返回的json对象解码成数组对象并返回
        $output = json_decode($output, true);
        // 如果命中频控了，重试一下
        if (isset($output['code']) && $output['code'] == 11247 && $iTryCount < 3) {
            sleep(1);
            goto Request;
        }
        return $output;
    }

}

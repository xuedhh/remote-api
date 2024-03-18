<?php

namespace App\Http\Controllers\Service\Biz\Validate;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class ValidateRe
{


    /**
     * 获取数据的方式-get
     *
     * @var string
     */
    const REQUEST_GET = 'get';

    /**
     * 获取数据的方式-post
     *
     * @var string
     */
    const REQUEST_POST = 'post';


    /**
     * 返回状态-成功
     *
     * @var int
     */
    private static $_RESPONSE_STATUS_SUCCESS = 1;

    /**
     * 返回状态-失败
     *
     * @var int
     */
    private static $_RESPONSE_STATUS_FAIL = 0;

    /**
     * 错误类型-验证错误
     *
     * @var string
     */
    private static $_RESPONSE_ERROR_TYPE_VALIDATION = 'Validation';

    /**
     * 获取参数
     *
     * @param array $p_aParamRules
     *            参数验证规则
     * @param string $p_sMethod
     *            获取参数的方式
     *
     * @return array
     */
    public static function getParams(array $p_aParamRules, $p_sMethod = self::REQUEST_GET)
    {
        $oRequest = Request::instance();
        switch ($p_sMethod) {
            case self::REQUEST_GET:
                $aParams = $oRequest->query->all();
                break;
            case self::REQUEST_POST:
                $aParams = $oRequest->request->all();
                break;
        }
        return self::validate($aParams, $p_aParamRules);
    }

    /**
     * 数据校验
     *
     * @param array $data
     *            待校验的数据
     * @param array $rules
     *            校验规则
     * @param array $messages
     *            自定义message
     * @param array $customAttributes
     *            自定义属性
     *
     * @return array
     */
    public static function validate(array $data = [], array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $oValidator = app(ValidationFactory::class);

        if (func_num_args() === 0) {
            return $oValidator;
        }
//        * @method static \Illuminate\Contracts\Validation\Validator make(array $data, array $rules, array $messages = [], array $customAttributes = [])


        $oValidator = $oValidator->make($data, $rules, $messages, $customAttributes);
        if ($oValidator->fails()) {
            return self::returnValidError(self::getValidateErrors($oValidator));
        } else {
            echo 111;die;
            return self::returnRow(array_intersect_key($oValidator->valid(), $rules));
        }
    }


    /**
     * 获取校验错误信息
     *
     * @param Validator $o_oValidator
     *            实例话后的校验器
     *
     * @return array
     */
    protected static function getValidateErrors($o_oValidator)
    {
        $oErrors = $o_oValidator->errors()->toArray();
        $aData = $o_oValidator->getData();
        $aErrors = [];
        foreach ($oErrors as $sKey => $aErrorMessages) {
            foreach ($aErrorMessages as $sErrorMessage) {
                $mValue = Arr::get($aData, $sKey);
                $aErrors[$sKey][] = self::_transferErrorMessage($sErrorMessage, $sKey, $mValue);
            }
        }
        return $aErrors;
    }

    /**
     * 格式化单条错误信息
     *
     * @param string $p_sMessage
     *            文本消息
     * @param null $p_sKey
     *            字段key
     * @param null $p_mValue
     *            字段值
     *
     * @return mixed
     */
    private static function _transferErrorMessage(string $p_sMessage, string $p_sKey = null, $p_mValue = null)
    {
        $mError = $p_sMessage;
        print_r($mError);die;
        if (is_string($mError)) {
            try {
                $mError = json_decode($mError, true);
                if ($mError === null) {
                    $mError = $p_sMessage;
                } else {
                    $mError['sField'] = $p_sKey ?? $mError['sField'];
                    if (! empty($p_mValue)) {
                        $mError['mValue'] = $p_mValue;
                    } else {
                        $mError['mValue'] = '';
                    }
                }
            } catch (\Exception $exception) {
                $mError = $p_sMessage;
            }
        }
        return $mError;
    }

    /**
     * 返回验证错误
     *
     * @param array $p_aError
     *            验证错误对象
     *
     * @return array
     */
    static function returnValidError($p_aError)
    {
        return [
            'iStatus' => self::$_RESPONSE_STATUS_FAIL,
            'sType' => self::$_RESPONSE_ERROR_TYPE_VALIDATION,
            'aError' => $p_aError
        ];
    }


}

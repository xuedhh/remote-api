<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\Biz\Validate\ValidateRe;
use App\Http\Requests\StoreBlogPost;


class SeoData extends Controller
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


    protected $validate;

    public function __construct(ValidateRe $validate)
    {
         $this->validate = $validate;
    }

    public function getItemDetailData()
    {
        // 调用Java的接口


//        echo 9991238182481;
        $aRules = array(
            'code' => 'string|required',
            'mobile' => 'int|required',
            'country_num' => 'int',
            'data' => 'array|required'
        );
        $validate = new ValidateRe();
        $aRes = $this->validate->getParams($aRules, self::REQUEST_POST);
        print_r($aRes);die;
        if ($aRes['iStatus'] == 0) {
            return $aRes;
        }


    }


}

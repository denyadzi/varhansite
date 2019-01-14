<?php

namespace app\components;

use Yii;
use Facebook\Facebook as BaseFacebook;
use Facebook\Exceptions\FacebookSDKException;

class Facebook extends \yii\base\BaseObject
{
    /** @var string */
    public $appId;

    /** @var string */
    public $appSecret;

    /** @var string */
    public $accessToken;

    /** @var string */
    public $graphVersion = 'v3.2';

    /** @var Facebook */
    private $_fb;

    public function init()
    {
        try {
            $this->_fb = new BaseFacebook([
                'app_id' => $this->appId,
                'app_secret' => $this->appSecret,
                'default_graph_version' => $this->graphVersion,
                'default_access_token' => $this->accessToken,
            ]);
        } catch (FacebookSDKException $e) {
            Yii::warning('Facebook component not configured');    
        }
    }

    /**
     * @throws Facebook\Exceptions\FacebookResponseException
     * @throws Facebook\Exceptions\FacebookSDKException
     */
    public function get($url)
    {
        if ( ! $this->_fb) {
            throw new FacebookSDKException('SDK not configured');
        }
        
        return $this->_fb->get($url);
    }
}

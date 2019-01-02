<?php

namespace app\blocks;

use Yii;
use app\views\Constants;
use luya\helpers\Html;
use luya\Hook;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;
use app\blocks\StaticBackgroundBlock;

/**
 * Header Background Block.
 *
 * File has been created with `block/create` command. 
 */
class HeaderBackgroundBlock extends StaticBackgroundBlock
{
    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    public function init()
    {
        Hook::on(Constants::HOOK_HEADER_BG_IMAGE, [$this, 'getImageUrl']);
        
        parent::init();
    }
    
    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return ProjectGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return Yii::t('blocks/header-background', 'name');
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'perm_media'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                [
                    'var' => 'image',
                    'label' => Yii::t('blocks/header-background', 'label_image'),
                    'type' => self::TYPE_IMAGEUPLOAD,
                    'filter' => false,
                ],
            ],
        ];
    }
}

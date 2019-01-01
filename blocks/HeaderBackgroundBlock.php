<?php

namespace app\blocks;

use Yii;
use app\views\Constants;
use luya\helpers\Html;
use luya\Hook;
use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * Header Background Block.
 *
 * File has been created with `block/create` command. 
 */
class HeaderBackgroundBlock extends PhpBlock
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
        return 'extension'; // see the list of icons on: https://design.google.com/icons/
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

    public function getImageUrl($hook)
    {
        $selected = $this->getVarValue('image');
        if ( ! $selected) return '';

        $image = Yii::$app->storage->getImage($selected);
        return $image->source;
    }
    
    /**
     * {@inheritDoc} 
     *
    */
    public function admin()
    {
        $selected = $this->getVarValue('image');
        $content = '';
        if ($selected) {
            $image = Yii::$app->storage->getImage($selected);
            $content = Html::tag('div', '', [
                'style' => [
                    'background-image' => "url({$image->source})",
                    'background-size' => 'cover',
                    'height' => '300px',
                ]]);
        } else {
            $content = Yii::t('blocks/header-background', 'empty');
        }
        return Html::tag('h5', $this->name(), ['class' => 'mb-3']) . $content;
    }
}

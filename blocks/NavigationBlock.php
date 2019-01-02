<?php

namespace app\blocks;

use Yii;
use luya\helpers\Html;
use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * Navigation Block.
 *
 * File has been created with `block/create` command. 
 */
class NavigationBlock extends PhpBlock
{
    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

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
        return Yii::t('blocks/navigation', 'name');
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'menu'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
        ];
    }
    
    /**
     * {@inheritDoc} 
     *
    */
    public function admin()
    {
        return Html::tag('h5', $this->name(), ['class' => 'mb-3']);
    }
}

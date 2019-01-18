<?php

namespace app\blocks;

use Yii;
use luya\helpers\Html;
use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;
use app\traits\FbAlbumsCommand;

/**
 * Fb Albums Block.
 *
 * File has been created with `block/create` command. 
 */
class FbAlbumsBlock extends PhpBlock
{
    use FbAlbumsCommand;
    
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
        return Yii::t('blocks/fb-albums', 'name');
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'burst_mode'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                [
                    'var' => 'albums',
                    'label' => Yii::t('blocks/fb-albums', 'label_albums'),
                    'type' => self::TYPE_CHECKBOX_ARRAY,
                    'options' => [
                        'items' => $this->getCachedAlbumsSelection(),
                    ],
                ],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'gallery_data' => $this->getGalleryData()
        ];
    }

    private function getGalleryData()
    {
        $photos = $this->getCachedPhotos();
        if (empty ($photos)) return [];
        
        $galleryData = [];
        $selectedAlbums = $this->getVarValue('albums', []);
        foreach ($selectedAlbums as $selection) {
            $albumId = $selection['value'];
            $albumData = $photos[$albumId] ?? null;
            if ( ! $albumData) {
                continue;
            }
            $galleryData[$albumId] = $albumData;
        }
        return $galleryData;
    }
    
    /**
     * {@inheritDoc} 
     *
    */
    public function admin()
    {
        $content = Html::tag('h5', $this->name(), ['class' => 'mb-3']);

        $gallery = $this->getGalleryData();
        if (empty ($gallery)) {
            $content .= Html::tag('p', Yii::t('blocks/fb-albums', 'empty'));
            return $content;
        }

        $row = '';
        foreach ($gallery as $id => $album) {
            $image = Html::tag('div', '', [
                'style' => "background-image: url('{$album['cover_photo']['picture']}');"
                . "width:100%;"
                . "height:100px;"
                . "margin: 5px 0;"
                . "background-size: cover",
            ]);
            $row .= Html::tag('div', $image, [
                'class' => 'col col-12 col-lg-4 col-xl-3 col-xxl-2',
            ]);
        }
        $content = Html::tag('div',
                             Html::tag('div', $row, ['class' => 'row']),
                             ['class' => 'container']);
        return $content;
    }
}

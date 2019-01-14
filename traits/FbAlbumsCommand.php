<?php

namespace app\traits;

use Yii;

trait FbAlbumsCommand
{
    /** @var string */
    private $_cachePrefix = 'fb-album-';

    private function getCached($subkey, $default = null)
    {
        $val = Yii::$app->longCache->get($this->_cachePrefix . $subkey);
        return $val ?: $default;
    }

    private function setCached($subkey, $data) {
        Yii::$app->longCache->set($this->_cachePrefix . $subkey, $data);
    }

    private function getCachedAlbumsSelection()
    {
        return $this->getCached('albums-selection', []);
    }

    private function setCachedAlbumsSelection(array $data)
    {
        $this->setCached('albums-selection', $data);
    }

    private function getCachedPhotos()
    {
        return $this->getCached('photos', []);
    }

    private function setCachedPhotos(array $photos)
    {
        return $this->setCached('photos', $photos);
    }
}

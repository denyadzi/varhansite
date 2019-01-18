<?php

namespace app\commands;

use Yii;
use yii\helpers\ArrayHelper;
use Facebook\Exceptions\FacebookSDKException;
use app\traits\FbAlbumsCommand;

class FbAlbumsController extends \luya\console\Command
{
    use FbAlbumsCommand;
    
    public function actionIndex()
    {
        $albumsSelection = $this->getCachedAlbumsSelection();
        $photos = $this->getCachedPhotos();
        var_dump ($photos);
    }

    public function actionFetch()
    {
        $albumsSelection = $this->fetchAlbumSelection();
        if (empty ($albumsSelection)) {
            $this->outputError('Smth went wrong, no albums selection');
            return;
        } else {
            $this->setCachedAlbumsSelection($albumsSelection);
        }
        
        $photos = $this->fetchPhotos(array_map (function($a){return $a['value'];}, $albumsSelection));
        if (empty ($photos)) {
            $this->outputError('Smth went wrong, no photos');
            return;
        } else {
            $this->setCachedPhotos($photos);
        }
        $this->outputSuccess('Fetched facebook photos successfully');
    }

    private function fetchAlbumSelection()
    {
        $selection = [];
        try {
            $r = Yii::$app->fb->get('/me/albums');
        } catch (FacebookSDKException $e) {
            $this->outputError($e->getMessage());
            return;
        }
        $albums = $r->getGraphEdge('GraphAlbum');
        foreach ($albums as $album) {
            $selection[] = [
                'value' => $album->getId(),
                'label' => $album->getName(),
            ];
        }
        return $selection;
    }

    private function fetchPhotos(array $albums)
    {
        $photos = [];
        foreach ($albums as $albumId) {
            try {
                $r = Yii::$app->fb->get("/$albumId?fields=photos{name,picture,images},cover_photo{name,picture,images}");
            } catch (FacebookSDKException $e) {
                $this->outputError($e->getMessage());
                return;
            }
            $album = $r->getGraphAlbum();
            $coverGr = $album->getField('cover_photo');
            $coverImages = $coverGr->getField('images')->all();
            $presets = $this->fetchImagePresets($coverImages);            
            $coverPhotoData = ArrayHelper::merge([
                'picture' => $coverGr->getField('picture'),
                'name' => $coverGr->getField('name'),
            ], $presets);
            $albumData = [
                'cover_photo' => $coverPhotoData,
                'photos' => [],
            ];
            foreach ($album->getField('photos') as $photo) {
                if ($photo->getField('id') == $coverGr->getField('id')) {
                    continue;
                }
                $images = $photo->getField('images')->all();
                $presets = $this->fetchImagePresets($images);
                $albumData['photos'][] = ArrayHelper::merge([
                    'picture' => $photo->getField('picture'),
                    'name' => $photo->getField('name'),
                ], $presets);
            }

            $photos[$albumId] = $albumData;
        }
        return $photos;
    }

    private function fetchImagePresets($variants)
    {
        $presets = [
            'preview' => '',
            'source' => '',
        ];
        if ( ! is_array ($variants) || empty ($variants)) return $presets;
        
        $presets['source'] = $this->selectImageVariant($variants, 600, 1200);

        $smallestPreview = $this->selectImageVariant($variants, 0, 300);
        $optimalPreview = $this->selectImageVariant($variants, 300, 600);
        $presets['preview'] = $optimalPreview ?: $smallestPreview;

        return $presets;
    }

    private function selectImageVariant(array $variants, $minWidth, $maxWidth = null)
    {
        usort ($variants, function($a, $b) {
            $aW = $a->getField('width');
            $bW = $b->getField('width');
            if ($aW == $bW) return 0;
            return $aW > $bW ? -1 : 1;
        });
        while ($imageGr = array_shift ($variants)) {
            $imageWidth = $imageGr->getField('width');
            $minOk = $maxOk = false;
            if ($imageWidth >= $minWidth) {
                $minOk = true;
            }
            if (is_null ($maxWidth)) {
                $maxOk = true;
            } else if ($imageWidth <= $maxWidth) {
                $maxOk = true;
            }
            if ($minOk && $maxOk) {
                return $imageGr->getField('source');
            }
        }
        return '';
    }
}

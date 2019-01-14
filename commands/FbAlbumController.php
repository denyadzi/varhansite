<?php

namespace app\commands;

use Yii;
use Facebook\Exceptions\FacebookSDKException;
use app\traits\FbAlbumsCommand;

class FbAlbumController extends \luya\console\Command
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
        $albumsSelection = $this->getCachedAlbumsSelection();
        if ( ! $albumsSelection) {
            $albumsSelection = $this->fetchAlbumSelection();
        }
        if (empty ($albumsSelection)) {
            $this->outputError('Smth went wrong, no albums selection');
            return;
        } else {
            $this->setCachedAlbumsSelection($albumsSelection);
        }
        
        $photos = $this->getCachedPhotos();
        if ( ! $photos) {
            $photos = $this->fetchPhotos(array_map (function($a){return $a['value'];}, $albumsSelection));
        }
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
            $sourceCoverImageGr = is_array ($coverImages) ? array_shift ($coverImages) : null;
            $coverPhotoData = [
                'picture' => $coverGr->getField('picture'),
                'source' => $sourceCoverImageGr ? $sourceCoverImageGr->getField('source') : '',
                'name' => $coverGr->getField('name'),
            ];
            $albumData = [
                'cover_photo' => $coverPhotoData,
                'photos' => [],
            ];
            foreach ($album->getField('photos') as $photo) {
                if ($photo->getField('id') == $coverGr->getField('id')) {
                    continue;
                }
                $images = $photo->getField('images')->all();
                $sourceImageGr = is_array ($images) ? array_shift ($images) : null;
                $albumData['photos'][] = [
                    'source' => $sourceImageGr ? $sourceImageGr->getField('source') : '',
                    'picture' => $photo->getField('picture'),
                    'name' => $photo->getField('name'),
                ];
            }
            $photos[$albumId] = $albumData;
        }
        return $photos;
    }
}

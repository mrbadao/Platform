<?php

class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$albums = yii::app()->PicasaWeb->getPicasaAlbumsList();

        if(!isset($albums['hasError'])){
            foreach($albums as $album){
                echo "AlbumID: " .$album->getAlbumId().'<br/>';
                $albumFeed = yii::app()->PicasaWeb->getGalleryInAlbum($album->getAlbumId());
                foreach($albumFeed as $photoEntry){
                    echo "\tPhotoID: " . $photoEntry->getGphotoId()->getText() . "<br />\n";
                }
            }
        }
//        die;
		$this->render('index');
	}

    public function actionTest(){
        $photo = null;
        $picasaWebExt = yii::app()->PicasaWeb;
        if(isset($_FILES['object'])){
            $object = $_FILES['object'];
            $object['caption'] ='this is test upload img to picasa';
            $object['photoTags'] = array('test', 'hellios', 'strong');
            $result = $picasaWebExt->uploadPhoto('6151193467630717649', $object);
            if(!is_array($result)){
                $contentUrl = $result->getMediaGroup()->getContent();
                $photo = array(
                    'titile' => $result->getTitle()->getText(),
                    'src'   => $contentUrl[0]->getUrl(),
                    'caption' => $result->getSummary()->getText(),
                );
            }
        }
        $this->render('test', compact('photo'));
    }

    public function actionPhoto(){
        $picasaWebExt = yii::app()->PicasaWeb;
        var_dump($picasaWebExt->deletePhoto('6151193467630717649', '6151209812049941378'));
    }
}
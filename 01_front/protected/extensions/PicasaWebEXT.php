<?php

class PicasaWebEXT extends CApplicationComponent
{
    const ZendGdataPathAlias = 'application.vendors.Zend';

    private $username;
    private $pass;
    private $gp;

    function init()
    {
        require_once Yii::getPathOfAlias(self::ZendGdataPathAlias) . '/Loader.php';
        Zend_Loader::loadClass('Zend_Gdata_Photos');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        Zend_Loader::loadClass('Zend_Gdata_AuthSub');

        $this->username = "hieunc18@gmail.com";
        $this->pass = "077812660109";

        $client = Zend_Gdata_ClientLogin::getHttpClient($this->username, $this->pass, Zend_Gdata_Photos::AUTH_SERVICE_NAME);
        $this->gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");
    }

    /**
     * @description retrieving all album
     * @return array
     */
    public function getPicasaAlbumsList()
    {
        $error = array('hasError' => false);
        $albums = array();

        try {
            $albums = $this->gp->getUserFeed("default");
            foreach($albums as $a) var_dump($a->getId());
        } catch (Zend_Gdata_App_HttpException $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();

            if ($e->getResponse() != null) {
                $error['body'] = $e->getResponse()->getBody();
            }
        } catch (Zend_Gdata_App_Exception $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();
        }
        return $error['hasError'] ? $error : $albums;
    }


    /**
     * Add new album
     *
     * @param $album
     * @return array
     */
    public function addNewAlbum($album)
    {
        if (!is_array($album) || !isset($album['title']) || !isset($album['sumary'])) {
            return array('hasError' => true, 'msg' => 'Input empty');
        }

        $entry = new Zend_Gdata_Photos_AlbumEntry();
        $entry->setTitle($this->gp->newTitle($album['title']));
        $entry->setSummary($this->gp->newSummary($album['sumary']));

        $error = array('hasError' => false);
        $albumEntry = array();

        try {
            $albumEntry = $this->gp->insertAlbumEntry($entry);
        } catch (Zend_Gdata_App_HttpException $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();

            if ($e->getResponse() != null) {
                $error['body'] = $e->getResponse()->getBody();
            }
        } catch (Zend_Gdata_App_Exception $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();
        }
        return $error['hasError'] ? $error : $albumEntry;

    }


    /**
     * @param $albumId
     * @param null $type
     * @return array
     */
    public function getGalleryInAlbum($albumId, $type = null)
    {
        $query = $this->gp->newAlbumQuery();
        $query->setAlbumId($albumId);
        $query->setUser("default");

        if ($type != null) $query->setKind($type);

        $error = array('hasError' => false);
        $albumFeed = array();

        try {
            $albumFeed = $this->gp->getAlbumFeed($query);
        } catch (Zend_Gdata_App_HttpException $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();

            if ($e->getResponse() != null) {
                $error['body'] = $e->getResponse()->getBody();
            }
        } catch (Zend_Gdata_App_Exception $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();
        }
        return $error['hasError'] ? $error : $albumFeed;
    }

    public function getPhoto($albumId, $photoId){
        $error = array('hasError' => false);
        if(!$photoId || !$photoId){
            return array('hasError' => true, 'msg' => 'No id found.');
        }
        $query = $this->gp->newPhotoQuery();
        $query->setAlbumId($albumId);
        $query->setPhotoId($photoId);
        $query->setImgMax("d");

        try {
            $photoEntry = $this->gp->getPhotoEntry($query);
        } catch (Zend_Gdata_App_Exception $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();
        }

        return $error['hasError'] ? $error : $photoEntry;
    }


    /**
     * @param null $albumId
     * @param $photo array()
     * @return Photo upload
     */
    public function uploadPhoto($albumId = null, $photo)
    {
        $error = array('hasError' => false);
        if($albumId == null || !is_array($photo) || !isset($photo['name']) || $photo['name'] == null){
            return array('hasError' => true, 'msg' => 'Input empty');
        }

        // We use the albumId of 'default' to indicate that we'd like to upload
        // this photo into the 'drop box'.  This drop box album is automatically
        // created if it does not already exist.

        $fd = $this->gp->newMediaFileSource($photo['tmp_name']);
        $fd->setContentType($photo['type']);

        // Create a PhotoEntry
        $photoEntry = $this->gp->newPhotoEntry();

        $photoEntry->setMediaSource($fd);

        $photoEntry->setTitle($this->gp->newTitle($photo['name']));

        if(isset($photo['caption']) || $photo['caption'] != null) {
            $photoEntry->setSummary($this->gp->newSummary($photo['caption']));
        }

        // add some tags
        if(isset($photo['photoTags']) && is_array($photo['photoTags']) && !empty($photo['photoTags'])) {
            $photoEntry->mediaGroup = new Zend_Gdata_Media_Extension_MediaGroup();
            foreach($photo['photoTags'] as $photoTag) {
                $keywords = new Zend_Gdata_Media_Extension_MediaKeywords();
                $keywords->setText($photoTag);
                $photoEntry->mediaGroup->keywords = $keywords;
            }
        }

        // We use the AlbumQuery class to generate the URL for the album
        $albumQuery = $this->gp->newAlbumQuery();

        $albumQuery->setUser('default');
        $albumQuery->setAlbumId($albumId);

        // We insert the photo, and the server returns the entry representing
        // that photo after it is uploaded

        try {
            $photoEntry = $this->gp->insertPhotoEntry($photoEntry, $albumQuery->getQueryUrl());
        } catch (Zend_Gdata_App_HttpException $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();

            if ($e->getResponse() != null) {
                $error['body'] = $e->getResponse()->getBody();
            }
        } catch (Zend_Gdata_App_Exception $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();
        }
        return $error['hasError'] ? $error : $photoEntry;
    }

    /**
     * @description deletePhoto
     * @param $albumId
     * @param $photoId
     * @return array|bool
     */
    public function deletePhoto($albumId, $photoId){
        $error = array('hasError' => false);
        if(!$photoId || !$photoId){
            return array('hasError' => true, 'msg' => 'No id found.');
        }
        $photoEntry = self::getPhoto($albumId, $photoId);

        if(is_array($photoEntry) && isset($photoEntry['hasError']) && $photoEntry['hasError']) return $photoEntry;

        try {
            $photoEntry->delete();
        } catch (Zend_Gdata_App_Exception $e) {
            $error['hasError'] = true;
            $error['msg'] = $e->getMessage();
        }
        return !$error['hasError'];
    }

    /**
     * @description update photo
     * @param $albumId
     * @param $photoId
     * @throws \Zend_Exception
     */
    public function updatePhoto($albumId, $photoId){
        Zend_Loader::loadClass('Zend_Gdata_Media_Extension_MediaKeywords');
        Zend_Loader::loadClass('Zend_Gdata_Geo_Extension_GeoRssWhere');
        Zend_Loader::loadClass('Zend_Gdata_Geo_Extension_GmlPos');
        Zend_Loader::loadClass('Zend_Gdata_Geo_Extension_GmlPoint');
        $insertedEntry = null;
        $insertedEntry->title->text = "New Photo";
        $insertedEntry->summary->text = "Photo caption";

        $keywords = new Zend_Gdata_Media_Extension_MediaKeywords();
        $keywords->setText("foo, bar, baz");
        $insertedEntry->mediaGroup->keywords = $keywords;

        $updatedEntry = $insertedEntry->save();
    }
}

<?php

require_once ROOT_PATH . 'lib/utils/str_to_unicode.php';
require_once ROOT_PATH . 'lib/utils/json_encode_safe.php';

/**
 * Skeleton subclass for representing a row from the 'chart' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.datawrapper
 */
class Chart extends BaseChart {

    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false) {
        $arr = parent::toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, $includeForeignObjects);
        // unset($arr['Deleted']);  // we don't use this, since we never transmit deleted charts
        //unset($arr['DeletedAt']);
        return $arr;
    }

    public function shortArray() {
        $arr = $this->toArray();
        unset($arr['Metadata']);
        unset($arr['CreatedAt']);
        unset($arr['LastModifiedAt']);
        unset($arr['AuthorId']);
        unset($arr['ShowInGallery']);
        return $this->lowercaseKeys($arr);
    }

    public function usePrint() {
        $this->usePrintVersion = true;

        $meta = $this->getMetadata();
        if (!isset($meta['print'])) {
            // copy web chart for print
            $meta['print'] = $meta;
            $meta['print']['describe']['title'] = parent::getTitle();

            $this->setMetadata(json_encode($meta, JSON_UNESCAPED_UNICODE));
            $this->save();
        }
    }

    /**
     * this function converts the chart
     */
    public function serialize() {
        $json = $this->toArray();
        unset($json['Deleted']);
        unset($json['DeletedAt']);
        // at first we lowercase the keys
        $json = $this->lowercaseKeys($json);

        $json['metadata'] = $this->getMetadata();

        if (isset($this->usePrintVersion) && $this->usePrintVersion) {
            $json['metadata'] = $json['metadata']['print'];
        } else {
            unset($json['metadata']['print']);
        }

        if ($this->getUser()) $json['author'] = $this->getUser()->serialize();
        return $json;
    }

    public function toStruct($public = false) {
        $chart = $this->serialize();
        if ($public) {
            // remove any sensitive user data
            unset($chart['author']);
        }
        return $chart;
    }

    public function toJSON($public = false) {
        return trim(addslashes(json_encode($this->toStruct($public), JSON_UNESCAPED_UNICODE)));
    }

    public function unserialize($json) {
        // bad payload?
        if (!is_array($json)) return false;

        if (isset($this->usePrintVersion) && $this->usePrintVersion) {
            if (isset($json['metadata'])) {
                $json['metadata']['describe']['title'] = $json['title'];
            }

            $json['title'] = parent::getTitle();
        }

        if (array_key_exists('metadata', $json)) {
            if (isset($this->usePrintVersion) && $this->usePrintVersion) {
                $m = $this->getMetadata();
                $m['print'] = $json['metadata'];
                $json['metadata'] = json_encode($m, JSON_UNESCAPED_UNICODE);
            } else {
                // encode metadata as json string … if there IS metadata
                $m = $this->getMetadata();
                if (isset($m['print'])) { $json['metadata']['print'] = $m['print']; }
                $json['metadata'] = json_encode($json['metadata'], JSON_UNESCAPED_UNICODE);
            }
        }

        // then we upperkeys the keys
        $json = $this->uppercaseKeys($json);
        // finally we ignore changes to some protected fields
        $json['CreatedAt'] = $this->getCreatedAt();
        $json['AuthorId'] = $this->getAuthorId();
        $json['Deleted'] = $this->getDeleted();
        $json['DeletedAt'] = $this->getDeletedAt();
        $json['InFolder'] = $this->getInFolder();
        // and update the chart
        $this->fromArray($json);
        $this->save();
        return true;
    }

    public function preSave(PropelPDO $con = null) {
        if ($this->isModified()) {
            $this->setLastModifiedAt(time());

            $user = DatawrapperSession::getUser();
            if ($user->getRole() != UserPeer::ROLE_GUEST) {
                Action::logAction(DatawrapperSession::getUser(), 'chart/edit', $this->getId());
            }
        }
        return true;
    }

    protected function lowercaseKeys($arr, $lower=true) {
        foreach ($arr as $key => $value) {
            $lkey = $key;
            $lkey[0] = $lower ? strtolower($key[0]) : strtoupper($key[0]);
            $arr[$lkey] = $value;
            unset($arr[$key]);
        }
        return $arr;
    }

    /**
     *
     */
    protected function uppercaseKeys($arr) {
        return $this->lowercaseKeys($arr, false);
    }

    /**
     * get the path where this charts data file is stored
     */
    public function getDataPath() {
        $path = chart_publish_directory() . 'data/' . $this->getCreatedAt('Ym');
        return $path;
    }

    public function getStaticPath() {
        $path = chart_publish_directory() . 'static/' . $this->getID();
        return $path;
    }

    public function getRelativeDataPath() {
        $path = 'data/' . $this->getCreatedAt('Ym');
        return $path;
    }

    public function getRelativeStaticPath() {
        $path = 'static/' . $this->getID();
        return $path;
    }

    /**
     * get the filename of this charts data file, which is usually
     * just the chart id + csv extension
     */
    protected function getDataFilename() {
        return $this->getId() . '.csv';
    }

    /**
     * writes raw csv data to the file system store
     *
     * @param csvdata  raw csv data string
     */
    public function writeData($csvdata) {
        $cfg = $GLOBALS['dw_config'];

        if (isset($cfg['charts-s3'])
          && isset($cfg['charts-s3']['write'])
          && $cfg['charts-s3']['write'] == true) {

            $config = $cfg['charts-s3'];

            $filename = 's3://' . $cfg['charts-s3']['bucket'] . '/' .
                $this->getRelativeDataPath() . '/' . $this->getDataFilename();

            file_put_contents($filename, $csvdata);
        } else {
            $path = $this->getDataPath();

            if (!file_exists($path)) {
                mkdir($path, 0775);
            }

            $filename = $path . '/' . $this->getDataFilename();

            file_put_contents($filename, $csvdata);
        }
        $this->setLastModifiedAt(time());
        return $filename;
    }

    /**
     * load data from file sytem
     */
    public function loadData() {
        $config = $GLOBALS['dw_config'];

        if (isset($config['charts-s3']) &&
            $config['charts-s3']['read']) {

            $s3url = 's3://' . $config['charts-s3']['bucket'] . '/' .
              $this->getRelativeDataPath() . '/' .$this->getDataFilename();

            try {
                return file_get_contents($s3url);
            } catch (Exception $ex) {
                return '';
            }
        } else {
            $filename = $this->getDataPath() . '/' . $this->getDataFilename();
            if (!file_exists($filename)) {
                return '';
            } else {
                return file_get_contents($filename);
            }
        }
    }

    public function refreshExternalData() {
        $url = $this->getExternalData();
        if (!empty($url)) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 5,
            ]);
            $new_data = curl_exec($ch);
            // check encoding of data
            $new_data = str_to_unicode($new_data);
            if (!empty($new_data)) $this->writeData($new_data);
        }
    }

    /*
     * checks if a user has the privilege to access the chart
     */
    public function isReadable($user) {
        if ($user->isLoggedIn()) {
            $org = $this->getOrganization();
            if ($this->getAuthorId() == $user->getId() ||
                $user->isAdmin() ||
                (!empty($org) && $org->hasUser($user))) {
                return true;
            }
        } else if ($this->getGuestSession() == session_id()) {
            return true;
        }
        return $this->isPublic();
    }

    /*
     * checks if a user has the privilege to change the data in a chart
     */
    public function isDataWritable($user) {
        return $this->isWritable($user) && !$this->getIsFork();
    }

    /*
     * checks if a chart is forkable
     */
    public function isForkable() {
        return $this->getForkable() && !$this->getIsFork();
    }

    /**
     * checks if a chart is writeable by a user
     *
     * @param user
     */
    public function isWritable($user) {
        if ($user->isLoggedIn()) {
            $org = $this->getOrganization();
            // chart is writable if...
                // this user is the chart author
            if ($this->getAuthorId() == $user->getId()
                // the user is a graphics editor and in the same organization
                || (!empty($org) && $org->hasUser($user))
                // or the user is an admin
                || $user->isAdmin()) {
                return true;
            } else {
                return false;
            }
        } else {
            // check if the session matches
            if ($this->getGuestSession() == session_id()) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * returns the chart meta data
     */
    public function getMetadata($key = null) {
        if (isset($this->usePrintVersion) && $this->usePrintVersion && $key) {
            $key = "print." . $key;
        }

        $default = Chart::defaultMetaData();

        $raw_meta = parent::getMetadata();
        // try normal decoding first
        $meta = json_decode($raw_meta, true);
        $utf8 = false;
        if (empty($meta)) {
            $json_err = json_last_error_msg();
            $utf8 = true;
            // now try utf8_encode
            $meta = json_decode(utf8_encode($raw_meta), true);
        }
        if (!is_array($meta)) $meta = array();
        $meta['json_error'] = isset($json_err) ? $json_err : null;
        $meta = array_merge_recursive_simple($default, $meta);
        if (empty($key)) return $meta;
        $keys = explode('.', $key);
        $p = $meta;
        foreach ($keys as $key) {
            if (isset($p[$key])) $p = $p[$key];
            else return null;
        }
        return $p;
    }

    /*
     * update a part of the metadata
     */
    public function updateMetadata($key, $value) {
        $meta = $this->getMetadata();
        $keys = explode('.', $key);
        $p = &$meta;
        foreach ($keys as $key) {
            if (!isset($p[$key])) {
                $p[$key] = array();
            }
            $p = &$p[$key];
        }
        $p = $value;
        $this->setMetadata(json_encode($meta, JSON_UNESCAPED_UNICODE));
    }

    public function isPublic() {
        // 1 = upload, 2 = describe, 3 = visualize, 4 = publish, 5 = published
        return !$this->getDeleted() && $this->getLastEditStep() >= 4;
    }

    public function _isDeleted() {
        return $this->getDeleted();
    }

    public function getLocale() {
        return $this->getLanguage();
    }

    public function setLocale($locale) {
        $this->setLanguage($locale);
    }

    public static function defaultMetaData() {
        return array(
            'data' => array(
                'transpose' => false,
                'vertical-header' => true,
                'horizontal-header' => true,
            ),
            'visualize' => array(
                'highlighted-series' => array(),
                'highlighted-values' => array()
            ),
            'describe' => array(
                'source-name' => '',
                'source-url' => '',
                'number-format' => '-',
                'number-divisor' => 0,
                'number-append' => '',
                'number-prepend' => '',
                'intro' => ''
            ),
            'publish' => array(
                'embed-width' => 600,
                'embed-height' => 400
            )
        );
    }

    /*
     * increment the public version of a chart, which is used
     * in chart public urls to deal with cdn caches
     */
    public function publish() {
        // increment public version
        $this->setPublicVersion($this->getPublicVersion() + 1);
        $published_urls = DatawrapperHooks::execute(DatawrapperHooks::GET_PUBLISHED_URL, $this);
        if (!empty($published_urls)) {
            // store public url from first publish module
            $this->setPublicUrl($published_urls[0]);
        } else {
            // fallback to local url
            $this->setPublicUrl($this->getLocalUrl());
        }
        $this->save();
        // log chart publish action
        Action::logAction(DatawrapperSession::getUser(), 'chart/publish', $this->getId());
    }

    /*
     * redirect previous chart versions to the most current one
     */
    public function redirectPreviousVersions() {
        $current_target = $this->getCDNPath();
        $redirect_html = '<html><head><meta http-equiv="REFRESH" content="0; url=/'.$current_target.'"></head></html>';
        $redirect_file = chart_publish_directory() . 'static/' . $this->getID() . '/redirect.html';
        file_put_contents($redirect_file, $redirect_html);
        $files = array();
        for ($v=0; $v < $this->getPublicVersion(); $v++) {
            $files[] = array($redirect_file, $this->getCDNPath($v) . 'index.html', 'text/html');
        }
        DatawrapperHooks::execute(DatawrapperHooks::PUBLISH_FILES, $files);
    }

    public function unpublish() {
        $path = $this->getStaticPath();
        if (file_exists($path)) {
            $dirIterator = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
            $itIterator  = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::CHILD_FIRST);

            foreach ($itIterator as $entry) {
                $file = realpath((string) $entry);

                if (is_dir($file)) {
                    rmdir($file);
                }
                else {
                    unlink($file);
                }
            }

            rmdir($path);
        }

        // Load CDN publishing class
        $config = $GLOBALS['dw_config'];
        if (!empty($config['publish'])) {

            // remove files from CDN
            $pub = get_module('publish', dirname(__FILE__) . '/../../../../');

            $id = $this->getID();

            $chart_files = array();
            $chart_files[] = "$id/index.html";
            $chart_files[] = "$id/data";
            $chart_files[] = "$id/$id.min.js";

            $pub->unpublish($chart_files);
        }

        // remove all jobs related to this chart
        JobQuery::create()
            ->filterByChart($this)
            ->delete();
    }

    public function hasPreview() {
        $cfg = $GLOBALS['dw_config'];

        if (isset($cfg['charts-s3'])
          && isset($cfg['charts-s3']['read'])
          && $cfg['charts-s3']['read'] == true) {

            $path = 's3://' . $cfg['charts-s3']['bucket'] . '/' .
                $this->getRelativeStaticPath() . '/m.png';
        } else {
            $path = $this->getStaticPath() . '/m.png';
        }

        try {
            return file_exists($path);
        } catch (Exception $ex) {
            return false;
        }
    }

    public function thumbUrl($forceLocal = false) {
        return $forceLocal ?
            '//' . $GLOBALS['dw_config']['chart_domain'] . '/' . $this->getID() . '/m.png' :
            $this->assetUrl('m.png');
    }

    public function getThumbFilename($thumb) {
        $cfg = $GLOBALS['dw_config'];
        if (isset($cfg['charts-s3']) && isset($cfg['charts-s3']['write'])
            && $cfg['charts-s3']['write'] == true) {
            // use S3 file url
            return 's3://' . $cfg['charts-s3']['bucket'] . '/'
                . get_relative_static_path($this) . '/' . $thumb . '.png';
        } else {
            // use local file url
            return get_static_path($this) . "/" . $thumb . '.png';
        }
    }

    public function plainUrl() {
        return $this->assetUrl('plain.html');
    }

    public function assetUrl($file) {
        return dirname($this->getPublicUrl() . '_') . '/' . $file;
    }

    public function getTitle() {
        if (isset($this->usePrintVersion) && $this->usePrintVersion) {
            return $this->getMetadata('describe.title');
        } else {
            return parent::getTitle();
        }
    }

    /*
     * return URL of this chart on Datawrapper
     */
    public function getLocalUrl() {
        return get_current_protocol() . '://' . $GLOBALS['dw_config']['chart_domain'] . '/' . $this->getID() . '/index.html';
    }

    public function getCDNPath($version = null) {
        if ($version === null) $version = $this->getPublicVersion();
        return $this->getID() . '/' . ($version > 0 ? $version . '/' : '');
    }

    public function getNamespace() {
        return (($this->getType() == "d3-maps-choropleth"
          || $this->getType() == "d3-maps-symbols") &&
          $this->getMetadata('visualize.map-type-set') != null) ?
          "map" : "chart";
    }

} // Chart

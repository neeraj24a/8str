<?php
/**
 * An Uploaded file information
 * Class represents records from table uploads
 * {autogenerated}
 * @property int $upload_id 
 * @property string $path 
 * @property string $desc 
 * @property string $prefix 
 * @property string $name 
 * @property string $mime 
 * @property longint size
 * @property int $delete 
 * @property int $uploaded 
 * @see Am_Table
 */
class Upload extends Am_Record_WithData
{
    protected $_key = 'upload_id';
    protected $_table = '?_upload';

    protected $_size = null;

    /** Get filename as submitted by customer */
    function getName(){ return $this->name; }
    function setName($name){
        $x=preg_split('/[\\\\\/]/', $name);
        $this->name = array_pop($x);
        return $this;
    }
    function getPrefix()
    {
        return $this->prefix;
    }
    /** Get full pathname to file */
    function getPath(){ return $this->path; }
    function setPath($path){ $this->path = $path; return $this;}
    
    /** Return file size as received from upload */
    function getSize(){ return $this->_size ? $this->_size : $this->_size = @filesize($this->getFullPath()); }
    function setSize($size){ $this->_size = $size; return $this;}
    
    function getSizeReadable(){
        return Am_Storage_File::getSizeReadable($this->getSize());
    }
    /** Return file mime type as submitted by user */
    function getType(){ return $this->mime; }
    function setType($type){ $this->mime = $type; return $this;}
    /** Return filename without dir path */
    function getFilename() { return basename($this->path); }
    /** For internal usage only */
    
    function setFrom_FILES($record, $k = null)
    {
        $this->setName($k === null ? $record['name'] : $record['name'][$k]);
        $this->mime = self::getMimeType($this->getName());
        $this->_tmp_name = $k === null ? $record['tmp_name'] : $record['tmp_name'][$k];
        $this->_error = $k === null ? @$record['error'] : @$record['error'][$k];
        $this->_size = filesize($this->_tmp_name);
    }
    protected function moveUploadedFile($source, $target)
    {
        return defined('AM_TEST') ? rename($source, $target) : move_uploaded_file($source, $target);
    }
    function moveUploaded($tempSeconds = null){
        $this->delete = $tempSeconds > 0 ? $this->getDi()->time+$tempSeconds : null;
        if (!$this->isLoaded()) { //for re-upload
            do {
                $this->path = '.'.$this->prefix.'.'.uniqid();
                $fullPath = $this->getFullPath();
            } while (file_exists($fullPath));
        }
        $fullPath = $this->getFullPath();
        if (!$this->moveUploadedFile($this->_tmp_name, $fullPath)){
            throw new Am_Exception_InternalError("Could not move uploaded file [$this->_tmp_name] to [$fullPath]");
        }
        $this->save();
        unset($this->_tmp_name);
        unset($this->_error);
    }
    function delete(){
        $fullPath = $this->getFullPath();
        if (file_exists($fullPath))
            if (!unlink($fullPath))
                throw new Am_Exception_InternalError("Could not delete [$fullPath], and corresponding database records also is not deleted");
        parent::delete();
    }
    function getStoreFolder()
    {
        return Am_Di::getInstance()->upload_dir;
    }
    function getFullPath()
    {
        return $this->getTable()->getRoot() . DIRECTORY_SEPARATOR . @$this->path;
    }
    /**
     * Determine mime type by file extension
     * @return string, application/octet-stream if unknown
     */
    static function getMimeType($filename){
        $common_mime_types = array(
             "exe" => "application/octet-stream",
             "class" => "application/octet-stream",
             "so" => "application/octet-stream",
             "dll" => "application/octet-stream",
             "oda" => "application/oda",
             "hqx" => "application/mac-binhex40",
             "cpt" => "application/mac-compactpro",
             "doc" => "application/msword",
             "bin" => "application/octet-stream",
             "dms" => "application/octet-stream",
             "lha" => "application/octet-stream",
             "lzh" => "application/octet-stream",
             "pdf" => "application/pdf",
             "ai" => "application/postscript",
             "eps" => "application/postscript",
             "ps" => "application/postscript",
             "smi" => "application/smil",
             "smil" => "application/smil",
             "bcpio" => "application/x-bcpio",
             "wbxml" => "application/vnd.wap.wbxml",
             "wmlc" => "application/vnd.wap.wmlc",
             "wmlsc" => "application/vnd.wap.wmlscriptc",
             "ogx" => "application/ogg",
             "anx" => "application/annodex",
             "xspf" => "application/xspf+xml",
             "vcd" => "application/x-cdlink",
             "pgn" => "application/x-chess-pgn",
             "cpio" => "application/x-cpio",
             "csh" => "application/x-csh",
             "dcr" => "application/x-director",
             "dir" => "application/x-director",
             "dxr" => "application/x-director",
             "dvi" => "application/x-dvi",
             "spl" => "application/x-futuresplash",
             "gtar" => "application/x-gtar",
             "hdf" => "application/x-hdf",
             "skp" => "application/x-koan",
             "skd" => "application/x-koan",
             "js" => "application/x-javascript",
             "skt" => "application/x-koan",
             "skm" => "application/x-koan",
             "latex" => "application/x-latex",
             "nc" => "application/x-netcdf",
             "cdf" => "application/x-netcdf",
             "sh" => "application/x-sh",
             "shar" => "application/x-shar",
             "swf" => "application/x-shockwave-flash",
             "sit" => "application/x-stuffit",
             "sv4cpio" => "application/x-sv4cpio",
             "sv4crc" => "application/x-sv4crc",
             "tar" => "application/x-tar",
             "tcl" => "application/x-tcl",
             "tex" => "application/x-tex",
             "texinfo" => "application/x-texinfo",
             "texi" => "application/x-texinfo",
             "t" => "application/x-troff",
             "tr" => "application/x-troff",
             "roff" => "application/x-troff",
             "man" => "application/x-troff-man",
             "me" => "application/x-troff-me",
             "ms" => "application/x-troff-ms",
             "ustar" => "application/x-ustar",
             "src" => "application/x-wais-source",
             "xhtml" => "application/xhtml+xml",
             "xht" => "application/xhtml+xml",
             "zip" => "application/zip",
             "au" => "audio/basic",
             "snd" => "audio/basic",
             "mid" => "audio/midi",
             "midi" => "audio/midi",
             "kar" => "audio/midi",
             "mpga" => "audio/mpeg",
             "mp2" => "audio/mpeg",
             "mp3" => "audio/mpeg",
             "oga" => "audio/ogg",
             "ogg" => "audio/ogg",
             "spx" => "audio/ogg",
             "flac" => "audio/flac",
             "axa" => "audio/annodex",
             "aif" => "audio/x-aiff",
             "aiff" => "audio/x-aiff",
             "aifc" => "audio/x-aiff",
             "m3u" => "audio/x-mpegurl",
             "ram" => "audio/x-pn-realaudio",
             "rm" => "audio/x-pn-realaudio",
             "rpm" => "audio/x-pn-realaudio-plugin",
             "ra" => "audio/x-realaudio",
             "wav" => "audio/x-wav",
             "pdb" => "chemical/x-pdb",
             "xyz" => "chemical/x-xyz",
             "bmp" => "image/bmp",
             "gif" => "image/gif",
             "ief" => "image/ief",
             "jpeg" => "image/jpeg",
             "jpg" => "image/jpeg",
             "jpe" => "image/jpeg",
             "png" => "image/png",
             "tiff" => "image/tiff",
             "tif" => "image/tif",
             "djvu" => "image/vnd.djvu",
             "djv" => "image/vnd.djvu",
             "wbmp" => "image/vnd.wap.wbmp",
             "ras" => "image/x-cmu-raster",
             "pnm" => "image/x-portable-anymap",
             "pbm" => "image/x-portable-bitmap",
             "pgm" => "image/x-portable-graymap",
             "ppm" => "image/x-portable-pixmap",
             "rgb" => "image/x-rgb",
             "xbm" => "image/x-xbitmap",
             "xpm" => "image/x-xpixmap",
             "xwd" => "image/x-windowdump",
             "igs" => "model/iges",
             "iges" => "model/iges",
             "msh" => "model/mesh",
             "mesh" => "model/mesh",
             "silo" => "model/mesh",
             "wrl" => "model/vrml",
             "vrml" => "model/vrml",
             "mpeg" => "video/mpeg",
             "mpg" => "video/mpeg",
             "mpe" => "video/mpeg",
             "mp4" => "video/mp4",
             "qt" => "video/quicktime",
             "mov" => "video/quicktime",
             "mxu" => "video/vnd.mpegurl",
             "ogv" => "video/ogg",
             "axv" => "video/annodex",
             "webm" => "video/webm",
             "3gp" => "video/3gp",
             "avi" => "video/x-msvideo",
             "flv" => "video/x-flv",
             "f4v" => "video/x-f4v",
             "movie" => "video/x-sgi-movie",
             "css" => "text/css",
             "asc" => "text/plain",
             "txt" => "text/plain",
             "rtx" => "text/richtext",
             "rtf" => "text/rtf",
             "sgml" => "text/sgml",
             "sgm" => "text/sgml",
             "tsv" => "text/tab-seperated-values",
             "wml" => "text/vnd.wap.wml",
             "wmls" => "text/vnd.wap.wmlscript",
             "etx" => "text/x-setext",
             "xml" => "text/xml",
             "xsl" => "text/xml",
             "htm" => "text/html",
             "html" => "text/html",
             "shtml" => "text/html",
             "csv" => "text/csv"
        );
        $ext = explode('.', $filename);
        $ext = strtolower(array_pop($ext));
        if (array_key_exists($ext, $common_mime_types))
            return $common_mime_types[$ext];
        else
            return 'application/octet-stream';
    }
    /** @return bool */
    function isValid() {
        return file_exists($this->getFullPath());
    }
    /** @return bool */
    function isInsideStoreFolder()
    {
        $p = realpath($this->getFullPath());
        $f = realpath($this->getTable()->getRoot());
        return strlen($f) && (strpos($p, $f) === 0);
    }

    function insert($reload = true)
    {
        $this->uploaded = $this->getDi()->time;
        return parent::insert($reload);
    }
}

class UploadTable extends Am_Table_WithData 
{
    protected $_key = 'upload_id';
    protected $_table = '?_upload';
    protected $_recordClass = 'Upload';
    const STORE_FIELD = 'field';
    const STORE_SERIALIZE = 'serialize';
    const STORE_IMPLODE = 'implode';
    const STORE_DATA_BLOB_SERIALIZE = 'data-serialize';
    protected $_usage = array();
    
    protected $_root;
    
    public function init()
    {
        parent::init();
        $this->_root = Am_Di::getInstance()->upload_dir;

        $this->defineUsage('downloads', 'file', 'path', UploadTable::STORE_FIELD, "Protected File [%title%]", '/default/admin-content/p/files/index?_files_a=edit&_files_id=%file_id%');
        $this->defineUsage('emailtemplate', 'email_template', 'attachments', UploadTable::STORE_IMPLODE, "Email Template [%name%, %lang%]", '/admin-setup/email');
        $this->defineUsage('email-pending', 'email_template', 'attachments', UploadTable::STORE_IMPLODE, "Pending Notification Template [%email_template_id%]", '/admin-setup/email');
        $this->defineUsage('email-messages', 'email_template', 'attachments', UploadTable::STORE_IMPLODE, "Autoresponder or Expiration E-Mail Template", '/default/admin-content/p/emails/index?_emails_a=edit&_emails_id=%email_template_id%');
        $this->defineUsage('video', 'video', 'path', UploadTable::STORE_FIELD, "Protected Video [%title%]", '/default/admin-content/p/video/index?_video_a=edit&_video_id=%video_id%');
        $this->defineUsage('email', 'email_sent', 'files', UploadTable::STORE_IMPLODE, "Sent email [%subject%, %desc_users%]", '/admin-email');
        $this->defineUsage('user_note', 'helpdesk_note', 'attachments', UploadTable::STORE_IMPLODE, "User Note [%user_id%]", '/admin-user-note/index/user_id/%user_id%');
    }
    
    function findByDelete($tm)
    {
        return $this->selectObjects("SELECT * FROM ?_upload WHERE `delete`>0 AND `delete`<?d", $tm);
    }
    
    function findByIds(array $ids, $prefix = null)
    {
        $ids = array_filter(array_map('intval', $ids));
        if (!$ids) return array();
        return $this->selectObjects(
            "SELECT * FROM ?_upload WHERE upload_id IN (?a) { AND prefix = ?}",
            $ids,
            $prefix === null ? DBSIMPLE_SKIP : $prefix);
    }
    
    function cleanUp()
    {
        $time = $this->getDi()->time;
        foreach ($this->findByDelete($time) as $upload)
        {
            try {
                if ($upload->isInsideStoreFolder())
                    $upload->delete();
            } catch (Am_Exception_InternalError $e) {
                $this->getDi()->errorLogTable->logException($e);
            }
        }
    }
    
    /**
     * set store folder
     * @param string $dir 
     */
    function setRoot($dir)
    {
        $this->_root = $dir;
        return $this;
    }
    
    function getRoot()
    {
        return $this->_root;
    }

    /**
     *
     * @param string $prefix
     * @param string $table
     * @param string $field
     * @param string $store_type enum(self::STORE_FIELD, STORE_SERIALIZE, STORE_IMPLODE, STORE_DATA_BLOB_SERIALIZE)
     * @param string $msg usage description, %feld_name% placeholders expanded
     * @param string $link relative link to page where usage can be found, %feld_name% placeholders expanded
     */
    public function defineUsage($prefix, $table, $field, $store_type, $msg, $link='') {
        $this->_usage[$prefix][] = array (
            'table' => $table,
            'field' => $field,
            'store_type' => $store_type,
            'msg' => $msg,
            'link' => $link
        );
    }


    /**
     *
     * @param Upload $upload
     * @return array [(title, link)]
     */
    public function findUsage(Upload $upload) {
        $res = array();
        foreach ($this->_usage[$upload->prefix] as $u) {
            $res = array_merge($res, $this->_checkUsage($upload, $u));
        }
        return $res;
    }

    protected function _checkUsage(Upload $upload, $usage)
    {
        $rows = array();
        switch ($usage['store_type']) {
            case self::STORE_FIELD:
                $rows = $this->getDi()->db->query("SELECT * FROM ?_{$usage['table']} WHERE ?#=?",
                    $usage['field'], $upload->pk());
                break;
            case self::STORE_SERIALIZE:
                $len = strlen($upload->pk());
                $rows = $this->getDi()->db->query("SELECT * FROM ?_{$usage['table']} WHERE (?# LIKE ? OR ?# LIKE ?)",
                    $usage['field'], '%i:' . $upload->pk() . ';%',
                    $usage['field'], '%s:' . $len . ':"' . $upload->pk() . '";%');
                break;
            case self::STORE_IMPLODE:
                $rows = $this->getDi()->db->query("SELECT * FROM ?_{$usage['table']} WHERE ?#=? OR ?# LIKE ? OR ?# LIKE ? OR ?# LIKE ?",
                    $usage['field'], $upload->pk(),
                        $usage['field'], $upload->pk() . ',%',
                        $usage['field'], '%,' . $upload->pk(),
                        $usage['field'], '%,' . $upload->pk() . ',%');
                break;
            case self::STORE_DATA_BLOB_SERIALIZE :
                $len = strlen($upload->pk());
                $tbl = $usage['table'] . 'Table';
                $keyField = $this->getDi()->{$tbl}->getKeyField();
                $rows = $this->getDi()->db->query("SELECT t.* FROM ?_{$usage['table']} t
                    LEFT JOIN ?_data d ON d.`table` = ? AND d.`id`=t.?# WHERE d.`key`=? AND (d.`blob` LIKE ? OR d.`blob` LIKE ?)",
                    $usage['table'], $keyField, $usage['field'], 
                    '%i:' . $upload->pk() . ';%',
                    '%s:' . $len . ':"' . $upload->pk() . '";%');
                break;
        }
        
        if (empty($rows)) return array();
        
        $result = array();
        
        foreach ($rows as $row) {
            $result[] = array(
                'title' => $this->_expandPlaceholders($usage['msg'], $row),
                'link' => $this->_expandPlaceholders($usage['link'], $row)
                );
        }

        return $result;

    }

    protected function _expandPlaceholders($str, $vars)
    {
        foreach ($vars as $k => $val) {
           $str = str_replace('%' . $k . '%', $val, $str);
        }
        return $str;
    }
}



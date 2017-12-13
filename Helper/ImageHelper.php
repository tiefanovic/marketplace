<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/12/17
 * Time: 3:49 PM
 */

namespace AWstreams\Marketplace\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper as Helper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Filesystem;
use Magento\Framework\HTTP\Adapter\FileTransferFactory;
use Magento\MediaStorage\Model\File\UploaderFactory;

class ImageHelper extends Helper
{

    private $_allowed_image_extensions = ['jpg', 'jpeg', 'gif', 'png'];


    const MAX_IMAGE_FILE_SIZE = 10485760;

    const MAX_FILE_SIZE = 10485760;

    protected $_fileUploaderFactory;

    protected $_filesystem;

    protected $httpFactory;

    public function __construct(
        Context $context,
        UploaderFactory $fileUploaderFactory,
        Filesystem $filesystem,
        FileTransferFactory $httpFactory
    )
    {
        parent::__construct($context);
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_filesystem = $filesystem;
        $this->httpFactory = $httpFactory;
    }

    public function uploadImage($fileId)
    {
        try{
            // Validate all of them first.
            /*if (!$this->isFileValid($fileId, true))
                return [];*/
            $uploader = $this->_fileUploaderFactory->create(['fileId' => $fileId]);
            $uploader->setAllowedExtensions($this->_allowed_image_extensions);
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $path = $this->_filesystem->getDirectoryRead(
                DirectoryList::MEDIA
            )->getAbsolutePath(
                'catalog/product'
            );
            $uploader->save($path);
            $fullPath = $path . $uploader->getUploadedFileName();
            return ['success'=>true, 'result'=>$fullPath];
        } catch (\Exception $e){
            return ['success'=>false, 'result'=>$e];
        }


    }

    public function isFileValid($fileId, $isImage)
    {
        $adapter = $this->httpFactory->create();
        $adapter->addValidator(
            new \Zend_Validate_File_FilesSize(['max' => $isImage ? self::MAX_IMAGE_FILE_SIZE : self::MAX_FILE_SIZE])
        );
        if ($adapter->isUploaded($fileId)) {
            // validate image
            if (!$adapter->isValid($fileId)) {
                throw new \Exception(__('Uploaded file is not valid.'));
            }
            return true;
        }
        return false;
    }
}
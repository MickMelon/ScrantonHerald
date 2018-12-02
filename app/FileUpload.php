<?php 
namespace App;

class FileUpload 
{
    const MAX_FILE_SIZE = '20097152';
    const BASE_DIR = 'public/uploads/';
    const ALLOWED_IMAGE_EXTENSIONS = array('png', 'gif', 'jpg');
    CONST ALLOWED_FILE_EXTENSIONS = array('mp3', 'mp4');

    public $fileName;
    public $fileSize;
    public $fileTmp;
    public $fileType;
    public $fileExt;
    public $isImage;

    public function __construct($file, $isImage = false)
    {
        $this->fileName = $file['name'];
        $this->fileTmp = $file['tmp_name'];
        $this->fileSize = $file['size'];
        $this->fileType = $file['type'];

        $value = explode('.', $this->fileName);
        $this->fileExt = strtolower(end($value));

        $this->isImage = $isImage;
    }

    public function upload($fileName = false)
    {
        if ($this->fileSize > 0)
        {
            $errors = $this->verifyFileType();

            if (empty($errors))
            {
                $targetFile = 
                    FileUpload::BASE_DIR 
                    . ($this->isImage ? 'images/' : 'files/') 
                    . ($fileName === false ? $this->fileName : $fileName);

                if (!file_exists($targetFile))
                    move_uploaded_file($this->fileTmp, $targetFile);

                return $targetFile;
            }
            else 
                return $errors;
        }
    }

    private function verifyFileType()
    {
        $errors = array();
        
        $allowedExtensions =
            $this->isImage 
            ? FileUpload::ALLOWED_IMAGE_EXTENSIONS 
            : FileUpload::ALLOWED_FILE_EXTENSIONS; 

        if (!in_array($this->fileExt, $allowedExtensions))
            $errors[] = 'Extension not allowed.';

        if ($this->fileSize > FileUpload::MAX_FILE_SIZE)
            $errors[] = 'File must be no bigger than ' . FileUpload::MAX_FILE_SIZE;

        return $errors;
    }
}
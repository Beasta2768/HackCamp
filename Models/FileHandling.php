<?php

class FileHandling
{
    protected $fileToUpload, $target_file, $fileError, $fileErrorMessage, $imageFileType, $Response;

    public function __construct()
    {
        $this->fileToUpload = "";
        $this->target_file = "";
        $this->fileError = "";
        $this->fileErrorMessage = "";
        $this->imageFileType = "";
    }

    public function uploadFile($targetFile, $imageFileType)
    {
        $this->target_file = $targetFile;
        $uploadOk = 1;
//id the file already exists it will override the current file to change it to th new one
        if (file_exists($targetFile)) {
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["myFile"]["size"] > 250000) {
            $this->fileError = "File Size";
            $this->fileErrorMessage = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "csv" && $imageFileType != "xlsx") {
            $this->fileError = "File Type";
            $this->fileErrorMessage = "Sorry, only CSV & XLSX files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk != 0) {
                $fileUpload = move_uploaded_file($_FILES["myFile"]["tmp_name"], $targetFile);

            while (file_exists($targetFile) == false){
//                do nothing
            }
            if ($fileUpload) {
                echo "The file " . htmlspecialchars(basename($_FILES["myFile"]["name"])) . " has been uploaded.";
                //calls the public api from the url given
                return true;
            } else {
                $this->fileError = "File Upload";
                $this->fileErrorMessage = "Sorry, there was an error uploading your file.";
                return false;
            }
        }
    }


    /**
     * @return string
     */
    public function getTargetFile(): string
    {
        return $this->target_file;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->Response;
    }

    public function getFileError(): string
    {
        return $this->fileError;
    }

    /**
     * @return string
     */
    public function getFileErrorMessage(): string
    {
        return $this->fileErrorMessage;
    }

}
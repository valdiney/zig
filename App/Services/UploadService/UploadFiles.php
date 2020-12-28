<?php
/**
 * This class is used to do the upload of the files to the server
 **--------------------------------------------------------------------------------------------------
 *
 * @var $config :           Array that stores the errors that will be generated
 * @var $file :             Array -  $_FILES containing the name of the file field
 * @var $extensios :        Array - containing the types of files that you want to allow
 * @var $allowedFileSize :  Int Maximum size that you want to allow
 *
 *--------------------------------------------------------------------------------------------------
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Valdiney França <valdiney.2@hotmail.com>
 * @version 0.3
 *
 *--------------------------------------------------------------------------------------------------
 *
 * Message Error.
 * 1 = Error when trying to upload extensions not allowed by the user
 * 2 = Error Beyond the user-defined size Maximum upload
 * 3 = The system can't identify the extension
 * 4 = Error on try to save file in `arquivos/` directory
 *
 *---------------------------------------------------------------------------------------------------
 */

namespace App\Services\UploadService;

class UploadFiles
{
    private $config = [];
    private $file;
    private $extensions = [];
    private $allowedFileSize = 2;
    private $internalErrors;

    # The message error it's beginning null
    public function __construct()
    {
        $this->internalErrors["1"] = null;
        $this->internalErrors["2"] = null;
        $this->internalErrors["3"] = null;
        $this->internalErrors["4"] = null;
    }

    # Setting the attributes
    public function file($file)
    {
        $this->file = $file;
    }

    # The name of the folder that you can send the file
    public function folder($folder)
    {
        $this->config["folder"] = $folder;
    }

    # You can pass an array with the extensions of the files
    public function extensions(array $extensions)
    {
        $this->extensions = $extensions;
    }

    /*You can demand a max size to the file that will be uploaded*/
    public function maxSize($fileSize = 4)
    {
        $this->allowedFileSize = $fileSize;
    }

    public function move()
    {
        if ($this->moveFile()) {
            return true;
        }

        return false;
    }

    # Exectute the Move File action

    private function moveFile()
    {
        $getFinalExtension = explode(".", $this->file["name"]);

        # Verifying if exist more than one (.) point in the name of the file
        if (count($getFinalExtension) > 2) {
            $name = str_replace(".", "_", $this->file["name"]);
            $name = substr(strrchr($name, "_"), 1);

            $pathAndName = $this->config["folder"] . time() . "." . $name;
        } else {
            $pathAndName = $this->config["folder"] . time() . "." . $getFinalExtension[1];
        }

        $this->config["finalPath"] = $pathAndName;

        # if directory not exists and is not possible to create, then return the error 4
        if (!$this->createFolder()) {
            $this->internalErrors["4"] = true;
            return false;
        }

        return move_uploaded_file($this->file["tmp_name"], $pathAndName);
    }

    # This method create the folder that will be passed like argument for the method sendTo() if the folder no exist

    private function createFolder()
    {
        # Verify if directory exists, if not try to create it and return the result
        if (is_dir($this->config["folder"]) or
            mkdir($this->config["folder"], 777, true)) {
            return true;
        }
        return false;
    }

    # This method move the files to the folder destination

    public function destinationPath()
    {
        $this->moveFile();
        return $this->config["finalPath"];
    }

    # This method return the final name of the files and your extension

    public function getErrors()
    {
        $this->executeValidations();

        if (!is_null($this->internalErrors["1"])) {
            return 1;
        } elseif (!is_null($this->internalErrors["2"])) {
            return 2;
        } elseif (!is_null($this->internalErrors["3"])) {
            return 3;
        } elseif (!is_null($this->internalErrors["4"])) {
            return 4;
        }
    }

    # This method get status of errors

    private function executeValidations()
    {
        $this->config["fileLength"] = 1024 * 1024 * $this->allowedFileSize;
        $this->config["theExtensions"] = $this->extensions;

        # Get the extension of the file
        if (!($prepareExtensions = $this->file['type'])) {
            $this->internalErrors["3"] = true;
            return false;
        }

        # Getting the extension by preg_match: (image|audio|...)/(jpeg|png|mp3|...)
        preg_match('/(\w+)\/(\w+)/', $prepareExtensions, $matches);
        $prepareExtensions = $matches[2];
        $prepareExtensions = strtolower($prepareExtensions);

        # Verify the extension of the file
        if (array_search($prepareExtensions, $this->config["theExtensions"]) === false) {
            $this->internalErrors["1"] = true;
            return false;
        }

        # Verify the max file limit
        if ($this->config["fileLength"] < $this->file["size"]) {
            $this->internalErrors["2"] = true;
            return false;
        }
    }

    # Empty the attributes

    public function __destruct()
    {
        unset($this->file);
        unset($this->config);
        unset($this->extensions);
        $this->allowedFileSize = null;
    }
}

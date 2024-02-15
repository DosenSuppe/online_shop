<?php

    /**
     * checkFileLocation
     * 
     * returns the directory when found
     * elsewise it creates and returns it
     * 
     * returns null if unable to create
     * 
     * input:
     *      directoryPath    -> string
     * 
     * output:
     *      directoryPath    -> string
     */
    function checkDirectory($directoryPath) {
        // redirecting to the file server
        return file_exists("../../FileServer/".$directoryPath) ? $directoryPath : mkdir("../../FileServer/".$directoryPath, 0777, true) ? $directoryPath : null;
    }

    /**
     * saveFileToServer
     *  
     * saves the given file to the file server
     * 
     * input: 
     *      productId   -> string
     *      pictureData -> file: string
     * 
     * output:
     *      pictureId   -> string
     *      unable to save -> null
     * 
     */
    function saveFileToServer($productId, $pictureData) {
        $fileLocation = checkFileLocation($productId);

        $fileCount = array_diff(scandir($path), array('.', '..'))
        if ($fileLocation != null) {
            // file already exists!
            return null;
        }
    }

    /**
     * loadFileFromServer
     * 
     * loads the requested file from the file server.
     * 
     * input: 
     *      productId   -> string
     *      pictureId   -> string
     * 
     * output:
     *      pictureData -> file: string
     *      unable to load -> null
     */
    function loadFileFromServer($productId, $pictureId) {

    }


    /**
     * removeFileFromServer
     * 
     * removes a file from the file server.
     * 
     * input: 
     *      productId   -> string
     *      pictureId   -> string
     * 
     * output:
     *      success     -> true
     *      failed      -> false
     */
    function removeFileFromServer($productId, $pictureId) {

    }

?>
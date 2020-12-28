<?php

namespace System\Post;

/*
|--------------------------------------------------------------------------
| Post
|--------------------------------------------------------------------------
| This class is used to Receive and return an object with data from post request
|
*/

class Post
{
    private $data;

    public function __construct()
    {
        # Call setPostData method
        $this->setPostData();
    }

    /*
     * This method is used to obtain and transform data from post request
     * in an object
     * @return Void
    */
    private function setPostData()
    {
        $data = [];
        foreach ($_POST as $key => $value) {
            // remove token do data
            if ($key == '_token') {
                continue;
            }
            $data[$key] = (empty($value) ? null : $value);
        }

        $this->data = (object)$data;
    }

    /*
     * This method is used to return all data from post request
     * @return Object
    */
    public function data()
    {
        return $this->data;
    }

    /*
     * This method is used to return an object with data passed in array argument.
     * @return Object
    */
    public function only(array $data)
    {
        $filteredData = [];
        $internalData = (array)$this->data;

        foreach ($data as $value) {
            if (!array_key_exists($value, $internalData)) {
                echo "The ({$value}) value not exist in Post Request";
            }

            $filteredData[$value] = $internalData[$value];
        }

        return (object)$filteredData;
    }

    /*
     * This method is used to verify if has post request
     * @return Bool
    */
    public function hasPost()
    {
        if ($_POST) {
            return true;
        }

        return false;
    }
}

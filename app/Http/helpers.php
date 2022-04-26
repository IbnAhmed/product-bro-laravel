<?php


if (!function_exists('asset_cloud')) {

    /**
     * wrap resource path with base url
     *
     * @param string $path
     *
     * @return string
     */
    function asset_cloud($path)
    {
        if($path){
            if (strpos($path, '//') !== false) {
                return $path;
            } else {
                return asset($path);
            }
        } else {
            return $path;
        }
    }
}


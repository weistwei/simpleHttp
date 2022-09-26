<?php

namespace NickLabs\Net;

class SimpleHttpResponseProtocolVersion {

    /** @var mixed|string */
    public $major = null;

    /** @var mixed|string */
    public $minor = null;

    public function __construct(string $versionString){
        if(strpos($versionString, '.') !== false){
            list($major, $minor) = explode('.', $versionString);

            $this->major = $major;

            $this->minor = $minor;
        }else{
            $this->major = $versionString;
            $this->minor = "";
        }
    }

}

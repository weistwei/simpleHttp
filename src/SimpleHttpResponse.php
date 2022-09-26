<?php

namespace NickStudio\Net;

use Exception;
use stdClass;

/**
 * Class SimpleHttp
 * @package NickStudio\Net
 * @author Nick <weist.wei@gmail.com>
 * @date 2021/7/31
 */
class SimpleHttpResponse {

    /** @var bool */
    private $status;

    /** @var string */
    private $protocol;

    /** @var SimpleHttpResponseProtocolVersion */
    private $protocolVersion;

    /** @var string */
    private $statusCode;

    /** @var string */
    private $statusMessage;

    /** @var array */
    private $cookies;

    /** @var SimpleHttpResponseHeader */
    private $header;

    /** @var array */
    private $rawHeaders;

    /** @var string */
    private $rawBody;

    /** @var string */
    private $errorMessage;

    /**
     * SimpleHttpResponse constructor.
     */
    public function __construct(){
        $this->initParams();;
        $args = func_get_args();
        if(count($args) == 2){
            $this->status = true;
            $this->parseHeader($args[0]);
            $this->setBody($args[1]);
        }else{
            $this->status = false;
            $this->setError($args[0]);
        }
    }

    private function initParams(){
        $this->status = false;
        $this->protocol = '';
        $this->statusCode = '';
        $this->statusMessage = '';
        $this->cookies = [];
        $this->header = new SimpleHttpResponseHeader();
        $this->rawHeaders = [];
        $this->rawBody = '';
        $this->errorMessage = '';
    }

    /**
     * @param string $header
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    private function parseHeader(string $header){
        $headerFragments = array_filter(explode(PHP_EOL, $header), function($value){
            return (empty(trim($value)) == false);
        });

        $protocolAndStatusString = array_shift($headerFragments);

        list($protocolAndVersion, $statusCode, $statusMessage) = explode(' ', $protocolAndStatusString);
        list($protocol, $version) = explode('/', $protocolAndVersion);

        $this->status = ($statusCode == 200);

        $this->protocol = $protocol;

        $this->protocolVersion = new SimpleHttpResponseProtocolVersion($version);

        $this->statusCode = $statusCode;

        $this->statusMessage = $statusMessage;
        foreach($headerFragments as $headerFragment){
            $cuts = explode(':', $headerFragment);
            $name = array_shift($cuts);
            $name = lcfirst(str_replace(['-', ' '], '', ucwords(ucwords($name, '-'), ' ')));

            $value = trim(implode(':', $cuts));

            $this->header->setHeader($name, $value);
            $this->rawHeaders[] = $headerFragment;
        }
    }

    /**
     * @param string $rawBody
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    private function setBody(string $rawBody){
        $this->rawBody = $rawBody;
    }

    /**
     * @param string $errorMessage
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    private function setError(string $errorMessage){
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getStatus(): bool{
        return $this->status;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getProtocol(): string{
        return $this->protocol;
    }

    /**
     * @return SimpleHttpResponseProtocolVersion
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getProtocolVersion(): SimpleHttpResponseProtocolVersion{
        return $this->protocolVersion;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getStatusCode(): string{
        return $this->statusCode;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getStatusMessage(): string{
        return $this->statusMessage;
    }

    /**
     * @return array
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getCookies(): array{
        return $this->cookies;
    }

    /**
     * @return SimpleHttpResponseHeader
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getHeader(): SimpleHttpResponseHeader{
        return $this->header;
    }

    /**
     * @return array
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getRawHeaders(): array{
        return $this->rawHeaders;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getBody(): string{
        return $this->rawBody;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getErrorMessage(): string{
        return $this->errorMessage;
    }

    /**
     * @return stdClass
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getJson(): stdClass{
        return json_decode($this->getBody());
    }
}

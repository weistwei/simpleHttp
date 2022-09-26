<?php

namespace NickStudio\Net;

use Exception;

/**
 * Class SimpleHttp
 * @package NickStudio\Net
 * @author Nick <weist.wei@gmail.com>
 * @date 2021/7/31
 */
class SimpleHttpCookie {

    /** @var string */
    private $name = '';

    /** @var string */
    private $value = '';

    /** @var string */
    private $domain = '';

    /** @var string */
    private $path = '';

    /** @var string */
    private $expires = '';

    /** @var bool */
    private $session = false;

    /** @var bool */
    private $hostOnly = false;

    /** @var bool */
    private $secure = false;

    /** @var bool */
    private $httpOnly = false;

    /** @var string */
    private $sameSite = '';

    /** @var bool */
    private $sameParty = false;

    /** @var string */
    private $priority = '';

    /** @var integer */
    private $maxAge = 0;

    /**
     * SimpleHttpCookie constructor.
     * @param string $cookieString
     */
    public function __construct(string $cookieString){
        $cookieFragments = explode(';', $cookieString);
        foreach($cookieFragments as $cookieFragment){
            $cookieInfoFragments = explode('=', $cookieFragment);
            $name = trim(strtolower(array_shift($cookieInfoFragments)));
            $value = implode('=', $cookieInfoFragments);

            switch($name){
                case strtolower('Domain'):
                    $this->domain = $value;
                    break;
                case strtolower('Path'):
                    $this->path = $value;
                    break;
                case strtolower('Expires'):
                    $this->expires = $value;
                    break;
                case strtolower('Session'):
                    $this->session = true;
                    break;
                case strtolower('HostOnly'):
                    $this->hostOnly = true;
                    break;
                case strtolower('Secure'):
                    $this->secure = true;
                    break;
                case strtolower('HttpOnly'):
                    $this->httpOnly = true;
                    break;
                case strtolower('SameSite'):
                    switch($value){
                        case SimpleHttpCookieSameSite::LAX:
                            $this->sameSite = SimpleHttpCookieSameSite::LAX;
                            break;
                        case SimpleHttpCookieSameSite::NONE:
                            $this->sameSite = SimpleHttpCookieSameSite::NONE;
                            break;
                        case SimpleHttpCookieSameSite::STRICT:
                            $this->sameSite = SimpleHttpCookieSameSite::STRICT;
                            break;
                    }
                    break;
                case strtolower('SameParty'):
                    $this->sameParty = true;
                    break;
                case strtolower('Priority'):
                    switch($value){
                        case SimpleHttpCookiePriority::LOW:
                            $this->sameSite = SimpleHttpCookiePriority::LOW;
                            break;
                        case SimpleHttpCookiePriority::MEDIUM:
                            $this->sameSite = SimpleHttpCookiePriority::MEDIUM;
                            break;
                        case SimpleHttpCookiePriority::HIGH:
                            $this->sameSite = SimpleHttpCookiePriority::HIGH;
                            break;
                    }
                    break;
                case strtolower('Max-Age'):
                    $this->maxAge = 0;
                    break;
                default:
                    $this->name = $name;
                    $this->value = $value;
                    break;
            }
        }
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getName(): string{
        return $this->name;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getValue(): string{
        return $this->value;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getDomain(): string{
        return $this->domain;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getPath(): string{
        return $this->path;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getExpires(): string{
        return $this->expires;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getSession(): bool{
        return $this->session;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getHostOnly(): bool{
        return $this->hostOnly;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getSecure(): bool{
        return $this->secure;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getHttpOnly(): bool{
        return $this->httpOnly;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getSameSite(): string{
        return $this->sameSite;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getSameParty(): bool{
        return $this->sameParty;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getPriority(): string{
        return $this->priority;
    }

    /**
     * @return int
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getMaxAge(): int{
        return $this->maxAge;
    }

}

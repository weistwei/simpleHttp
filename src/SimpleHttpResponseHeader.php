<?php

namespace NickStudio\Net;

use Exception;
use DateTime;

/**
 * Class SimpleHttp
 * @package NickStudio\Net
 * @author Nick <weist.wei@gmail.com>
 * @date 2021/7/31
 */
class SimpleHttpResponseHeader {

    /** @var array */
    private $attributes = [];

    public function setHeader(string $name, string $value){
        if(array_key_exists($name, $this->attributes) == false){
            $this->attributes[$name] = [];
        }
        if(strpos($name, 'setCookie') !== false){
            $this->attributes[$name][] = new SimpleHttpCookie($value);
        }else{
            $this->attributes[$name][] = $value;
        }
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function hasLocation(): bool{
        return empty($this->attributes['location']) == false;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function hasDate(): bool{
        return empty($this->attributes['date']) == false;
    }

    /**
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function hasSetCookie(): bool{
        return empty($this->attributes['setCookie']) == false;
    }

    /**
     * @param string $name
     * @return bool
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function hasSetCookieFromName(string $name): bool{
        if(empty($this->attributes['setCookie']) == false){
            /** @var SimpleHttpCookie $cookie */
            foreach($this->attributes['setCookie'] as $cookie){
                if($cookie->getName() == $name){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getLocation(): string{
        return $this->attributes['location'][0] ?? '';
    }

    /**
     * @return DateTime|null
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getDate(): ?DateTime{
        return $this->attributes['date'][0] ?? null;
    }

    /**
     * @return array|null
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getSetCookieAll(): ?array{
        return $this->attributes['setCookie'] ?? [];
    }

    /**
     * @param string $name
     * @return string
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/2
     */
    public function getSetCookieFromName(string $name): string{
        if(empty($this->attributes['setCookie']) == false){
            /** @var SimpleHttpCookie $cookie */
            foreach($this->attributes['setCookie'] as $cookie){
                if($cookie->getName() == $name){
                    return $cookie->getValue();
                }
            }
        }
        return '';
    }

}

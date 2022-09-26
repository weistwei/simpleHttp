<?php

namespace NickLabs\Net;

use Exception;

/**
 * Class SimpleHttp
 * @package NickLabs\Net
 * @author Nick <weist.wei@gmail.com>
 * @date 2021/7/31
 */
class SimpleHttp {

    /**
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param string $postData
     * @return SimpleHttpResponse
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/3
     */
    private function baseRequest(string $url, string $method, array $headers, string $postData): SimpleHttpResponse{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        if(strtoupper($method) == SimpleHttpMethod::GET){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, SimpleHttpMethod::GET);
        }
        if(strtoupper($method) == SimpleHttpMethod::POST){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, SimpleHttpMethod::POST);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //这个是重点,规避ssl的证书检查。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 跳过host验证

        $response = curl_exec($ch);

        if(curl_errno($ch)){
            $errorMessage = curl_error($ch);
            $simpleHttpResponse = new SimpleHttpResponse($errorMessage);
        }else{
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headerString = substr($response, 0, $headerSize);
            $responseBody = substr($response, $headerSize);

            $simpleHttpResponse = new SimpleHttpResponse($headerString, $responseBody);
        }

        curl_close($ch);
        return $simpleHttpResponse;
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param array $postData
     * @return SimpleHttpResponse
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/3
     */
    public function request(string $url, string $method = 'get', array $headers = [], array $postData = []): SimpleHttpResponse{
        return $this->baseRequest($url, $method, $headers, http_build_query($postData));
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $headers
     * @param array $postData
     * @return SimpleHttpResponse
     * @author Nick <weist.wei@gmail.com>
     * @date 2021/8/3
     */
    public function requestJson(string $url, string $method = 'get', array $headers = [], array $postData = []): SimpleHttpResponse{
        return $this->baseRequest($url, $method, $headers, json_encode($postData));
    }

}

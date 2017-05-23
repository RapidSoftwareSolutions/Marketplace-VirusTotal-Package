<?php
/**
 * Created by PhpStorm.
 * User: rapidapi
 * Date: 14.04.17
 * Time: 13:56
 */

namespace RapidAPIBundle\Service;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;

class Sender
{
    public function send($data)
    {
        $url = $data['url'];
        $method = $data['method'];
        unset($data['url'], $data['method']);
        try {
            // todo create Guzzle settings
            $client = new Client();
            /** @var ResponseInterface $vendorResponse */
            $vendorResponse = $client->$method($url, $data);
            if (in_array($vendorResponse->getStatusCode(), range(200, 204))) {
                $result['callback'] = 'success';
                $vendorResponseBodyContent = $vendorResponse->getBody()->getContents();
                if (empty($vendorResponseBodyContent)) {
                    $result['contextWrites']['to'] = $vendorResponse->getReasonPhrase();
                } else {
                    $result['contextWrites']['to'] = json_decode($vendorResponseBodyContent, true);
                }
            } else {
                $result['callback'] = 'error';
                $result['contextWrites']['to']['status_code'] = 'API_ERROR';
                $result['contextWrites']['to']['status_msg'] = is_array($vendorResponse) ? $vendorResponse : json_decode($vendorResponse, true);
            }
        } catch (BadResponseException $exception) {
            // todo add params, to find in header needed to response
            $exceptionResponseContent = $exception->getResponse()->getBody()->getContents();
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            if (empty(trim($exceptionResponseContent))) {
                $result['contextWrites']['to']['status_msg'] = $exception->getResponse()->getReasonPhrase();
            } else {
                $answerDecoded = json_decode($exceptionResponseContent, true);
                if (json_last_error()) {
                    $result['contextWrites']['to']['status_msg'] = $exceptionResponseContent;
                } else {
                    $result['contextWrites']['to']['status_msg'] = $answerDecoded;
                }
            }
        }

        return $result;
    }
}
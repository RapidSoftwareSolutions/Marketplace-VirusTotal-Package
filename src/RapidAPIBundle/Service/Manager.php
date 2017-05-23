<?php
/**
 * Created by PhpStorm.
 * User: rapidapi
 * Date: 14.04.17
 * Time: 14:28
 */

namespace RapidAPIBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use RapidAPIBundle\Exception\PackageException;

class Manager
{
    /** @var DataValidator */
    private $dataValidator;

    /** @var Metadata */
    private $metadata;

    /** @var Request */
    private $request;

    /** @var array */
    private $currentBlockMetadata = [];

    public function __construct(DataValidator $dataValidator, Metadata $metadata, RequestStack $requestStack)
    {
        $this->dataValidator = $dataValidator;
        $this->request = $requestStack->getCurrentRequest();
        $this->metadata = $metadata;
    }

    public function setBlockName($blockName)
    {
        $this->currentBlockMetadata = $this->metadata->getBlockData($blockName);
        $this->dataValidator->setData($this->request, $this->currentBlockMetadata);
    }

    public function getValidData(): array
    {
        return $this->dataValidator->getValidData();
    }

    public function getUrlParams(): array
    {
        return $this->dataValidator->getUrlParams();
    }

    public function getBodyParams(): array
    {
        return $this->dataValidator->getBodyParams();
    }

    public function createGuzzleData($url, $headers, $urlParams, $params) {
        return $this->dataValidator->createGuzzleData($url, $headers, $urlParams, $params);
    }

    public function createFullUrl(&$data, $url = '')
    {
        $url = $url . $this->currentBlockMetadata['url'];
        $res = preg_replace_callback(
            '/{(\w+)}/',
            function ($match) use (&$data) {
                if (!isset($data[$match[1]])) {
                    throw new PackageException('Cant find variables to URL parse: ' . $match[1]);
                }
                $result = $data[$match[1]];
                unset($data[$match[1]]);
                if (is_array($result)) {
                    return str_replace(' ', '', implode(',', $result));
                }
                return $result;
            },
            $url);
        return $res;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: rapidapi
 * Date: 14.04.17
 * Time: 16:49
 */

namespace RapidAPIBundle\Service;


use RapidAPIBundle\Exception\PackageException;

class Metadata
{
    /** @var array */
    private $metaDataFull = [];

    /**
     * File constructor.
     * @throws PackageException
     */
    public function __construct()
    {
        // todo move from RapidAPIBundle into PackageBundle and from there load metadata
        $metaDataContent = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/metadata.json', 'r');
        if (!$metaDataContent) {
            throw new PackageException('Metadata not found');
        }
        $this->metaDataFull = json_decode($metaDataContent, true);
        if (json_last_error()) {
            throw new PackageException(json_last_error_msg() . '. Incorrect Metadata JSON.');
        }
    }

    /**
     * @return array
     */
    public function getClearMetadata()
    {
        $result = $this->metaDataFull;
        foreach ($result['blocks'] as &$block) {
            unset($block['method'], $block['url'], $block['type'], $block['snakeCase']);
            foreach ($block['args'] as &$param) {
                unset(
                    $param['wrapName'],
                    $param['complex'],
                    $param['keyName'],
                    $param['keyValue'],
                    $param['jsonParse'],
                    $param['base64encode'],
                    $param['toInt'],
                    $param['toString'],
                    $param['urlParam'],
                    $param['snakeCase'],
                    $param['vendorName']
                );
            }
        }

        return $result;
    }

    /**
     * @param $blockName
     * @return array
     * @throws PackageException
     */
    public function getBlockData($blockName)
    {
        foreach ($this->metaDataFull['blocks'] as $block) {
            if ($block['name'] == $blockName) {
                return $block;
            }
        }
        throw new PackageException("Not found description in metadata for current block");
    }
}
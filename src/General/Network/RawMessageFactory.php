<?php
namespace Volante\SkyBukkit\Common\Src\General\Network;

/**
 * Class MessageFactory
 *
 * @package Volante\SkyBukkit\Monitor\Src\FlightStatus\Network
 */
abstract class RawMessageFactory
{
    /**
     * @param string $json
     * @return BaseRawMessage
     */
    protected function createFromJson(string $json) : BaseRawMessage
    {
        $json = $this->getJsonData($json);
        return new BaseRawMessage($json['type'], $json['title'], $json['data']);
    }

    /**
     * @param string $json
     * @return array
     */
    protected function getJsonData(string $json) : array
    {
        $json = json_decode($json, true);

        if (!is_array($json)) {
            throw new \InvalidArgumentException('Invalid message format: invalid json format');
        }

        $this->validate($json);

        return $json;
    }

    /**
     * @param array $data
     */
    private function validate(array $data)
    {
        if (!isset($data['type'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <type> missing');
        }
        if (!isset($data['title'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <title> missing');
        }
        if (!isset($data['data'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <data> missing');
        }

        if (empty($data['type'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <type> is empty');
        }
        if (!is_string($data['type'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <type> is not a string');
        }

        if (empty($data['title'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <title> is empty');
        }
        if (!is_string($data['title'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <title> is not a string');
        }

        if (!is_array($data['data'])) {
            throw new \InvalidArgumentException('Invalid message format: attribute <data> is not an array');
        }
    }
}
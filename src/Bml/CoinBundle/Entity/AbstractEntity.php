<?php


namespace Bml\CoinBundle\Entity;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Entity
 */
class AbstractEntity
{
    /**
     * @param array $data
     * @param array $customFields
     */
    public function __construct(array $data, $customFields = [])
    {
        foreach ($data as $field => $val) {
            if (isset($customFields[$field])) {
                $field = $customFields[$field];
            }
            $this->$field = $val;
        }
    }

    /**
     * to avoid any silent errors
     * @param $field
     * @param $val
     * @throws \Exception
     */
    public function __set($field, $val)
    {
        // ignore that for now
        //throw new \Exception('Trying to set undefined field "' . $field . '"');
    }
}

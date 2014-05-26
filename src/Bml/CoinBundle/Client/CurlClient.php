<?php


namespace Bml\CoinBundle\Client;

use Bml\CoinBundle\Exception\RequestException;

/**
 * @author Damian Wróblewski <d.wroblewski@madden.pl>
 * @package Bml\CoinBundle\Client
 */
class CurlClient
{
    private $url;

    private $maxRetries;

    private $retrySleep;

    private $host;

    private $port;

    /**
     * @param $user
     * @param $password
     * @param $host
     * @param $port
     * @param string $path
     * @param string $protocol
     * @param int $maxRetries
     * @param int $retrySleep
     */
    public function __construct($user, $password, $host, $port, $path = '', $protocol = 'http', $maxRetries = 30, $retrySleep = 1)
    {
        $this->host = $host;
        $this->port = $port;
        $this->url = $protocol . '://' . $user . ':' . $password . '@' . $host . ':' . $port . '/' . $path;
        $this->maxRetries = $maxRetries;
        $this->retrySleep = $retrySleep;
    }

    /**
     * @param $method
     * @param array $params
     * @throws \Bml\CoinBundle\Exception\RequestException
     * @return string
     */
    public function request($method, array $params = [])
    {
        for ($i = 0; $i < $this->maxRetries; $i++) {
            $request = json_encode(array(
                'method' => $method,
                'params' => $params,
                'id' => uniqid()
            ));

            $curl = curl_init($this->url);
            $options = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $request,
            );
            curl_setopt_array($curl, $options);

            $content = curl_exec($curl);

            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $errNum = curl_errno($curl);
            $error = curl_error($curl);
            curl_close($curl);


            if ($status !== 200) {
                $code = $status;

                $previous = null;

                $response = json_decode($content, true);
                if (!empty($response['error'])) {
                    $previous = new \RuntimeException($response['error']['message'], $response['error']['code']);
                    $info = '[' . $response['error']['code'] . '] ' . $response['error']['message'];
                    $code = $response['error']['code'];
                } else {
                    if ($errNum == 7 && $i < $this->maxRetries - 1) {
                        sleep($this->retrySleep);
                        continue;
                    }
                    $info = '[' . $errNum . '] ' . $error;
                }
                $imploded = $this->implode($params);
                $info = 'Error while calling ' . $this->host . ':' . $this->port . ' "' . $method . '(' . $imploded . ')": ' . $info;
                throw new RequestException($info, $code, $previous);
            }

            return $content;
        }
    }

    /**
     * @param $params
     * @return string
     */
    private function implode($params)
    {
        foreach ($params as &$param) {
            if (is_array($param)) {
                $param = $this->implode($param);
            } elseif ($param === null) {
                $param = '';
            }
        }
        return '[' . implode(', ', $params) . ']';
    }

}

<?php
namespace IDNConnector;
require_once 'Constants.php';

/**
 * Connector library class
 * https://www.infradigital.io/api-docs#introduction
 *
 * Class ConnectorLibrary
 */
class ConnectorLibrary
{
    /**
     * @param $method
     * @param string $url
     * @param null $contents
     * @param array $headers
     * @return mixed
     */
    protected function curlExec($method, $url, $contents = null, array $headers = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ( ! empty($contents)) {
            $contents = (is_array($contents)) ? json_encode($contents) : $contents;
            $headers = array_merge(array('Content-Type: application/json','Content-Length: ' . strlen($contents)));
            curl_setopt($ch, CURLOPT_POSTFIELDS,$contents);
        }

        if ( ! empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, (( ! empty($method)) ? strtoupper($method) : Constants::GET_METHOD));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $jsonResponse = json_decode($response, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $jsonResponse;
        }

        return $response;
    }

    /**
     * Used to hash the password
     * SHA256(SHA256(password) + current date with format YYYYMMDD)
     *
     * @param $plainPassword
     * @return string
     */
    protected function passwordHash($plainPassword)
    {
        return hash('SHA256', (hash('SHA256', $plainPassword) . date('Ymd')));
    }

    protected function buildApiURI($username, $password, $path = '', $query = array(), $env = null)
    {
        return Constants::URI_PROTOCOL . '://'
            . $username . ':' . $password . '@'
            . (($env === Constants::DEV_ENV) ? Constants::URI_DOMAIN_DEV : Constants::URI_DOMAIN_PROD) . DIRECTORY_SEPARATOR
            . $path
            . (( ! empty($query)) ? '?' . http_build_query($query) : '');
    }

    /**
     * @param string $dateTime
     */
    protected function convertDatetimeToIso($originalDate = '')
    {
        $year = substr($originalDate, 0, 4);
        $month = substr($originalDate, 4, 2);
        $date = substr($originalDate, 6, 2);

        return date("Y-m-d\TH:i:s.000\Z", strtotime($year . '-' . $month . '-' . $date));
    }
}
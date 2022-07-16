<?php

class API {

  private $_url = 'https://explorer.kevacoin.org/api/';

  private function _file_get_contents($url) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10000);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

  public function getblockcount() {

    // API return: int
    if (false !== $response = $this->_file_get_contents($this->_url . 'getblockcount')) {

      return (int) $response;
    }

    return false;
  }

  public function getblockhash($block) {

    if (false !== $response = $this->_file_get_contents($this->_url . 'getblockhash?index=' . $block)) {

      // API return: string
      if (false !== json_decode($response)) {
        return str_replace('"', '', $response);
      }
    }

    return false;
  }

  public function getblock($hash) {

    // API return: json
    if (false !== $response = json_decode($this->_file_get_contents($this->_url . 'getblock?hash=' . $hash), true)) {
      if (isset($response['hash'])) {
        return $response;
      }
    }

    return false;
  }

  public function getrawtransaction($txid) {

    if (false !== $response = json_decode($this->_file_get_contents($this->_url . 'getrawtransaction?txid=' . $txid . '&decrypt=1'), true)) {
      if (isset($response['txid'])) {
        return $response;
      }
    }

    return false;
  }
}

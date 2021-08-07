<?php

class API {

  private $_url = 'https://explorer.kevacoin.org/api/';

  public function getblockcount() {

    // API return: int
    if (false !== $response = file_get_contents($this->_url . 'getblockcount')) {

      return (int) $response;
    }

    return false;
  }

  public function getblockhash($block) {

    if (false !== $response = file_get_contents($this->_url . 'getblockhash?index=' . $block)) {

      // API return: string
      if (false !== json_decode($response)) {
        return str_replace('"', '', $response);
      }
    }

    return false;
  }

  public function getblock($hash) {

    // API return: json
    if (false !== $response = json_decode(file_get_contents($this->_url . 'getblock?hash=' . $hash), true)) {
      if (isset($response['hash'])) {
        return $response;
      }
    }

    return false;
  }

  public function getrawtransaction($txid) {

    if (false !== $response = json_decode(file_get_contents($this->_url . 'getrawtransaction?txid=' . $txid . '&decrypt=1'), true)) {
      if (isset($response['txid'])) {
        return $response;
      }
    }

    return false;
  }
}

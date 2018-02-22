<?php

namespace OneCRM\APIClient;

class Error extends \Exception {

    protected $hint;
    protected $error_type;

    public static function fromAPIResponse($code, $response) {
        if (is_array($response)) {
            $message = "";
            $hint = null;
            $type = null;
            if (isset($response['message']))
                $message = $response['message'];
            if (isset($response['error']))
                $type = $response['error'];
            if (isset($response['hint']))
                $hint = $response['hint'];
            $error = new Error($message, $code);
            $error->error_type = $type;
            $error->hint = $hint;
            return $error;
        } else {
            return new Error((string)$response, $code);
        }
    }

    public function getHint() {
        return $this->hint;
    }

    public function getType() {
        return $this->error_type;
    }
}

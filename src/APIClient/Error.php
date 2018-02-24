<?php

namespace OneCRM\APIClient;

/**
 * Represents an API error
 */
class Error extends \Exception {

    protected $hint;
    protected $error_type;

    /**
     * Creates an error object from API reply
     */
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

    /**
     * Gets error hint
     * 
     * 1CRM REST API can return hint with an error to suggest a possible
     * fix.
     */
    public function getHint() {
        return $this->hint;
    }

    /**
     * Gets error type returned from 1CRM REST API 
     */
    public function getType() {
        return $this->error_type;
    }
}

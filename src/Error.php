<?php

namespace OneCRM\APIClient;

use Exception;

/**
 * Represents an API error
 */
class Error extends Exception
{
    protected ?string $hint;

    protected ?string $error_type;

    /**
     * Creates an error object from API reply
     *
     * @param  array<string, mixed>|string  $response
     */
    public static function fromAPIResponse(int $code, array|string $response): Error
    {
        if (is_array($response)) {
            $message = '';
            $hint = null;
            $type = null;
            if (isset($response['message'])) {
                $message = $response['message'];
            }
            if (isset($response['error'])) {
                $type = $response['error'];
            }
            if (isset($response['hint'])) {
                $hint = $response['hint'];
            }
            $error = new Error($message, $code);
            $error->error_type = $type;
            $error->hint = $hint;

            return $error;
        }

        return new Error($response, $code);
    }

    /**
     * Gets error hint
     *
     * 1CRM REST API can return hint with an error to suggest a possible
     * fix.
     */
    public function getHint(): ?string
    {
        return $this->hint;
    }

    /**
     * Gets error type returned from 1CRM REST API
     */
    public function getType(): ?string
    {
        return $this->error_type;
    }
}

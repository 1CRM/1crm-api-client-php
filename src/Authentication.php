<?php

namespace OneCRM\APIClient;

/**
 * Authorization scheme interface
 */
interface Authentication
{
    /**
     * Modifies request options to apply authorization scheme
     *
     * @param  array<string,mixed>  $options
     */
    public function applyRequestOptions(array &$options): void;
}

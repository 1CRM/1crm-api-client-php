<?php

namespace OneCRM\APIClient;

use Exception;

/**
 * Upload and download files
 */
class Files
{
    public function __construct(protected Client $client)
    {
        //
    }

    /**
     * Uploads a temporary file
     *
     * You can pass file contents using $res parameter in a number of ways:
     *      * use a string with file content
     *      * use resource returned by a call to fopen()
     *      * use a stream resource
     *
     * @param  mixed  $res File content
     * @param  string  $filename File name
     * @param  string  $content_type File content type
     * @return string Temporary file ID.
     *
     * @throws Error
     */
    public function upload(mixed $res, string $filename, string $content_type = 'application/octet-stream'): string
    {
        $endpoint = '/files/upload';
        $options = [
            'headers' => [
                'Content-Type' => $content_type,
                'X-OneCrm-Filename' => $filename,
            ],
            'body' => $res,
        ];
        $result = $this->client->request('POST', $endpoint, $options);

        return $result['id'];
    }

    /**
     * Downloads a file
     *
     * Use this method to download a file attached to document, document revision or
     * note.
     *
     * @param  string  $model One of `Note`, `Document`, `DocumentRevision`
     * @param  string  $id Document, revision, or note ID
     * @param  mixed  $res String with file name or stream resource. Optional, if present, downloaded
     * file content will be saved to file or written to stream
     * @return mixed A stream resource with contents of the file
     *
     * @throws Error
     */
    public function download(string $model, string $id, mixed $res = null): mixed
    {
        $endpoint = '/files/download/'.$model.'/'.$id;
        $options = [
            'skip_body_parsing' => true,
        ];
        $body = $this->client->get($endpoint, $options);
        if (! is_null($res)) {
            $fh = null;
            $is_stream = is_resource($res) && get_resource_type($res) === 'stream';
            try {
                if ($is_stream) {
                    $fh = $res;
                } elseif (is_string($res)) {
                    $fh = @fopen($res, 'wb');
                }
                if (! $fh) {
                    throw new Error('Cannot open file for writing');
                }
                while (! $body->eof()) {
                    $data = $body->read(16384);
                    fwrite($fh, $data);
                }
            } catch (Exception $e) {
                throw new Error($e->getMessage(), $e->getCode(), $e);
            } finally {
                if (! $is_stream && $fh) {
                    fclose($fh);
                }
            }
        }

        return $body;
    }

    /**
     * Retrieves information about a file
     *
     * Use this method to get information about a file attached to document, document revision or
     * note
     *
     * @param  string  $model One of `Note`, `Document`, `DocumentRevision`
     * @param  string  $id Document, revision, or note ID
     * @return array<string, mixed> Array with file info
     *
     * @throws Error
     */
    public function info(string $model, string $id): array
    {
        $endpoint = '/files/info/'.$model.'/'.$id;

        return $this->client->get($endpoint);
    }
}

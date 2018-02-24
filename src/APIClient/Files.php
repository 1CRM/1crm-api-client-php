<?php

namespace OneCRM\APIClient;

/**
 * used to upload and download files
 */
class Files {

    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Uploads a temporary file
     * 
     * You can pass file contents using $res parameter in a number of ways:
     *      * use a string with file content
     *      * use resource returned by a call to fopen()
     *      * use a stream resource
     * 
     * @param $res File content
     * @param $filename File name
     * @param content_type File content type
     * 
     * @return Temporary file ID.
     * @throws Error
     */
    public function upload($res, $filename, $content_type = 'application/octet-stream') {
        $endpoint = '/files/upload';
        $options = [
            'headers' => [
                'Content-Type' => $content_type,
                'X-OneCrm-Filename' => $filename
            ],
            'body' => $res
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
     * @param $model One of `Note`, `Document`, `DocumentRevision`
     * @param $id Document, revision, or note ID
     * @param $res String with file name or stream resource. Optional, if present, downloaded
     * file content will be saved to file or written to stream
     * 
     * @return A stream resource with contents of the file
     * @throws Error
     */
    public function download($model, $id, $res = null) {
        $endpoint = '/files/download/' . $model . '/' . $id;
        $options = [
            'skip_body_parsing' => true
        ];
        $body = $this->client->request('GET', $endpoint, $options);
        if (!is_null($res)) {
            $fh = null;
            $is_stream = is_resource($res) && get_resource_type($res) === 'stream';
            try {
                if ($is_stream) {
                    $fh = $res;
                } else if (is_string($res)) {
                    $fh = @fopen($res, 'wb');
                    if (!$fh) throw new Error("Cannot open file for writing");
                }
                while (!$body->eof()) {
                    $data = $body->read(16384);
                    fwrite($fh, $data);
                }
            } catch (\Exception $e) {
                throw new Error($e->getMessage(), $e->getCode(), $e);
            } finally {
                if (!$is_stream && $fh)
                    fclose($fh);
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
     * @param $model One of `Note`, `Document`, `DocumentRevision`
     * @param $id Document, revision, or note ID
     * 
     * @return Array with file info
     * @throws Error
     */
    public function info($model, $id) {
        $endpoint = '/files/info/' . $model . '/' . $id;
        return $this->client->get($endpoint);
    }

}


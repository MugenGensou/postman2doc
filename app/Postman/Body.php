<?php

namespace App\Postman;


use App\Markdown\Markdownable;

class Body implements Markdownable
{
    /**
     * @var string
     */
    protected $title = 'BODY';

    /**
     * @var array
     */
    protected $bodyTitle = ['key', 'type', 'value', 'description'];

    /**
     * @var array
     */
    protected $body = [];

    /**
     * @var string
     */
    protected $rawBody;

    /**
     * Body constructor.
     * @param array $body
     */
    public function __construct(array $body)
    {
        empty($body) || $this->parseBody($body);
    }

    /**
     * @param array $body
     */
    protected function parseBody(array $body)
    {
        switch ($body['mode']) {
            case 'raw':
                $raw     = $body['raw'];
                $rawData = json_decode($raw, true);
                $data    = [];

                if (json_last_error() === 0) {
                    foreach ($rawData as $key => $value) {
                        $type = gettype($value);
                        $type === 'array' && $value = json_encode($value);

                        $data[] = [
                            'key'   => $key,
                            'type'  => $type,
                            'value' => $value,
                        ];
                    }
                }
                break;
            case 'formdata':
                $data = $body['formdata'];
                break;
            case 'urlencoded':
                $data = $body['urlencoded'];
                break;
            default:
                $data = [];
                break;
        }

        $this->setBody($data);

        isset($raw) && $this->setRawBody($raw);
    }

    /**
     * @param array $body
     */
    protected function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * @param $rawBody
     */
    protected function setRawBody($rawBody): void
    {
        $this->rawBody = $rawBody;
    }

    public function hasBody(): bool
    {
        return count($this->body);
    }

    /**
     * @return string
     */
    public function toMarkdown(): string
    {
        $writer = app('writer');

        $writer->table($this->bodyTitle, $this->body);

        empty($this->rawBody) || $writer->code($this->rawBody, true);

        return $writer->toString();
    }
}
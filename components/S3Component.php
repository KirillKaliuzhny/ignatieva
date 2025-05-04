<?php

namespace app\components;

use yii\base\Component;
use Aws\S3\S3Client;

class S3Component extends Component
{
    public string $key;
    public string $secret;
    public string $region;
    public string $endpoint;
    public string $bucket;

    private S3Client|null $_client = null;

    public function getClient(): S3Client
    {
        if ($this->_client === null) {
            $this->_client = new S3Client([
                'version' => 'latest',
                'region' => $this->region,
                'endpoint' => $this->endpoint,
                'use_path_style_endpoint' => true,
                'credentials' => [
                    'key' => $this->key,
                    'secret' => $this->secret,
                ],
            ]);
        }

        return $this->_client;
    }
}

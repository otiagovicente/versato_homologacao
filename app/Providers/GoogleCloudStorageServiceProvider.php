<?php

namespace App\Providers;

use CedricZiel\FlysystemGcs\GoogleCloudStorageAdapter;
use Google\Cloud\ServiceBuilder;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Storage;

/**
 * Class CloudStorageServiceProvider
 * Configures Google Cloud Storage Access for flysystem
 *
 * @package Websight\GcsProvider
 */
class GoogleCloudStorageServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        Storage::extend('gcs', function ($app, $config) {

            $adapterConfiguration = ['bucket' => $config['bucket']];
            $serviceBuilderConfig = [];

            $optionalServiceBuilder = null;

            if (array_key_exists('project_id', $config) && false === empty($config['project_id'])) {
                $adapterConfiguration += ['projectId' => $config['project_id']];
                $serviceBuilderConfig += ['projectId' => $config['project_id']];
            }

            if (array_key_exists('credentials', $config) && false === empty($config['credentials'])) {
				putenv('GOOGLE_APPLICATION_CREDENTIALS='.$config['credentials']);
                
				$serviceBuilderConfig += ['keyFilePath' => $config['credentials']];
                $optionalServiceBuilder = new ServiceBuilder($serviceBuilderConfig);
				$optionalServiceBuilder = $optionalServiceBuilder->storage($adapterConfiguration);
            }
			
			
			//dd($serviceBuilderConfig);die;

            $adapter = new GoogleCloudStorageAdapter($optionalServiceBuilder, $adapterConfiguration);

            return new Filesystem($adapter);
        });
    }
}
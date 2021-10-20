<?php

use AcMarche\Bce\Import\ImportHandler;
use AcMarche\Bce\Import\ImportHandlerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_locator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set('bottin.url_update_category', '%env(BOTTIN_URL_UPDATE_CATEGORY)%');
    $parameters->set('es_config', ['hosts' => 'http://localhost:9200']);

    $services = $containerConfigurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->private();

    $services->load('AcMarche\Bottin\\', __DIR__.'/../src/*')
        ->exclude([__DIR__.'/../src/{Entity,Tests}']);

    $services->set(Elasticsearch\ClientBuilder::class);

    $services->set(Elasticsearch\Client::class)
        ->factory('@Elasticsearch\ClientBuilder::fromConfig')
        ->args(['%es_config%']);

    $services->alias(SearchEngineInterface::class, SearchElastic::class);

    /**
     * va pas ici alors mis dans AcMarcheBottinExtension
     */
    $services->instanceof(ImportHandlerInterface::class)
        ->tag('bottin.import');

    $services->set(ImportHandler::class)
        ->args([
            '$handlers' => tagged_iterator('bottin.import'),
            '$serviceLocator' => tagged_locator('bottin.import', 'key', 'getDefaultIndexName'),
        ]);
};

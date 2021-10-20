<?php

use AcMarche\Bce\Import\ImportHandler;
use AcMarche\Bce\Import\ImportHandlerInterface;
use AcMarche\Bce\Search\SearchElastic;
use AcMarche\Bce\Search\SearchEngineInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_locator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    //$parameters->set('bce.x', '%env(BOTTIN_URL_UPDATE_CATEGORY)%');
    //$parameters->set('bce.es_config', ['hosts' => 'http://localhost:9200']);

    $services = $containerConfigurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->private();

    $services->load('AcMarche\Bce\\', __DIR__.'/../src/*')
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
            '$handlers' => tagged_iterator('bce.import'),
            '$serviceLocator' => tagged_locator('bce.import', 'key', 'getDefaultIndexName'),
        ]);
};

<?php

namespace AcMarche\Bce\Elasticsearch;

use Elastica\Mapping;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * https://elasticsearch-cheatsheet.jolicode.com/
 * Class ElasticServer.
 */
class ElasticServer
{
    use ElasticClientTrait;

    final public const INDEX_NAME_VISIT_FR = 'cbe';
    const INDEX_NAME_SERVER = 'bottin';

    public function __construct()
    {
        $this->connect();
    }

    public function createIndex(): void
    {
        try {
            $analyser = Yaml::parse(file_get_contents(__DIR__.'/mappings/analyzers.yaml'));
            $settings = Yaml::parse(file_get_contents(__DIR__.'/mappings/settings.yaml'));
        } catch (ParseException $parseException) {
            printf('Unable to parse the YAML string: %s', $parseException->getMessage());

            return;
        }

        $settings['settings']['analysis'] = $analyser;
        $response = $this->index->create($settings, true);
        dump($response);
    }

    public function setMapping(): void
    {
        try {
            $properties = Yaml::parse(file_get_contents(__DIR__.'/mappings/mapping.yaml'));
            $mapping = new Mapping($properties['mappings']['properties']);
            $response = $this->index->setMapping($mapping);
            dump($response);
        } catch (ParseException $parseException) {
            printf('Unable to parse the YAML string: %s', $parseException->getMessage());
        }
    }
}

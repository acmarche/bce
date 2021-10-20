<?php

namespace AcMarche\Bce\Search;

interface SearchEngineInterface
{
    /**
     * @return iterable|\Elastica\ResultSet
     */
    public function doSearch(string $keyword, ?string $localite = null): iterable;

    /**
     * @return iterable|\Elastica\ResultSet
     */
    public function doSearchAdvanced(string $keyword, ?string $localite = null): iterable;
}

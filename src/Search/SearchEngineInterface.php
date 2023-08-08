<?php

namespace AcMarche\Bce\Search;

interface SearchEngineInterface
{
    public function doSearch(string $keyword, string $localite = null): iterable;

    public function doSearchAdvanced(string $keyword, string $localite = null): iterable;
}

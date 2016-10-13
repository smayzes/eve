<?php

namespace App\Loader;

use Illuminate\Support\Collection;

final class JsonLoader implements CollectionLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($path): Collection
    {
        return new Collection(json_decode(file_get_contents($path), true));
    }
}

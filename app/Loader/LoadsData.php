<?php

namespace App\Loader;

use Illuminate\Support\Collection;
use App\Exceptions\NoLoaderException;

trait LoadsData
{
    /**
     * @var Collection
     */
    private $data;

    /**
     * @param string $path
     */
    public function loadData($path)
    {
        if (! $this->loader) {
            throw new NoLoaderException();
        }

        if (! $this->data) {
            $this->data = $this->loader->load($path);
        }
    }
}

<?php

declare(strict_types=1);

namespace Victor\Catalog;

class CatalogEntry
{
    /**
     * The unique id of the catalog
     *
     * @var string
     */
    public $id;

    /**
     * The catetory/kind for the entry
     *
     * @var string
     */
    public $category;

    /**
     * The data properties for the given entry
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Construct the catalog entry
     *
     * @param string $path (the fully qualified path name)
     */
    public function __construct(string $path = null)
    {
        if (!$path) {
            return;
        } elseif (!file_exists($path)) {
            throw new \Exception(static::class . ': Invalid file');
        }

        $this->parsePath($path);

        if (false !== ($contents = file_get_contents($path))) {
            $this->buildData($contents);
        }
    }

    /**
     * Get the value of one of the fields if there is one, otherwise null
     *
     * @param string $key
     * @return mixed|null
     */
    public function __get(string $key)
    {
        return $this->properties[$key] ?? null;
    }

    /**
     * Enable isset checking for properties
     *
     * @param string $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return !!($this->properties[$key] ?? null);
    }

    /**
     * Build the entry field => value data
     *
     * @param string $data
     * @return void
     */
    public function buildData(string $data)
    {
        foreach (explode("\n", $data) as $record) {
            if (!empty(($record = trim($record)))) {
                $parts = explode('=', $record);

                if (count($parts) !== 2) {
                    throw new \Exception(static::class . ': Invalid data');
                }

                [$field, $value] = $parts;

                $field = trim($field);

                if (empty($field)) {
                    throw new \Exception(static::class . ': Invalid data');
                }

                $this->properties[$field] = trim($value);
            }
        }
    }

    /**
     * Parse the path and extract the id and type for the entry
     *
     * @param string $path
     * @return void
     */
    public function parsePath(string $path): void
    {
        $parts = explode('/', $path);

        $this->id = array_pop($parts);
        $this->category = array_pop($parts);
    }
}

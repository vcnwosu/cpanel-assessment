<?php

declare(strict_types=1);

namespace Victor;

use Victor\Catalog\CatalogEntry;

class DigitalCatalog
{
    /**
     * The catalog data structure
     *
     * @var \Victor\Catalog\CatalogEntry[]
     */
    protected $catalog = [];

    /**
     * A mapping of entry IDs to catalog index location
     *
     * @var array
     */
    protected $map = [];

    /**
     * Construct the digital catalog
     *
     * @param string $path (the fully qualified path name)
     */
    public function __construct(string $path)
    {
        if (!is_dir($path)) {
            throw new \Exception(static::class . ': Catalog does not exist');
        }

        $res = shell_exec("find $path -type f");

        if (empty($res)) {
            return;
        }

        $index = 0;

        foreach (explode("\n", trim($res)) as $file) {
            $entry = new CatalogEntry($file);

            $this->catalog[] = $entry;
            $this->map[$entry->id] = $index++;
        }
    }

    /**
     * Get a list of entries based on the given field and value
     *
     * @param string $field
     * @param mixed $value
     * @return \Victor\Catalog\CatalogEntry[]
     */
    public function getEntriesBy(string $field, $value): array
    {
        $values = array_column($this->catalog, $field, 'id');
        $values = array_intersect_key($this->map, $values);

        $entries = [];

        foreach ($values as $key => $index) {
            $entry = $this->catalog[$index];

            if ($entry->{$field} == $value) {
                $entries[] = strval($key);
            }
        }

        return $entries;
    }

    /**
     * Helper method to determine if catalog is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->catalog);
    }
}


# PHP Skills Assessment Exercise

This library provides a simple list interface for listing entries in a digital catalog based on a data field. The digital catalog implementation is in the form of a hierarchical file system such as the following:

```
/catalog
|__ /book
|   |__ 0123456789
|
|__ /audio
    |__ 2223456789012
```

Each entry (ie. 0123456789) is a plain text file with simple `key=value` pairs, each on their own line, with the filename (ie. 0123456789) being its unique identifier. It is guaranteed that no two identifiers will ever be the same.

## Usage

```
use Victor\DigitalCatalog;

$catalog = new DigitalCatalog('/path/to/catalog');

$entries = $catalog->getEntriesBy('title', 'PHP in a Nutshell');

print_r($entries);
/**
 * Array
 * (
 *     [0] => 123456789
 * )
 */
```

## Tests

`cd` into the `tests` directory and execute the `./run` script.

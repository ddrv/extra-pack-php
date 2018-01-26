[![Packagist](https://img.shields.io/packagist/v/ddrv/extrapack.svg?style=flat-square)](https://packagist.org/packages/ddrv/extrapack)
[![Downloads](https://img.shields.io/packagist/dt/ddrv/extrapack.svg?style=flat-square)](https://packagist.org/packages/ddrv/extrapack/stats)
[![License](https://img.shields.io/packagist/l/ddrv/extrapack.svg?style=flat-square)](https://github.com/ddrv/extrapack/blob/master/LICENSE)
[![PHP](https://img.shields.io/packagist/php-v/ddrv/extrapack.svg?style=flat-square)](https://php.net)

# ExtraPack

> Extras for pack() and unpack() functions.

# Install

```text
composer require ddrv/extra-pack
```

```php
<?php
require ('vendor/autoload.php');
```

# Usage

```php
<?php
$data = array(
    'key1' => 'string',
    'key2' => 5,
    'key3' => .0001
);
$format = 'A6key1/Ckey2/t4key3';
$binary = \Ddrv\Extra\Pack::pack($format, $data);
$result = \Ddrv\Extra\Pack::pack($format, $binary);
print_r($result);
```

```text
Array
(
    [key1] => string
    [key2] => 5
    [key3] => .0001
)
```

# Format characters

Currently implemented formats are:

|Code|Is extras|Description|Support from PHP version|
|---|---|---|---|
|a|No|NUL-padded string|5.0|
|A|No|SPACE-padded string|5.0|
|h|No|Hex string, low nibble first|5.0|
|H|No|Hex string, high nibble first|5.0|
|c|No|signed char|5.0|
|C|No|unsigned char|5.0|
|s|No|signed short (always 16 bit, machine byte order)|5.0|
|S|No|unsigned short (always 16 bit, machine byte order)|5.0|
|n|No|unsigned short (always 16 bit, big endian byte order)|5.0|
|v|No|unsigned short (always 16 bit, little endian byte order)|5.0|
|i|No|signed integer (machine dependent size and byte order)|5.0|
|I|No|unsigned integer (machine dependent size and byte order)|5.0|
|l|No|signed long (always 32 bit, machine byte order)|5.0|
|L|No|unsigned long (always 32 bit, machine byte order)|5.0|
|N|No|unsigned long (always 32 bit, big endian byte order)|5.0|
|V|No|unsigned long (always 32 bit, little endian byte order)|5.0|
|q|No|signed long long (always 64 bit, machine byte order)|5.6.3|
|Q|No|unsigned long long (always 64 bit, machine byte order)|5.6.3|
|J|No|unsigned long long (always 64 bit, big endian byte order)|5.6.3|
|P|No|unsigned long long (always 64 bit, little endian byte order)|5.6.3|
|f|No|float (machine dependent size and representation)|5.0|
|g|No|float (machine dependent size, little endian byte order)|7.0.15, 7.1.1|
|G|No|float (machine dependent size, big endian byte order)|7.0.15, 7.1.1|
|d|No|double (machine dependent size and representation)|5.0|
|e|No|double (machine dependent size, little endian byte order)|7.0.15, 7.1.1|
|E|No|double (machine dependent size, big endian byte order)|7.0.15, 7.1.1|
|x|No|NUL byte|5.0|
|X|No|Back up one byte|5.0|
|Z|No|NUL-padded string (new in PHP 5.5)|5.5.0|
|@|No|NUL-fill to absolute position|5.0|
|m|Yes|signed medium (always 24 bit, machine byte order)|5.0|
|M|Yes|unsigned medium (always 24 bit, machine byte order)|5.0|
|t|Yes|signed tiny rounded (always 8 bit, machine byte order)|5.0|
|T|Yes|unsigned tiny rounded (always 8 bit, machine byte order)|5.0|
|o|Yes|signed short rounded (always 16 bit, machine byte order)|5.0|
|O|Yes|unsigned short rounded (always 16 bit, machine byte order)|5.0|
|r|Yes|signed medium rounded (always 24 bit, machine byte order)|5.0|
|R|Yes|unsigned medium rounded (always 24 bit, machine byte order)|5.0|
|b|Yes|signed big rounded (always 32 bit, machine byte order)|5.0|
|B|Yes|unsigned big rounded (always 32 bit, machine byte order)|5.0|

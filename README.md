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
$result = \Ddrv\Extra\Pack::unpack($format, $binary);
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

# Format

```text
character[+number]+key[+:added]
```

Elements are separated by a slash

Examples:

|Format|Key|Result|
|---|---|---|
|A6name|name|string with length 6|
|Coffset:2000|offset|Number from 0 to 255 + 2000|


# Format characters

Currently implemented formats are:

|Character|Is extras|Description|Support from PHP version|Number|Added|
|---|---|---|---|---|---|
|a|No|NUL-padded string|5.0|Length of string|No|
|A|No|SPACE-padded string|5.0|Length of string|No|
|h|No|Hex string, low nibble first|5.0|Count repetitions|No|
|H|No|Hex string, high nibble first|5.0|Count repetitions|No|
|c|No|signed char|5.0|Count repetitions|Added number|
|C|No|unsigned char|5.0|Count repetitions|Added number|
|s|No|signed short (always 16 bit, machine byte order)|5.0|Count repetitions|Added number|
|S|No|unsigned short (always 16 bit, machine byte order)|5.0|Count repetitions|Added number|
|n|No|unsigned short (always 16 bit, big endian byte order)|5.0|Count repetitions|Added number|
|v|No|unsigned short (always 16 bit, little endian byte order)|5.0|Count repetitions|Added number|
|i|No|signed integer (machine dependent size and byte order)|5.0|Count repetitions|Added number|
|I|No|unsigned integer (machine dependent size and byte order)|5.0|Count repetitions|Added number|
|l|No|signed long (always 32 bit, machine byte order)|5.0|Count repetitions|Added number|
|L|No|unsigned long (always 32 bit, machine byte order)|5.0|Count repetitions|Added number|
|N|No|unsigned long (always 32 bit, big endian byte order)|5.0|Count repetitions|Added number|
|V|No|unsigned long (always 32 bit, little endian byte order)|5.0|Count repetitions|Added number|
|q|No|signed long long (always 64 bit, machine byte order)|5.6.3|Count repetitions|Added number|
|Q|No|unsigned long long (always 64 bit, machine byte order)|5.6.3|Count repetitions|Added number|
|J|No|unsigned long long (always 64 bit, big endian byte order)|5.6.3|Count repetitions|Added number|
|P|No|unsigned long long (always 64 bit, little endian byte order)|5.6.3|Count repetitions|Added number|
|f|No|float (machine dependent size and representation)|5.0|Count repetitions|Added number|
|g|No|float (machine dependent size, little endian byte order)|7.0.15, 7.1.1|Count repetitions|Added number|
|G|No|float (machine dependent size, big endian byte order)|7.0.15, 7.1.1|Count repetitions|Added number|
|d|No|double (machine dependent size and representation)|5.0|Count repetitions|Added number|
|e|No|double (machine dependent size, little endian byte order)|7.0.15, 7.1.1|Count repetitions|Added number|
|E|No|double (machine dependent size, big endian byte order)|7.0.15, 7.1.1|Count repetitions|Added number|
|x|No|NUL byte|5.0|Count repetitions|No|
|X|No|Back up one byte|5.0|Count repetitions|No|
|Z|No|NUL-padded string (new in PHP 5.5)|5.5.0|Count repetitions|No|
|@|No|NUL-fill to absolute position|5.0|Count repetitions|No|
|m|Yes|signed medium (always 24 bit, machine byte order)|5.0|Count repetitions|Added number|
|M|Yes|unsigned medium (always 24 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|t|Yes|signed tiny rounded (always 8 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|T|Yes|unsigned tiny rounded (always 8 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|o|Yes|signed short rounded (always 16 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|O|Yes|unsigned short rounded (always 16 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|r|Yes|signed medium rounded (always 24 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|R|Yes|unsigned medium rounded (always 24 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|b|Yes|signed big rounded (always 32 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|
|B|Yes|unsigned big rounded (always 32 bit, machine byte order)|5.0|Number of digits after the decimal point|Added number|

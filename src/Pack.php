<?php

namespace Ddrv\Extra;

class Pack
{
    protected static function getSize($character)
    {
        switch ($character) {
            case 'c': // no break
            case 'C': // no break
            case 't': // no break
            case 'h': // no break
            case 'H': // no break
            case 'T': return 1;
            case 's': // no break
            case 'S': // no break
            case 'n': // no break
            case 'v': // no break
            case 'o': // no break
            case 'O': return 2;
            case 'm': // no break
            case 'M': // no break
            case 'r': // no break
            case 'R': return 3;
            case 'l': // no break
            case 'L': // no break
            case 'N': // no break
            case 'V': // no break
            case 'b': // no break
            case 'B': return 4;
            case 'q': // no break
            case 'Q': // no break
            case 'J': // no break
            case 'P': return 8;
            default:
                if (in_array($character, array('I','i','f','G','g','d','E','e'))) {
                    return strlen(pack($character, 1));
                }
                return false;
        }
    }

    /**
     * @param string $format
     * @param array $data
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function pack($format, $data)
    {
        $result = '';
        $pack = self::parseFormat($format);
        foreach ($pack as $key=>$meta) {
            if (!in_array($meta['character'], array('@','x','X')) && !array_key_exists($key, $data)) {
                throw new \InvalidArgumentException('undefined index '.$key.' in data array');
            }
            $packValue = isset($data[$key])?$data[$key]:null;
            if (!empty($meta['added'])) {
                $packValue = $data[$key]-$meta['added'];
            }

            switch ($meta['character']) {
                case '@':
                    if(empty($meta['number'])) $meta['number'] = 1;
                    $result = substr($result,0,$meta['number']);
                    break;
                case '#':
                    $result .= \pack('A*x1', $packValue);
                    break;
                case 'x':
                    $result .= \pack($meta['character'].$meta['number']);
                    break;
                case 'X':
                    if(empty($meta['number'])) $meta['number'] = 1;
                    $result = substr($result,0,-$meta['number']);
                    break;
                case 't':
                    $result .= \pack('c', (int)($packValue*pow(10,$meta['number'])));
                    break;
                case 'T':
                    $result .= \pack('C', (int)($packValue*pow(10,$meta['number'])));
                    break;
                case 'o':
                    $result .= \pack('s', (int)($packValue*pow(10,$meta['number'])));
                    break;
                case 'O':
                    $result .= \pack('S', (int)($packValue*pow(10,$meta['number'])));
                    break;
                case 'r':
                    $result .= substr(\pack('l', (int)($packValue*pow(10,$meta['number']))),0,3);
                    break;
                case 'R':
                    $result .= substr(\pack('L', (int)($packValue*pow(10,$meta['number']))),0,3);
                    break;
                case 'b':
                    $result .= \pack('l', (int)($packValue*pow(10,$meta['number'])));
                    break;
                case 'B':
                    $result .= \pack('L', (int)($packValue*pow(10,$meta['number'])));
                    break;
                case 'm':
                    $result .= substr(\pack('l', $packValue),0,3);
                    break;
                case 'M':
                    $result .= substr(\pack('L', $packValue),0,3);
                    break;
                default:
                    if(empty($meta['number'])) $meta['number'] = 1;
                    $result .= \pack($meta['character'].$meta['number'], $packValue);
                    break;
            }
        }
        return $result;
    }

    /**
     * @param string $format
     * @param string $string
     * @param bool $trim
     * @return array
     */
    public static function unpack($format, $string, $trim=true)
    {
        $result = array();
        $pack = self::parseFormat($format);
        foreach ($pack as $key=>$meta) {
            $len = self::getSize($meta['character']);
            if (!$len) {
                if ($meta['number'] == '*') {
                    $len = strlen($string);
                } elseif ($meta['character'] == '#') {
                    $len = strpos($string, "\0");
                    if ($len === false) {
                        $len = strlen($string);
                    } else {
                        $len++;
                    }
                } else {
                    $len = $meta['number'];
                }
            }
            $bin = substr($string,0,$len);
            $string = substr($string,$len);
            switch ($meta['character']) {
                case '@': // no break
                case 'x': // no break
                case 'X':
                    break;
                case '#': // no break
                case 'a': // no break
                case 'A':
                    $result[$key] = $bin;
                    break;
                case 't':
                    $array = \unpack('ckey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'T':
                    $array = \unpack('Ckey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'o':
                    $array = \unpack('skey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'O':
                    $array = \unpack('Skey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'r':
                    $bin .= (ord($bin{2}) >> 7 ? "\xff" : "\0");
                    $array = \unpack('lkey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'R':
                    $bin .= (ord($bin{2}) >> 7 ? "\xff" : "\0");
                    $array = \unpack('Lkey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'b':
                    $array = \unpack('lkey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'B':
                    $array = \unpack('Lkey', $bin);
                    $result[$key] = $array['key']/pow(10,$meta['number']);
                    break;
                case 'm':
                    $bin .= (ord($bin{2}) >> 7 ? "\xff" : "\0");
                    $array = \unpack('lkey', $bin);
                    $result[$key] = $array['key'];
                    break;
                case 'M':
                    $bin .= (ord($bin{2}) >> 7 ? "\xff" : "\0");
                    $array = \unpack('Lkey', $bin);
                    $result[$key] = $array['key'];
                    break;
                default:
                    $array = \unpack($meta['character'].$meta['number'].'key', $bin);
                    $result[$key] = $array['key'];
                    break;
            }
            if (!empty($meta['added']) && isset($result[$key])) {
                $result[$key] += $meta['added'];
            }
            if ($trim && is_string($result[$key])) {
                $result[$key] = trim($result[$key]);
            }
        }
        return $result;
    }

    /**
     * @param mixed $minimal
     * @param mixed $maximal
     * @param string $key
     * @param int $precision
     * @return string
     */
    public static function getOptimalFormat($minimal, $maximal, $key='key', $precision=0)
    {
        if ($minimal > $maximal) {
            $tmp = $maximal;
            $maximal = $minimal;
            $minimal = $tmp;
            unset($tmp);
        }
        $maximal = (int)($maximal*pow(10, $precision));
        $minimal = (int)($minimal*pow(10, $precision));
        $character = 'd';
        $difference = $maximal-$minimal;
        $checkedAdded = $added = $maximal - $difference;
        if (is_int($difference)) {
            $character = $precision?'B':'L';
            $added = $maximal - $difference;
            if ($checkedAdded && $checkedAdded < (1 << 31)) {
                $character = $precision?'b':'l';
                $added = $maximal - $difference + (1 << 31);
            }
            if ($maximal < (1 << 24)) {
                $character = $precision?'R':'M';
                $added = $maximal - $difference;
                if ($checkedAdded && $checkedAdded < (1 << 23)) {
                    $character = $precision?'r':'m';
                    $added = $maximal - $difference + (1 << 23);
                }
            }
            if ($maximal < (1 << 16)) {
                $character = $precision?'O':'S';
                $added = $maximal - $difference;
                if ($checkedAdded && $checkedAdded < (1 << 15)) {
                    $character = $precision?'o':'s';
                    $added = $maximal - $difference + (1 << 15);
                }
            }
            if ($maximal < (1 << 8)) {
                $character = $precision?'T':'C';
                $added = $maximal - $difference;
                if ($checkedAdded && $checkedAdded < (1 << 7)) {
                    $character = $precision?'t':'c';
                    $added = $maximal - $difference + (1 << 7);
                }
            }
        }
        $number = $precision?$precision:'';
        return $character.$number.$key.($added?':'.$added:'');
    }

    /**
     * @param string $format
     * @return array
     * @throws \InvalidArgumentException
     */
    protected static function parseFormat($format)
    {
        $result = array();
        $regexp = '/^'
            .'(?<character>[ahcsnvilqfgdexmtorbAHCSNVILQJPGEXZMTORB\@\#])'
            .'(?<number>(\d+|\*))?'
            .'(?<key>[^\d:][^:]*)'
            .'(:(?<added>(\-)?(\d+(\.\d+)?|\.\d+)))?'
            .'$/u';
        $array = explode('/', $format);
        foreach ($array as $item) {
            preg_match($regexp, $item, $match);

            /*
             * Check correct format part
             */
            if (!isset($match['character']) || !isset($match['key'])) {
                throw new \InvalidArgumentException('incorrect format ('.$item.')');
            }

            /*
             * Check correct character for number
             */
            if (empty($match['number'])) {
                $match['number'] = '';
                if (strpos('abort@ZABORT', $match['character']) !== false) {
                    throw new \InvalidArgumentException(
                        'number can not be empty for character '.$match['character']
                        .' ('.$item.')'
                    );
                }
            } else {
                if (strpos('bortx@BORTZX#', $match['character']) !== false && $match['number'] == '*') {
                    throw new \InvalidArgumentException(
                        'incorrect number * for character '.$match['character']
                        .' ('.$item.')'
                    );
                } elseif (strpos('boratx@BORATZX#', $match['character']) === false) {
                    throw new \InvalidArgumentException(
                        'number must be empty for character '.$match['character']
                        .' ('.$item.')'
                    );
                }
            }

            /*
             * Check correct character for number
             */
            if (empty($match['added'])) {
                $match['added'] = 0;
            } else {
                if (strpos('cslnvqfgdtrombCSLNVQJPGETROMB#', $match['character']) === false) {
                    throw new \InvalidArgumentException(
                        'added must be empty for character '.$match['character']
                        .' ('.$item.')'
                    );
                } elseif (
                    strpos('cslnvqgtrombCSLNVQJPGETROMB', $match['character']) !== false
                    && ((int)$match['added'] != (float)$match['added'])
                ) {
                    throw new \InvalidArgumentException(
                        'added must be integer for character '.$match['character']
                        .' ('.$item.')'
                    );
                }
            }

            /*
             * return result
             */
            $result[$match['key']] = array(
                'character' => $match['character'],
                'number' => $match['number'],
                'added' => empty($match['added'])?0:$match['added'],
            );
        }
        return $result;
    }
}
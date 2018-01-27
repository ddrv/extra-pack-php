<?php

namespace Ddrv\Extra;

class Pack
{
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
            if (!isset($data[$key])) {
                throw new \InvalidArgumentException('undefined index '.$key.' in data array');
            }
            $packValue = $data[$key];
            if (!empty($meta['added'])) {
                $packValue = $data[$key]-$meta['added'];
            }
            switch ($meta['character']) {
                case 't':
                    break;
                case 'T':
                    break;
                case 'o':
                    break;
                case 'O':
                    break;
                case 'r':
                    break;
                case 'R':
                    break;
                case 'b':
                    break;
                case 'B':
                    break;
                case 'm':
                    break;
                case 'M':
                    break;
                default: break;
            }
            $packFormat = $meta['character'].$meta['number'];
            //$bin = \pack($packFormat, $packValue);

            //$result .= $bin;
        }
        return $result;
    }

    /**
     * @param string $format
     * @param string $string
     * @return array
     */
    public static function unpack($format, $string)
    {
        return array();
    }

    /**
     * @param mixed $minimal
     * @param mixed $maximal
     * @return string
     */
    public static function getOptimalFormat($minimal, $maximal)
    {
        return '';
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
            .'(?<character>[ahcsnvilqfgdexmtorbAHCSNVILQJPGEXZMTORB\@])'
            .'(?<number>(\d+|\*))?'
            .'(?<key>[^\d][^:]+)'
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
                if (strpos('bort@BORTZ', $match['character']) !== false && $match['number'] == '*') {
                    throw new \InvalidArgumentException(
                        'incorrect number * for character '.$match['character']
                        .' ('.$item.')'
                    );
                } elseif (strpos('borat@BORATZ', $match['character']) === false) {
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
                if (strpos('cslnvqfgdtrombCSLNVQJPGETROMB', $match['character']) === false) {
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
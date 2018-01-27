<?php

namespace Ddrv\Test\Extra\Pack;

use PHPUnit\Framework\TestCase;
use Ddrv\Extra\Pack;

/**
 * @covers Pack
 *
 * @property array $data
 * @property string $format
 * @property int $len
 * @property int $phpVersion
 */
class PackTest extends TestCase
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var int
     */
    protected $len;

    /**
     * @var int
     */
    protected $phpVersion;

    /**
     * PackTest constructor.
     *
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name=null, $data=array(), $dataName='')
    {
        parent::__construct($name, $data, $dataName);
        $this->phpVersion = phpversion();
        $this->data = array(
            'c-@' => 'value',
            'c-@*' => 'value',
            'c-A' => 'value',
            'c-A*' => 'value',
            'c-a' => 'value',
            'c-a*' => 'value',
            'c-H' => base_convert(100, 10, 16),
            'c-h' => base_convert(500, 10, 16),

            'key3' => 2000.5,
        );
        $this->format =
            '@3c-@'
            .'/A6c-A'
            .'/A*c-A'
            .'/a6c-A'
            .'/a*c-A'
            .'/Hc-H'
            .'/hc-h'
        ;
        $this->len = 3+6+5+6+5+4+4;
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (@1)
     */
    public function testAtWithoutKey()
    {
        $format = '@1';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character @ (@c-@)
     */
    public function testAtWithoutNumber()
    {
        $format = '@c-@';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect number * for character @ (@*c-@*)
     */
    public function testAtWithNumberAsStar()
    {
        $format = '@*c-@*';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character @ (@2c-@:125)
     */
    public function testAtWithAdded()
    {
        $format = '@2c-@:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (A1)
     */
    public function testBigAWithoutKey()
    {
        $format = 'A1';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character A (Ac-A)
     */
    public function testBigAWithoutNumber()
    {
        $format = 'Ac-A';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character A (A2c-A:125)
     */
    public function testBigAWithAdded()
    {
        $format = 'A2c-A:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (a1)
     */
    public function testSmallAWithoutKey()
    {
        $format = 'a1';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character a (ac-a)
     */
    public function testSmallAWithoutNumber()
    {
        $format = 'ac-a';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character a (a2c-a:125)
     */
    public function testSmallAWithAdded()
    {
        $format = 'a2c-a:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (H)
     */
    public function testBigHWithoutKey()
    {
        $format = 'H';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character H (H4c-H)
     */
    public function testBigHWithNumber()
    {
        $format = 'H4c-H';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character H (Hc-H:125)
     */
    public function testBigHWithAdded()
    {
        $format = 'Hc-H:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (h)
     */
    public function testSmallHWithoutKey()
    {
        $format = 'h';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character h (h4c-h)
     */
    public function testSmallHWithNumber()
    {
        $format = 'h4c-h';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character h (hc-h:125)
     */
    public function testSmallHWithAdded()
    {
        $format = 'hc-h:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (X)
     */
    public function testBigXWithoutKey()
    {
        $format = 'X';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character X (X4c-X)
     */
    public function testBigXWithNumber()
    {
        $format = 'X4c-X';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character X (Xc-X:125)
     */
    public function testBigXWithAdded()
    {
        $format = 'Xc-X:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (x)
     */
    public function testSmallXWithoutKey()
    {
        $format = 'x';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character x (x4c-x)
     */
    public function testSmallXWithNumber()
    {
        $format = 'x4c-x';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character x (xc-x:125)
     */
    public function testSmallXWithAdded()
    {
        $format = 'xc-x:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (Z)
     */
    public function testBigZWithoutKey()
    {
        $format = 'Z';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character Z (Z4c-Z)
     */
    public function testBigZWithNumber()
    {
        $format = 'Z4c-Z';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character Z (Zc-Z:125)
     */
    public function testBigZWithAdded()
    {
        if (version_compare($this->phpVersion, '5.5.0', '<')) {
            throw new \InvalidArgumentException('added must be empty for character Z (Zc-Z:125)');
        }
        $format = 'Zc-Z:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (C)
     */
    public function testBigCWithoutKey()
    {
        $format = 'C';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character C (C4c-C)
     */
    public function testBigCWithNumber()
    {
        $format = 'C4c-C';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (c)
     */
    public function testSmallCWithoutKey()
    {
        $format = 'c';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character c (c4c-c)
     */
    public function testSmallCWithNumber()
    {
        $format = 'c4c-c';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (S)
     */
    public function testBigSWithoutKey()
    {
        $format = 'S';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character S (S4c-S)
     */
    public function testBigSWithNumber()
    {
        $format = 'S4c-S';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (s)
     */
    public function testSmallSWithoutKey()
    {
        $format = 's';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character s (s4c-s)
     */
    public function testSmallSWithNumber()
    {
        $format = 's4c-s';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (N)
     */
    public function testBigNWithoutKey()
    {
        $format = 'N';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character N (N4c-N)
     */
    public function testBigNWithNumber()
    {
        $format = 'N4c-N';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (n)
     */
    public function testSmallNWithoutKey()
    {
        $format = 'n';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character n (n4c-n)
     */
    public function testSmallNWithNumber()
    {
        $format = 'n4c-n';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (V)
     */
    public function testBigVWithoutKey()
    {
        $format = 'V';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character V (V4c-V)
     */
    public function testBigVWithNumber()
    {
        $format = 'V4c-V';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (v)
     */
    public function testSmallVWithoutKey()
    {
        $format = 'v';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character v (v4c-v)
     */
    public function testSmallVWithNumber()
    {
        $format = 'v4c-v';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (I)
     */
    public function testBigIWithoutKey()
    {
        $format = 'I';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character I (I4c-I)
     */
    public function testBigIWithNumber()
    {
        $format = 'I4c-I';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (i)
     */
    public function testSmallIWithoutKey()
    {
        $format = 'i';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character i (i4c-i)
     */
    public function testSmallIWithNumber()
    {
        $format = 'i4c-i';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (L)
     */
    public function testBigLWithoutKey()
    {
        $format = 'L';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character L (L4c-L)
     */
    public function testBigLWithNumber()
    {
        $format = 'L4c-L';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (l)
     */
    public function testSmallLWithoutKey()
    {
        $format = 'l';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character l (l4c-l)
     */
    public function testSmallLWithNumber()
    {
        $format = 'l4c-l';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (Q)
     */
    public function testBigQWithoutKey()
    {
        $format = 'Q';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character Q (Q4c-Q)
     */
    public function testBigQWithNumber()
    {
        $format = 'Q4c-Q';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (q)
     */
    public function testSmallQWithoutKey()
    {
        $format = 'q';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character q (q4c-q)
     */
    public function testSmallQWithNumber()
    {
        $format = 'q4c-q';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (J)
     */
    public function testBigJWithoutKey()
    {
        $format = 'J';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character J (J4c-J)
     */
    public function testBigJWithNumber()
    {
        $format = 'J4c-J';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (P)
     */
    public function testBigPWithoutKey()
    {
        $format = 'P';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character P (P4c-P)
     */
    public function testBigPWithNumber()
    {
        $format = 'P4c-P';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (f)
     */
    public function testSmallFWithoutKey()
    {
        $format = 'f';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character f (f4c-f)
     */
    public function testSmallFWithNumber()
    {
        $format = 'f4c-f';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (G)
     */
    public function testBigGWithoutKey()
    {
        $format = 'G';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character G (G4c-G)
     */
    public function testBigGWithNumber()
    {
        $format = 'G4c-G';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (g)
     */
    public function testSmallGWithoutKey()
    {
        $format = 'g';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character g (g4c-g)
     */
    public function testSmallGWithNumber()
    {
        $format = 'g4c-g';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (d)
     */
    public function testSmallDWithoutKey()
    {
        $format = 'd';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character d (d4c-d)
     */
    public function testSmallDWithNumber()
    {
        $format = 'd4c-d';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (E)
     */
    public function testBigEWithoutKey()
    {
        $format = 'E';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character E (E4c-E)
     */
    public function testBigEWithNumber()
    {
        $format = 'E4c-E';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (e)
     */
    public function testSmallEWithoutKey()
    {
        $format = 'e';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character e (e4c-e)
     */
    public function testSmallEWithNumber()
    {
        $format = 'e4c-e';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (M)
     */
    public function testBigMWithoutKey()
    {
        $format = 'M';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character M (M4c-M)
     */
    public function testBigMWithNumber()
    {
        $format = 'M4c-M';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (m)
     */
    public function testSmallMWithoutKey()
    {
        $format = 'm';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character m (m4c-m)
     */
    public function testSmallMWithNumber()
    {
        $format = 'm4c-m';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (T)
     */
    public function testBigTWithoutKey()
    {
        $format = 'T';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character T (Tc-T)
     */
    public function testBigTWithoutNumber()
    {
        $format = 'Tc-T';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (t)
     */
    public function testSmallTWithoutKey()
    {
        $format = 't';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character t (tc-t)
     */
    public function testSmallTWithoutNumber()
    {
        $format = 'tc-t';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (R)
     */
    public function testBigRWithoutKey()
    {
        $format = 'R';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character R (Rc-R)
     */
    public function testBigRWithoutNumber()
    {
        $format = 'Rc-R';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (r)
     */
    public function testSmallRWithoutKey()
    {
        $format = 'r';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character r (rc-r)
     */
    public function testSmallRWithoutNumber()
    {
        $format = 'rc-r';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (O)
     */
    public function testBigOWithoutKey()
    {
        $format = 'O';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character O (Oc-O)
     */
    public function testBigOWithoutNumber()
    {
        $format = 'Oc-O';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (o)
     */
    public function testSmallOWithoutKey()
    {
        $format = 'o';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character o (oc-o)
     */
    public function testSmallOWithoutNumber()
    {
        $format = 'oc-o';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (B)
     */
    public function testBigBWithoutKey()
    {
        $format = 'B';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character B (Bc-B)
     */
    public function testBigBWithoutNumber()
    {
        $format = 'Bc-B';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (b)
     */
    public function testSmallBWithoutKey()
    {
        $format = 'b';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character b (bc-b)
     */
    public function testSmallBWithoutNumber()
    {
        $format = 'bc-b';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * Correct case
     */
    public function testCorrect()
    {
        $binary = Pack::pack($this->format, $this->data);
        $result = Pack::unpack($this->format, $this->data);
    }
}
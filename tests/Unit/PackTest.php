<?php

namespace Ddrv\Test\Extra\Pack;

use PHPUnit\Framework\TestCase;
use Ddrv\Extra\Pack;
use SebastianBergmann\CodeCoverage\Report\PHP;

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
            'key01' => 'value',
            'key02' => 'value',
            'key03' => 'value',
            'key04' => 'value',
            'key05' => dechex(10),
            'key06' => dechex(10),
            'key07' => 120,
            'key08' => -120,
            'key09' => 100120,
            'key10' => -100120,
            'key11' => 5000,
            'key12' => -5000,
            'key13' => 71000,
            'key14' => -71000,
            'key15' => 60000,
            'key16' => 71000,
            'key17' => 60000,
            'key18' => 71000,
            'key19' => 71000,
            'key20' => -71000,
            'key21' => 160000,
            'key22' => -160000,
            'key23' => 16000000,
            'key24' => -16000000,
            'key25' => 32000000,
            'key26' => -32000000,
            'key27' =>.0001,
            'key28' =>.1365,
            'key29' =>.83961,
            'key30' =>3.14159265,
        );
        $this->format =
            'A5key01'
            .'/a6key03'
            .'/Hkey05'
            .'/hkey06'
            .'/Ckey07'
            .'/ckey08'
            .'/Ckey09:100000'
            .'/ckey10:-100000'
            .'/Skey11'
            .'/skey12'
            .'/Skey13:66000'
            .'/skey14:-66000'
            .'/nkey15'
            .'/nkey16:66000'
            .'/vkey17'
            .'/vkey18:66000'
            .'/Mkey19'
            .'/mkey20'
            .'/Mkey21:80000'
            .'/mkey22:-80000'
            .'/Mkey19'
            .'/mkey20'
            .'/Mkey21:80000'
            .'/mkey22:-80000'
            .'/Lkey23'
            .'/lkey24'
            .'/Lkey25:80000'
            .'/lkey26:-80000'
            .'/t4key27'
            .'/o4key28'
            .'/r5key29'
            .'/b8key30'
        ;
        $this->len =
            5
            +6
            +1
            +1
            +1
            +1
            +1
            +1
            +2
            +2
            +2
            +2
            +2
            +2
            +2
            +2
            +3
            +3
            +3
            +3
            +4
            +4
            +4
            +4
            +1
            +2
            +3
            +4
        ;
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
     * @expectedExceptionMessage number can not be empty for character @ (@key)
     */
    public function testAtWithoutNumber()
    {
        $format = '@key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect number * for character @ (@*key)
     */
    public function testAtWithNumberAsStar()
    {
        $format = '@*key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character @ (@2key:125)
     */
    public function testAtWithAdded()
    {
        $format = '@2key:125';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (Z)
     */
    public function testBigZWithoutKey()
    {
        if (version_compare($this->phpVersion, '5.5.0', '<')) {
            throw new \InvalidArgumentException('incorrect format (Z)');
        }
        $format = 'Z';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number can not be empty for character Z (Zkey)
     */
    public function testBigZWithoutNumber()
    {
        if (version_compare($this->phpVersion, '5.5.0', '<')) {
            throw new \InvalidArgumentException('number can not be empty for character Z (Zkey)');
        }
        $format = 'Zkey';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character Z (Z2key:125)
     */
    public function testBigZWithAdded()
    {
        if (version_compare($this->phpVersion, '5.5.0', '<')) {
            throw new \InvalidArgumentException('added must be empty for character Z (Z2key:125)');
        }
        $format = 'Z2key:125';
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
     * @expectedExceptionMessage number can not be empty for character A (Akey)
     */
    public function testBigAWithoutNumber()
    {
        $format = 'Akey';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character A (A2key:125)
     */
    public function testBigAWithAdded()
    {
        $format = 'A2key:125';
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
     * @expectedExceptionMessage number can not be empty for character a (akey)
     */
    public function testSmallAWithoutNumber()
    {
        $format = 'akey';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character a (a2key:125)
     */
    public function testSmallAWithAdded()
    {
        $format = 'a2key:125';
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
     * @expectedExceptionMessage number must be empty for character H (H4key)
     */
    public function testBigHWithNumber()
    {
        $format = 'H4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character H (Hkey:125)
     */
    public function testBigHWithAdded()
    {
        $format = 'Hkey:125';
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
     * @expectedExceptionMessage number must be empty for character h (h4key)
     */
    public function testSmallHWithNumber()
    {
        $format = 'h4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character h (hkey:125)
     */
    public function testSmallHWithAdded()
    {
        $format = 'hkey:125';
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

    public function testBigXWithNumber()
    {
        $format = 'x4key1/X3key2';
        $binary = Pack::pack($format, $this->data);
        $this->assertSame(1,strlen($binary));
    }

    public function testBigXWithoutNumber()
    {
        $format = 'x4key1/Xkey2';
        $binary = Pack::pack($format, $this->data);
        $this->assertSame(3,strlen($binary));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character X (Xkey:125)
     */
    public function testBigXWithAdded()
    {
        $format = 'Xkey:125';
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

    public function testSmallXWithNumber()
    {
        $format = 'x5key';
        $binary = Pack::pack($format, $this->data);
        $this->assertSame(5,strlen($binary));
    }

    public function testSmallXWithoutNumber()
    {
        $format = 'xkey';
        $binary = Pack::pack($format, $this->data);
        $this->assertSame(1,strlen($binary));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage added must be empty for character x (xkey:125)
     */
    public function testSmallXWithAdded()
    {
        $format = 'xkey:125';
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
     * @expectedExceptionMessage number must be empty for character C (C4key)
     */
    public function testBigCWithNumber()
    {
        $format = 'C4key';
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
     * @expectedExceptionMessage number must be empty for character c (c4key)
     */
    public function testSmallCWithNumber()
    {
        $format = 'c4key';
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
     * @expectedExceptionMessage number must be empty for character S (S4key)
     */
    public function testBigSWithNumber()
    {
        $format = 'S4key';
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
     * @expectedExceptionMessage number must be empty for character s (s4key)
     */
    public function testSmallSWithNumber()
    {
        $format = 's4key';
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
     * @expectedExceptionMessage number must be empty for character N (N4key)
     */
    public function testBigNWithNumber()
    {
        $format = 'N4key';
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
     * @expectedExceptionMessage number must be empty for character n (n4key)
     */
    public function testSmallNWithNumber()
    {
        $format = 'n4key';
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
     * @expectedExceptionMessage number must be empty for character V (V4key)
     */
    public function testBigVWithNumber()
    {
        $format = 'V4key';
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
     * @expectedExceptionMessage number must be empty for character v (v4key)
     */
    public function testSmallVWithNumber()
    {
        $format = 'v4key';
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
     * @expectedExceptionMessage number must be empty for character I (I4key)
     */
    public function testBigIWithNumber()
    {
        $format = 'I4key';
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
     * @expectedExceptionMessage number must be empty for character i (i4key)
     */
    public function testSmallIWithNumber()
    {
        $format = 'i4key';
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
     * @expectedExceptionMessage number must be empty for character L (L4key)
     */
    public function testBigLWithNumber()
    {
        $format = 'L4key';
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
     * @expectedExceptionMessage number must be empty for character l (l4key)
     */
    public function testSmallLWithNumber()
    {
        $format = 'l4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (Q)
     */
    public function testBigQWithoutKey()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('incorrect format (Q)');
        }
        $format = 'Q';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character Q (Q4key)
     */
    public function testBigQWithNumber()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('number must be empty for character Q (Q4key)');
        }
        $format = 'Q4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (q)
     */
    public function testSmallQWithoutKey()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('incorrect format (q)');
        }
        $format = 'q';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character q (q4key)
     */
    public function testSmallQWithNumber()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('number must be empty for character q (q4key)');
        }
        $format = 'q4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (J)
     */
    public function testBigJWithoutKey()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('incorrect format (J)');
        }
        $format = 'J';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character J (J4key)
     */
    public function testBigJWithNumber()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('number must be empty for character J (J4key)');
        }
        $format = 'J4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (P)
     */
    public function testBigPWithoutKey()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('incorrect format (P)');
        }
        $format = 'P';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character P (P4key)
     */
    public function testBigPWithNumber()
    {
        if (version_compare($this->phpVersion, '5.6.3', '<')) {
            throw new \InvalidArgumentException('number must be empty for character P (P4key)');
        }
        $format = 'P4key';
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
     * @expectedExceptionMessage number must be empty for character f (f4key)
     */
    public function testSmallFWithNumber()
    {
        $format = 'f4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (G)
     */
    public function testBigGWithoutKey()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('incorrect format (G)');
        }
        $format = 'G';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character G (G4key)
     */
    public function testBigGWithNumber()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('number must be empty for character G (G4key)');
        }
        $format = 'G4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (g)
     */
    public function testSmallGWithoutKey()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('incorrect format (g)');
        }
        $format = 'g';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character g (g4key)
     */
    public function testSmallGWithNumber()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('number must be empty for character g (g4key)');
        }
        $format = 'g4key';
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
     * @expectedExceptionMessage number must be empty for character d (d4key)
     */
    public function testSmallDWithNumber()
    {
        $format = 'd4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (E)
     */
    public function testBigEWithoutKey()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('incorrect format (E)');
        }
        $format = 'E';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character E (E4key)
     */
    public function testBigEWithNumber()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('number must be empty for character E (E4key)');
        }
        $format = 'E4key';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage incorrect format (e)
     */
    public function testSmallEWithoutKey()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('incorrect format (e)');
        }
        $format = 'e';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage number must be empty for character e (e4key)
     */
    public function testSmallEWithNumber()
    {
        if (version_compare($this->phpVersion, '7.0.15', '<')) {
            throw new \InvalidArgumentException('number must be empty for character e (e4key)');
        }
        $format = 'e4key';
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
     * @expectedExceptionMessage number must be empty for character M (M4key)
     */
    public function testBigMWithNumber()
    {
        $format = 'M4key';
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
     * @expectedExceptionMessage number must be empty for character m (m4key)
     */
    public function testSmallMWithNumber()
    {
        $format = 'm4key';
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
     * @expectedExceptionMessage number can not be empty for character T (Tkey)
     */
    public function testBigTWithoutNumber()
    {
        $format = 'Tkey';
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
     * @expectedExceptionMessage number can not be empty for character t (tkey)
     */
    public function testSmallTWithoutNumber()
    {
        $format = 'tkey';
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
     * @expectedExceptionMessage number can not be empty for character R (Rkey)
     */
    public function testBigRWithoutNumber()
    {
        $format = 'Rkey';
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
     * @expectedExceptionMessage number can not be empty for character r (rkey)
     */
    public function testSmallRWithoutNumber()
    {
        $format = 'rkey';
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
     * @expectedExceptionMessage number can not be empty for character O (Okey)
     */
    public function testBigOWithoutNumber()
    {
        $format = 'Okey';
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
     * @expectedExceptionMessage number can not be empty for character o (okey)
     */
    public function testSmallOWithoutNumber()
    {
        $format = 'okey';
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
     * @expectedExceptionMessage number can not be empty for character B (Bkey)
     */
    public function testBigBWithoutNumber()
    {
        $format = 'Bkey';
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
     * @expectedExceptionMessage number can not be empty for character b (bkey)
     */
    public function testSmallBWithoutNumber()
    {
        $format = 'bkey';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage undefined index undefinedKey in data array
     */
    public function testUndefinedKey()
    {
        $format = 'A5undefinedKey';
        $binary = Pack::pack($format, $this->data);
        unset($binary);
    }

    /**
     * Correct case
     */
    public function testCorrect()
    {
        $binary = Pack::pack($this->format, $this->data);
        $this->assertSame($this->len, strlen($binary));
        $result = Pack::unpack($this->format, $binary);
        foreach ($this->data as $key=>$value) {
            if (isset($result[$key])) {
                $actual = is_string($result[$key])?trim($result[$key]):$result[$key];
                $this->assertSame($value, $actual);
            }
        }

    }
}
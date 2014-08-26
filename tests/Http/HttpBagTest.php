<?php
use \Core\Http\HttpBag as HttpBag;

class HttpBagTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $a = ['foo' => 'bar', 'doo'=> 'dar', 'guu'=>'gar'];

        $HttpBag = new HttpBag($a);

        $this->assertEquals($HttpBag->get('foo'), 'bar');

        $this->assertEquals($HttpBag->get('guu'), 'gar');
    }

    public function testAll()
    {
        $HttpBag = new HttpBag(['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $HttpBag->all());
    }

    public function testKeys()
    {
        $HttpBag = new HttpBag(['foo' => 'bar']);

        $this->assertEquals(['foo'], $HttpBag->keys());
    }

    public function testAdd()
    {
        $HttpBag = new HttpBag(['foo' => 'bar']);

        $HttpBag->add(['bar' => 'bas']);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'bas'], $HttpBag->all());
    }

    public function testRemove()
    {
        $HttpBag = new HttpBag(['foo' => 'bar']);

        $HttpBag->add(['bar' => 'bas']);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'bas'], $HttpBag->all());

        $HttpBag->remove('bar');

        $this->assertEquals(['foo' => 'bar'], $HttpBag->all());
    }

    public function testSet()
    {
        $HttpBag = new HttpBag([]);

        $HttpBag->set('moo', 'mar');

        $this->assertEquals($HttpBag->get('moo'), 'mar');  
    }

    public function testFilter()
    {
        $HttpBag = new HttpBag([
            'digits' => '0123ab',
            'email' => 'example@example.com',
            'url' => 'http://example.com/foo',
            'dec' => '256',
            'hex' => '0x100',
            'array' => ['bang'],
        ]);

        $this->assertEmpty($HttpBag->filter('nokey'));

        $this->assertEquals('0123', $HttpBag->filter('digits', FILTER_SANITIZE_NUMBER_INT));

        $this->assertEquals('example@example.com', $HttpBag->filter('email', FILTER_VALIDATE_EMAIL));

        $this->assertEquals('http://example.com/foo', $HttpBag->filter('url', FILTER_VALIDATE_URL, ['flags' => FILTER_FLAG_PATH_REQUIRED]));

        $this->assertEquals('http://example.com/foo', $HttpBag->filter('url', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));

        $this->assertFalse($HttpBag->filter('dec', FILTER_VALIDATE_INT, [
                'flags' => FILTER_FLAG_ALLOW_HEX,
                'options' => ['min_range' => 1, 'max_range' => 0xff]
                ]
            )
        );
        
        $this->assertFalse($HttpBag->filter('hex', FILTER_VALIDATE_INT, array(
        'flags' => FILTER_FLAG_ALLOW_HEX,
        'options' => array('min_range' => 1, 'max_range' => 0xff)))
        );
        
        $this->assertEquals(['bang'], $HttpBag->filter('array'));
    }

    public function testGetIterator()
    {
        $parameters = ['foo' => 'bar', 'hello' => 'world'];

        $HttpBag = new HttpBag($parameters);

        $i = 0;
        foreach ($HttpBag as $key => $val) {
            $i++;
            $this->assertEquals($parameters[$key], $val);
        }

        $this->assertEquals(count($parameters), $i);
    }

    public function testCount()
    {
        $parameters = ['foo' => 'bar', 'hello' => 'world'];

        $HttpBag = new HttpBag($parameters);

        $this->assertEquals(count($parameters), count($HttpBag));
    }
}

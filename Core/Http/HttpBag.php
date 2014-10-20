<?php
namespace Core\Http;

/**
* Simple container for storing HTTP request data.
*
* @author miloskajnaco@gmail.com
*/
class HttpBag implements \IteratorAggregate, \Countable
{
    /**
     * Elements storage.
     *
     * @var array
     */
    protected $elements;

    /**
     * Constructor.
     *
     * @param array
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * Returns the elements.
     *
     * @return array
     */
    public function all()
    {
        return $this->elements;
    }

    /**
     * Returns the element keys.
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->elements);
    }

    /**
     * Replaces the current elements by a new set.
     *
     * @param array
     */
    public function replace(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * Adds elements.
     *
     * @param array
     */
    public function add(array $elements = [])
    {
        $this->elements = array_merge($this->elements, $elements);
    }

    /**
     * Returns a element by name.
     *
     * @param string
     * @return mixed
     */
    public function get($key)
    {
        return isset($this->elements[$key]) ? $this->elements[$key] : null;
    }

    /**
     * Sets a element by name.
     *
     * @param string
     * @param mixed
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;
    }

    /**
     * Returns true if the element is defined.
     *
     * @param string
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->elements);
    }

    /**
     * Removes a element.
     *
     * @param string
     */
    public function remove($key)
    {
        unset($this->elements[$key]);
    }

    /**
     * Filter key.
     *
     * @param string
     * @param int   FILTER_* constant.
     * @param mixed Filter options.
     * @see http://php.net/manual/en/function.filter-var.php
     * @return mixed
     */
    public function filter($key, $filter = FILTER_DEFAULT, $options = [])
    {
        $value = $this->get($key);

        // Always turn $options into an array - this allows filter_var option shortcuts.
        if (!is_array($options) && $options) {
            $options = array('flags' => $options);
        }

        // Add a convenience check for arrays.
        if (is_array($value) && !isset($options['flags'])) {
            $options['flags'] = FILTER_REQUIRE_ARRAY;
        }

        return filter_var($value, $filter, $options);
    }

    /**
     * Returns an iterator for elements.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * Returns the number of elements.
     *
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }
}

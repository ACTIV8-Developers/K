<?php 
namespace Core\Util;

/**
* Additional class autoloader for prettier class names.
*
* @see https://github.com/laravel/framework/blob/master/src/Illuminate/Foundation/AliasLoader.php
* @see laravel.com
*/
class AliasLoader 
{
	/**
	 * The array of class aliases.
	 *
	 * @var array
	 */
	protected $aliases;

	/**
	 * Indicates if a loader has been registered.
	 *
	 * @var bool
	 */
	protected $registered = false;

	/**
	 * The singleton instance of the loader.
	 *
	 * @var object \Core\Util\AliasLoader
	 */
	protected static $instance;

	/**
	 * Create a new class alias loader instance.
	 *
	 * @param array
	 */
	public function __construct(array $aliases = [])
	{
		$this->aliases = $aliases;
	}

	/**
	 * Get or create the singleton alias loader instance.
	 *
	 * @param  array 
	 * @return \Core\Util\AliasLoader
	 */
	public static function getInstance(array $aliases = [])
	{
		if (is_null(static::$instance)) static::$instance = new static($aliases);
		
		$aliases = array_merge(static::$instance->getAliases(), $aliases);

		static::$instance->setAliases($aliases);

		return static::$instance;
	}

	/**
	 * Load a class alias if it is registered.
	 *
	 * @param string
	 * @return void
	 */
	public function load($alias)
	{
		if (isset($this->aliases[$alias])) {
			return class_alias($this->aliases[$alias], $alias);
		}
	}

	/**
	 * Add an alias to the loader.
	 *
	 * @param  string  
	 * @param  string 
	 * @return void
	 */
	public function alias($class, $alias)
	{
		$this->aliases[$class] = $alias;
	}

	/**
	 * Register the loader on the auto-loader stack.
	 */
	public function register()
	{
		if (!$this->registered) {
			$this->prependToLoaderStack();

			$this->registered = true;
		}
	}

	/**
	 * Prepend the load method to the auto-loader stack.
	 */
	protected function prependToLoaderStack()
	{
		spl_autoload_register(array($this, 'load'), true, true);
	}

	/**
	 * Get the registered aliases.
	 *
	 * @return array
	 */
	public function getAliases()
	{
		return $this->aliases;
	}

	/**
	 * Set the registered aliases.
	 *
	 * @param  array  $aliases
	 * @return void
	 */
	public function setAliases(array $aliases)
	{
		$this->aliases = $aliases;
	}

	/**
	 * Indicates if the loader has been registered.
	 */
	public function isRegistered()
	{
		return $this->registered;
	}

	/**
	 * Set the "registered" state of the loader.
	 *
	 * @param  bool
	 */
	public function setRegistered($value)
	{
		$this->registered = $value;
	}
}

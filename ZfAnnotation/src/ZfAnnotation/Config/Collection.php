<?php
namespace ZfAnnotation\Config;

use Exception;
use Zend\Stdlib\ArrayUtils;

class Collection
{
    /**
     * @var array
     */
    protected $configs = array();
    
    /**
     * @var array
     */
    protected $baseConfig = array();
    
    /**
     * @param array $baseConfig
     */
    public function __construct(array $baseConfig = array())
    {
        $this->baseConfig = $baseConfig;
    }

    /**
     * @return array
     */
    public function getBaseConfig()
    {
        return $this->baseConfig;
    }
    
    /**
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getFromBase($key, $default = null)
    {
        if ($this->hasInBase($key)) {
            return $this->baseConfig[$key];
        }
        return $default;
    }
    
    /**
     * 
     * @param string $key
     * @return bool
     */
    public function hasInBase($key)
    {
        return isset($this->baseConfig[$key]);
    }
    
    /**
     * @param ConfigInterface $config
     */
    public function add(ConfigInterface $config)
    {
        $this->configs[$config->getKey()] = $config;
    }

    /**
     * @param string $key
     * @return ConfigInterface
     * @throws Exception
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new Exception('No config registered for key: ' . $key);
        }
        return $this->configs[$key];
    }

    /**
     * @param string $key
     * @param array $value
     */
    public function set($key, array $value)
    {
        $this->configs[$key] = $value;
    }
    
    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($this->configs[$key]);
    }

    public function merge($key, array $content) 
    {
        if ($this->has($key)) {
            $this->configs[$key] = ArrayUtils::merge($this->configs[$key], $content);
        }
        return $this->configs;
    }
    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->configs;
    }
}
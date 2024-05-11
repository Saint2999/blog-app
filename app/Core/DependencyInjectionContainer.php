<?php

namespace app\Core;

final class DependencyInjectionContainer
{
    private array $instances = [];
    private array $config = [];

    public function __construct(array $config) 
    {
        $this->config = $config;
    }
  
    public function has(string $id): bool 
    {
        return array_key_exists($id, $this->config);
    }
    
    public function get(string $id) 
    {
        if (!$this->has($id)) {
            throw new \Exception('Class not found', 500); 
        }
      
        $this->instances[$id] ??= $this->instantiate($id);
      
        return $this->instances[$id];
    }
    
    private function instantiate(string $id) 
    {
        $config = $this->config[$id];
      
        if (is_string($config)) {
            return $this->get($config);
        }
  
        $args = array_map(
            fn($dependency) => $this->get($dependency),
            $config
        );

        return new $id(...$args);
    }   
}
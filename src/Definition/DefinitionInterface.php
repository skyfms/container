<?php

namespace League\Container\Definition;

use League\Container\ContainerAwareInterface;

interface DefinitionInterface extends ContainerAwareInterface
{
    /**
     * Add a tag to the definition.
     *
     * @param string $tag
     *
     * @return self
     */
    public function addTag($tag) : DefinitionInterface;

    /**
     * Does the definition have a tag?
     *
     * @param string $tag
     *
     * @return boolean
     */
    public function hasTag($tag) : bool;

    /**
     * Set the alias of the definition.
     *
     * @param string $id
     *
     * @return DefinitionInterface
     */
    public function setAlias($id) : DefinitionInterface;

    /**
     * Get the alias of the definition.
     *
     * @return string
     */
    public function getAlias();

    /**
     * Set whether this is a shared definition.
     *
     * @param boolean $shared
     *
     * @return self
     */
    public function setShared($shared) : DefinitionInterface;

    /**
     * Is this a shared definition?
     *
     * @return boolean
     */
    public function isShared();

    /**
     * Get the concrete of the definition.
     *
     * @return mixed
     */
    public function getConcrete();

    /**
     * Set the concrete of the definition.
     *
     * @param mixed $concrete
     *
     * @return DefinitionInterface
     */
    public function setConcrete($concrete) : DefinitionInterface;

    /**
     * Add an argument to be injected.
     *
     * @param mixed $arg
     *
     * @return self
     */
    public function addArgument($arg) : DefinitionInterface;

    /**
     * Add multiple arguments to be injected.
     *
     * @param array $args
     *
     * @return self
     */
    public function addArguments(array $args) : DefinitionInterface;

    /**
     * Add a method to be invoked
     *
     * @param string $method
     * @param array  $args
     *
     * @return self
     */
    public function addMethodCall($method, array $args = []) : DefinitionInterface;

    /**
     * Add multiple methods to be invoked
     *
     * @param array $methods
     *
     * @return self
     */
    public function addMethodCalls(array $methods = []) : DefinitionInterface;

    /**
     * Handle instantiation and manipulation of value and return.
     *
     * @param boolean $new
     *
     * @return mixed
     */
    public function resolve($new = false);
}

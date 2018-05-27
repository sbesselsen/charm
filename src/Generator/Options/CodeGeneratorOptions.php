<?php

namespace Charm\Generator\Options;

class CodeGeneratorOptions
{
    /**
     * The class name.
     *
     * @var string
     *   The class name.
     */
    protected $className;

    /**
     * The class namespace.
     *
     * @var string
     *   The classNamespace.
     */
    protected $namespace;

    /**
     * Whether the parser should be generated in debug mode.
     *
     * @var bool
     *   True if debug ode.
     */
    protected $debugMode = false;

    /**
     * Set whether the parser should be generated in debug mode.
     *
     * @param bool $debugMode
     *
     * @return $this
     */
    public function setDebugMode(bool $debugMode)
    {
        $this->debugMode = $debugMode;
        return $this;
    }

    /**
     * Get whether the parser should be generated in debug mode.
     *
     * @return bool
     */
    public function getDebugMode(): bool
    {
        return $this->debugMode;
    }

    public function setClassName(string $className)
    {
        $this->className = $className;
        return $this;
    }

    /**
     * Get the output class name.
     *
     * @return string|null
     *   The output class name.
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Set the output class namespace.
     *
     * @param string $namespace
     *
     * @return $this
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    /**
     * Get the output class namespace.
     *
     * @return string|null
     *   The output class namespace.
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}

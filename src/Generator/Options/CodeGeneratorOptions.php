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

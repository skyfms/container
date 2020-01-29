<?php

namespace League\Container\Definition;

use Generator;
use League\Container\ContainerAwareTrait;
use League\Container\Exception\NotFoundException;

class DefinitionAggregate implements DefinitionAggregateInterface
{
    use ContainerAwareTrait;

    /**
     * @var DefinitionInterface[]
     */
    protected $definitions = [];

    /**
     * Construct.
     *
     * @param DefinitionInterface[] $definitions
     */
    public function __construct(array $definitions = [])
    {
        $this->definitions = array_filter($definitions, function ($definition) {
            return ($definition instanceof DefinitionInterface);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function add($id, $definition, $shared = false) : DefinitionInterface
    {
        if (!$definition instanceof DefinitionInterface) {
            $definition = new Definition($id, $definition);
        }

        $this->definitions[] = $definition
            ->setAlias($id)
            ->setShared($shared)
        ;

        return $definition;
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        foreach ($this->getIterator() as $definition) {
            if ($id === $definition->getAlias()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function hasTag($tag)
    {
        foreach ($this->getIterator() as $definition) {
            if ($definition->hasTag($tag)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition($id) : DefinitionInterface
    {
        foreach ($this->getIterator() as $definition) {
            if ($id === $definition->getAlias()) {
                return $definition->setLeagueContainer($this->getLeagueContainer());
            }
        }

        throw new NotFoundException(sprintf('Alias (%s) is not being handled as a definition.', $id));
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($id, $new = false)
    {
        return $this->getDefinition($id)->resolve($new);
    }

    /**
     * {@inheritdoc}
     */
    public function resolveTagged($tag, $new = false) : array
    {
        $arrayOf = [];

        foreach ($this->getIterator() as $definition) {
            if ($definition->hasTag($tag)) {
                $arrayOf[] = $definition->setLeagueContainer($this->getLeagueContainer())->resolve($new);
            }
        }

        return $arrayOf;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator() : Generator
    {
        $count = count($this->definitions);

        for ($i = 0; $i < $count; $i++) {
            yield $this->definitions[$i];
        }
    }
}

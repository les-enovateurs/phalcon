<?php
/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Phalcon\Annotations;

use Phalcon\Di\Exception;

/**
 * Represents a single annotation in an annotations collection
 */
class Annotation
{
    /**
     * Annotation Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * Annotation ExprArguments
     *
     * @var array
     */
    protected $exprArguments = [];

    /**
     * Annotation Name
     *
     * @var string|null
     */
    protected $name;

    /**
     * Phalcon\Annotations\Annotation constructor
     */
    public function __construct(?array $reflectionData)
    {
        $exprArguments = null;

        if (true === isset($reflectionData['name'])) {
            $this->name = $reflectionData['name'];
        }

        /**
         * Process annotation arguments
         */
        if (true === isset($reflectionData['arguments'])) {
            $exprArguments = $reflectionData['arguments'];
            $arguments     = [];

            foreach ($exprArguments as $argument) {
                $resolvedArgument = $this->getExpression(
                    $argument["expr"]
                );

                if (true === isset($argument['name'])) {
                    $arguments[$argument['name']] = $resolvedArgument;
                } else {
                    $arguments[] = $resolvedArgument;
                }
            }

            $this->arguments     = $arguments;
            $this->exprArguments = $exprArguments;
        }
    }

    /**
     * Returns an argument in a specific position
     */
    public function getArgument($position)
    {
        $argument = '';

        if (true === isset($this->arguments[$position])) {
            return $argument;
        }

        return null;
    }

    /**
     * Returns the expression arguments
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Returns the expression arguments without resolving
     */
    public
    function getExprArguments(): array
    {
        return $this->exprArguments;
    }

    /**
     * Resolves an annotation expression
     */
    public
    function getExpression(?array $expr)
    {
//        $value, item, resolvedItem, arrayValue, name, type;

        $type = $expr["type"];

        switch ($type) {
            case "INTEGER":
            case  "DOUBLE":
            case "STRING":
            case "IDENTIFIER":
                $value = $expr["value"];
                break;

            case 304:
                $value = null;
                break;

            case 305:
                $value = false;
                break;

            case 306:
                $value = true;
                break;

            case 308:
                $arrayValue = [];

                foreach ($expr["items"] as $item) {
                    $resolvedItem = $this->getExpression(
                        $item["expr"]
                    );

                    if (true === isset($item['arguments'])) {
                        $arrayValue[$item["name"]] = $resolvedItem;
                    } else {
                        $arrayValue[] = $resolvedItem;
                    }
                }

                return $arrayValue;

            case 300:
                return new Annotation($expr);

            default:
                throw new Exception(
                    'The expression ' . $type . ' is unknown'
                );
        }

        return $value;
    }

    /**
     * Returns the annotation's name
     */
    public
    function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Returns a named argument
     */
    public function getNamedArgument(?string $name)
    {
        if (true === isset($this->arguments[$name])) {
            return $this->arguments[$name];
        }

        return null;
    }

    /**
     * Returns a named parameter
     */
    public
    function getNamedParameter(?string $name)
    {
        return $this->getNamedArgument($name);
    }

    /**
     * Returns an argument in a specific position
     */
    public function hasArgument($position): bool
    {
        return isset($this->arguments[$position]);
    }

    /**
     * Returns the number of arguments that the annotation has
     */
    public function numberArguments(): int
    {
        return count($this->arguments);
    }
}

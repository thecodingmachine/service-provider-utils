<?php
namespace TheCodingMachine\ServiceProvider\Utils;
use Invoker\Reflection\CallableReflection;

/**
 * Analyzes factory methods.
 */
class FactoryAnalyzer
{
    /**
     * @param callable $callable
     * @return bool
     */
    public function isPreviousArgumentUsed(callable $callable)
    {
        $reflection = CallableReflection::create($callable);
        $parameters = $reflection->getParameters();
        $body = $this->getFunctionCode($reflection);

        if (count($parameters) > 0 && $parameters[0]->isVariadic() === true) {
            return true;
        }

        if (count($parameters) > 1 && $parameters[1]->isVariadic() === true) {
            return true;
        }

        if (count($parameters) > 1) {
            $previousParameter = $parameters[1];
            $previousVariableName = $previousParameter->getName();

            if (substr_count($body, '$'.$previousVariableName) > 1 || strpos($body, '$$') !== false) {
                return true;
            }
        }

        if (strpos($body, 'func_get_args') !== false) {
            return true;
        }

        return false;
    }

    private function getFunctionCode(\ReflectionFunctionAbstract $function)
    {
        $fileContent = file_get_contents($function->getFileName());
        $lines = explode("\n", $fileContent);
        $bodyLines=  array_slice($lines, $function->getStartLine() - 1, $function->getEndLine()-$function->getStartLine()+1);
        $body = implode("\n", $bodyLines);
        return $body;
    }
}
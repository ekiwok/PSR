<?php
declare(strict_types=1);

namespace Ekiwok\PCM;

use Ekiwok\PCM\Registry\ImportsRegistry;

class TokenParsingImportsRegistryProvider implements ImportsRegistryProvider
{
    public function generate(string $filePath, string $className, string $namespace): ImportsRegistry
    {
        $content = file_get_contents($filePath);
        $tokens = token_get_all($content);
        $this->forwardToNamespace($tokens, $namespace);
        $imports = [];
        $this->forwardToNextUse($tokens);
        do {
            $import = implode('', $this->stripUse($tokens));
            $shortName = (new \ReflectionClass($import))->getShortName();
            $imports[$shortName] = $import;
            $this->forwardToNextUse($tokens);
        } while (count($tokens));

        return new ImportsRegistry($imports);
    }

    private function forwardToNamespace(array &$tokens, string $namespace)
    {
        // if there is no tokens namespace was not found
        if (!count($tokens)) {
            return;
        }

        $head = reset($tokens);
        $code = is_array($head) ? reset($head) : $head;

        if ($code !== T_NAMESPACE) {
            array_shift($tokens);
            return $this->forwardToNamespace($tokens, $namespace);
        }

        // get rid of namespace token
        // we're after namespace token but before semicolon
        array_shift($tokens);

        $currentNamespaceTokens = [];
        do {
            $currentToken = array_shift($tokens);
            $currentTokenCode = is_array($currentToken) ? reset($currentToken) : $currentToken;

            if (in_array($currentToken, [T_NS_SEPARATOR, T_STRING])) {
                $currentNamespaceTokens[] = $currentToken[1];
            }

        } while ($currentTokenCode != ';');

        $currentNamespace = implode(',', $currentNamespaceTokens);
        if (!strcmp($currentNamespace, $namespace)) {
            return $this->forwardToNamespace($tokens, $namespace);
        }

        return;
    }

    private function forwardToNextUse(array &$tokens)
    {
        while(!count($tokens)) {
            return;
        }

        $head = reset($tokens);

        if (!is_array($head)) {
            array_shift($tokens);
            return $this->forwardToNextUse($tokens);
        }

        $code = reset($head);

        switch ($code)
        {
            case T_CLASS:
            case T_NAMESPACE:
            case T_FUNCTION:
                $tokens = [];
                return;

            case T_USE:
                return;

            default:
                array_shift($tokens);
                return $this->forwardToNextUse($tokens);
        }

        if (reset($head) === T_USE) {
            return;
        }

        array_shift($tokens);
        return $this->forwardToNextUse($tokens);
    }

    public function stripUse(array &$tokens, array &$imports = []): array
    {
        $head = reset($tokens);
        $tokenCode = is_array($head) ? reset($head) : $head;

        switch ($tokenCode)
        {
            case ';':
                return $imports;

            case T_NS_SEPARATOR:
            case T_STRING:
                $imports[] = $head[1];
                // fallover

            default:
                array_shift($tokens);
                return $this->stripUse($tokens, $imports);
        }
    }
}

<?php

namespace Clue\Commander\Tokens;

use InvalidArgumentException;

class AlternativeToken implements TokenInterface
{
    private $tokens = array();

    public function __construct(array $tokens)
    {
        foreach ($tokens as $token) {
            if ($token instanceof OptionalToken) {
                throw new InvalidArgumentException('Alternative group must not contain optional tokens');
            } elseif (!$token instanceof TokenInterface) {
                throw new InvalidArgumentException('Alternative group must only contain valid tokens');
            } elseif ($token instanceof self) {
                // merge nested alternative group
                foreach ($token->tokens as $token) {
                    $this->tokens []= $token;
                }
            } else {
                // append any valid alternative token
                $this->tokens []= $token;
            }
        }

        if (count($this->tokens) < 2) {
            throw new InvalidArgumentException('Alternative group must contain at least 2 tokens');
        }
    }

    public function matches(array &$input, array &$output)
    {
        foreach ($this->tokens as $token) {
            if ($token->matches($input, $output)) {
                return true;
            }
        }

        return false;
    }

    public function __toString()
    {
        return implode(' | ', $this->tokens);
    }
}

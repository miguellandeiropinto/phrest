<?php

use Clue\Commander\Tokens\AlternativeToken;
use Clue\Commander\Tokens\OptionalToken;
use Clue\Commander\Tokens\WordToken;

class AlternativeTokenTest extends PHPUnit_Framework_TestCase
{
    public function testSupportsAnyTwoTokens()
    {
        new AlternativeToken(array(
            $this->getMock('Clue\Commander\Tokens\TokenInterface'),
            $this->getMock('Clue\Commander\Tokens\TokenInterface'),
        ));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRequiresTokens()
    {
        new AlternativeToken(array());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRequiresValidTokens()
    {
        new AlternativeToken(array(
            true,
            false,
        ));
    }

    public function testDoesNotSupportOptional()
    {
        $token = $this->getMock('Clue\Commander\Tokens\TokenInterface');
        $tokens = array(
            $token,
            new OptionalToken($token)
        );

        $this->setExpectedException('InvalidArgumentException');
        new AlternativeToken($tokens);
    }

    public function testSingleNestedAlternativeBlockWillBeAccepted()
    {
        $token = new AlternativeToken(array(
            new WordToken('a'),
            new WordToken('b')
        ));

        $token = new AlternativeToken(array($token));

        $this->assertEquals('a | b', $token);
    }

    public function testNestedAlternativeBlocksWillBeMerged()
    {
        $token = new AlternativeToken(array(
            new WordToken('a'),
            new WordToken('b')
        ));

        $token = new AlternativeToken(array($token, $token));

        $this->assertEquals('a | b | a | b', $token);
    }
}

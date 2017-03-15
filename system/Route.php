<?php

namespace System;

class Route {

    public function __construct ( $uri, $controller )
    {
        $this->url = $uri;
        $this->class = $controller[0];
        $this->method = $controller[1];
        $this->patterns = [];
        $this->slugs = explode('/', rtrim(ltrim($this->url, '/'), '/'));
        $this->parameters = [];
        $this->parseParameters();
        $this->requires = [];
    }

    function match ( Request $request )
    {
        if ( count($this->slugs) != count($request->getURIArray()) ) return false;

        for( $i = 0; $i < count($request->getURIArray()); $i++ )
        {
            if ($request->getURIArray()[$i] == $this->slugs[$i]) {
                continue;
            } else {
                $valid = false;
                foreach ( $this->parameters as $paramName =>$paramURLIndex )
                {
                    if ( $paramURLIndex == $i ) {
                        if ( preg_match( $this->patterns[$paramName], $request->getURIArray()[$i], $match ) ) {
                            $request->params[$paramName] = $match[0];
                            $valid = true;
                            continue;
                        } else {
                            return false;
                        }
                    }
                }
                if ( !$valid )  return false;
            }
        }
        return true;
    }


    function patterns ( array $patterns = [] )
    {
        $this->patterns = $patterns;
        return $this;
    }

    function parseParameters ()
    {
        for ( $i = 0; $i < count($this->slugs); $i++ )
        {
            if (preg_match_all( '/\{([[:ascii:]]+)\}/', $this->slugs[$i], $matches )) {

                foreach ( $matches[1] as $match ) {

                    $paramData = $match;
                    $paramName = str_replace('?', '', $paramData);
                    $this->parameters[$paramName] = $i;

                }

            }

        }

    }

    public function execute ( Request $request ) {
        $class = CTRLS_NS . '\\' . $this->class;
        $method = $this->method;
        $controller = new $class();
        $controller->$method($request, new Response());
    }

    function requires ( $requires = null ) {
        if ( !$requires ) return false;
        $this->requires = array_merge( $this->requires, $requires );
        return $this;
    }

    function needs ( $require ) {
        if (in_array($require, $this->requires)) return true;
        return false;
    }

}

?>

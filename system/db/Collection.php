<?php

namespace System\Database;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Collection
    extends EloquentCollection
    implements XMLService, JSONService
{

    public $encodedXML = "";
    public $xml;
    protected $nsUri = APP_XML_NAMESPACE;
    protected $nsMark = "{" . APP_XML_NAMESPACE . "}";

    public function __construct($models, $namespace, $collectionRoot = "")
    {
        parent::__construct($models);
        $this->xmlNamespace = $namespace;
        $this->collectionXmlRoot = $collectionRoot;
    }

    public function encodeXML($include = null, $exclude = null)
    {

        $service = new \Sabre\Xml\Service();
        $service->namespaceMap = [$this->nsUri => $this->xmlNamespace];

        $xml = [];

        foreach ($this->items as $item) {
            $xml[][$this->nsMark . $item->getXmlRootElement()] = $service->parse($item->parseToXml($include, $exclude));
        }

        $this->xml = $xml;
        $this->encodedXML = $service->write($this->nsMark . $this->collectionXmlRoot, $this->xml);

        return $this;

    }

    public function decodeXML($xml = false)
    {

    }

    public function encodeJSON()
    {
        $this->encodedJSON = json_encode((array)$this->items, JSON_PRETTY_PRINT);
        return $this;
    }

    public function decodeJSON($json = false)
    {
        $json = !$json ? $this->encodeJSON()->encodedJSON : $json;
        $this->decodedJSON = json_decode($json);
        return $this;
    }

}

?>

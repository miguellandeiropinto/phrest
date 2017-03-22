<?php

namespace System\Database;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Sabre\Xml\Writer;

interface XMLService
{

    public function decodeXML($xml);

    public function encodeXML();

}

interface JSONService
{

    public function decodeJSON($json);

    public function encodeJSON();

}

class Model
    extends Eloquent
    implements XMLService, JSONService
{

    protected $nsUri = APP_XML_NAMESPACE;
    protected $nsMark = "{" . APP_XML_NAMESPACE . "}";

    public function encodeXML($include = null, $exclude = null)
    {

        $service = new \Sabre\Xml\Service();
        $service->namespaceMap = [
            $this->nsUri => $this->xmlNamespace
        ];

        $this->xml = $service->parse($this->parseToXml($include, $exclude));
        $this->encodedXML = $service->write($this->nsMark . $this->xmlRoot, $this->xml);

        return $this;

    }

    function parseToXml($include = null, $exclude = null)
    {

        $service = new \Sabre\Xml\Service();

        if (method_exists($this, 'serializeXML')) {
            $str = $this->serializeXML($service, $include, $exclude);
            return $str;
        }

        $service->namespaceMap = [$this->nsUri => $this->xmlNamespace];

        $writer = new \Sabre\Xml\Writer();

        $writer->openMemory();
        $writer->setIndent(true);

        $arrXml = [$this->nsMark . $this->xmlRoot => []];

        if (!$include || count($include) == 0) {
            foreach ($this->attributes as $key => $value) {
                $arrXml[$this->nsMark . $this->xmlRoot][$this->nsMark . $key] = $value;
            }
        } else {
            foreach ($include as $field) {
                $arrXml[$this->nsMark . $this->xmlRoot][$this->nsMark . $field] = $this->attributes[$field];
            }
        }

        if ($exclude && is_array($exclude)) {
            foreach ($exclude as $field) {
                unset($arrXml[$this->nsMark . $this->xmlRoot][$this->nsMark . $field]);
            }
        }

        $writer->write($arrXml);

        $str = $writer->outputMemory();
        $writer->flush(true);

        return $str;

    }

    public function decodeXML($xml = false)
    {
        $service = new \Sabre\Xml\Service();
        return $this;
    }

    public function newCollection(array $models = [])
    {
        return new Collection($models, $this->xmlNamespace, $this->collectionXmlRoot);
    }

    public function encodeJSON()
    {
        $this->encodedJSON = json_encode((array)$this->attributes, JSON_PRETTY_PRINT);
        return $this;
    }

    public function decodeJSON($json = false)
    {
        $json = !$json ? $this->encodeJSON()->encodedJSON : $json;
        $this->decodedJSON = json_decode($json);
        return $this;
    }

    public function saveJSON()
    {

    }

    public function getXmlNamespace()
    {
        return $this->xmlNamespace;
    }

    public function getXmlRootElement()
    {
        return $this->xmlRoot;
    }


}

?>

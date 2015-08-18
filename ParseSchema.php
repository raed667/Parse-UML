<?php

namespace ParseSchema;

/**
 * Description of ParseSchema
 *
 * @author Raed Chammam
 */
class ParseSchema {

    public $relations = array();

    public function getUML($chosenObjects) {
        $UML = "@startuml \n";

        $UML .= $this->parseDateClassPalm(); // We add Date class because it is available by default in all objects
        /*
         * First check if $chosenObjects is an array and is not empty
         */
        if (!is_array($chosenObjects) || count($chosenObjects) < 1) {
            return NULL;
        }

        foreach ($chosenObjects as $ClassName => $value) {
            $UML .= $this->parsePalmClass($ClassName, $value);
        }

        foreach ($this->relations as $key => $value) {
            $UML.= $key . ' -- ' . $value . "\n";
        }
        $UML .= "@enduml";

        return $UML;
    }

    private function parsePalmClass($ClassName, $obj) {

        if (is_array($obj)) {
            $keys = array();
            foreach ($obj as $value) {
                $keys = array_merge($keys, $this->objectToArray($value));
            }
        } else {
            $keys = $this->objectToArray($obj);
        }



        $palmClass = "class $ClassName { \n";

        foreach ($keys as $key => $value) {
            if ($key != "updatedAt" && $key != "createdAt") {
                $palmClass .= $key . "\n";
            } else {
                $palmClass .= '_Date ' . $key . "\n";
            }
        }
        $palmClass .= "} \n";

        return $palmClass;
    }

    private function parseDateClassPalm() {
        return "class _Date { \n date \n timezone_type \n timezone \n }\n";
    }

    private function objectToArray($parseObject) {
        $UserKeys = array();
        $json = ($parseObject->_encode());
        $array = json_decode($json);

        foreach ($array as $key => $value) {
            $UserKeys[$key] = $key;
            if (is_object($parseObject->get($key))) {
                $this->relations[$parseObject->getClassName()] = $parseObject->get($key)->getClassName();
            }
            if (is_object($value) && ($key != "updatedAt" && $key != "createdAt")) {
                $UserKeys[$key] = array();
                foreach ($value as $key2 => $value2) {
                    $UserKeys[$key][$key2] = $key2;
                }
            }
        }
        return $UserKeys;
    }

}

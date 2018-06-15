<?php

namespace PubPeerFoundation\PublicationDataExtractor\Test;

use ReflectionClass;
use SimpleXMLElement;

trait TestHelpers
{
    /**
     * Sets a protected property on a given object via reflection.
     *
     * @param $object - instance in which protected value is being modified
     * @param $property - property on instance being modified
     * @param $value - new value of the property being modified
     * @throws \ReflectionException
     */
    public function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }

    /**
     * Gets a protected property on a given object via reflection.
     *
     * @param $object - instance in which protected value is being modified
     * @param $property - property on instance being modified
     *
     * @return mixed
     * @throws \ReflectionException
     */
    public function getProtectedProperty($object, $property)
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);

        return $reflection_property->getValue($object);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on
     * @param string $methodName Method name to call
     * @param array $parameters array of parameters to pass into method
     *
     * @return mixed method return
     * @throws \ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Loads and decodes Json file.
     *
     * @param $name
     * @return mixed
     */
    public function loadJson($name)
    {
        return json_decode(file_get_contents(__DIR__.'/Integration/stubs/'.$name.'.json'), true);
    }

    /**
     * Loads and decodes Xml file.
     *
     * @param $name
     * @return SimpleXMLElement
     */
    public function loadXml($name)
    {
        return new SimpleXMLElement(file_get_contents(__DIR__.'/Integration/stubs/'.$name.'.xml'));
    }
}

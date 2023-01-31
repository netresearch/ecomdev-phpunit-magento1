<?php

class EcomDev_PHPUnitTest_Test_Lib_Constraint_Config_Node extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Creates constraint instance
     *
     * @param $nodePath
     * @param $type
     * @param $value
     *
     * @return EcomDev_PHPUnit_Constraint_Config_Node
     */
    protected function _getConstraint($nodePath, $type, $value)
    {
        return new EcomDev_PHPUnit_Constraint_Config_Node($nodePath, $type, $value);
    }

    /**
     * Tests that particular value equals xml
     *
     * @dataProvider dataProvider
     */
    public function testEqualsXml(string $actualValue, string $expectedValue)
    {
        $actualValue = new SimpleXMLElement($actualValue);
        $expectedValue = new SimpleXMLElement($expectedValue);

        $constraint = $this->_getConstraint(
            'some/dummy/path',
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_XML,
            $expectedValue
        );

        $this->assertTrue($constraint->evaluate($actualValue, '', true));
        $this->assertInstanceOf(\SebastianBergmann\Comparator\ComparisonFailure::class, $constraint->getComparisonFailure($expectedValue, $actualValue));
    }

    /**
     * Tests that particular value equals xml
     *
     * @dataProvider dataProvider
     */
    public function testEqualsXmlFailure(string $actualValue, string $expectedValue)
    {
        $actualValue = new SimpleXMLElement($actualValue);
        $expectedValue = new SimpleXMLElement($expectedValue);

        $constraint = $this->_getConstraint(
            'some/dummy/path',
            EcomDev_PHPUnit_Constraint_Config_Node::TYPE_EQUALS_XML,
            $expectedValue
        );

        $this->assertFalse($constraint->evaluate($actualValue, '', true));
        $this->assertInstanceOf(\SebastianBergmann\Comparator\ComparisonFailure::class, $constraint->getComparisonFailure($expectedValue, $actualValue));
    }
}
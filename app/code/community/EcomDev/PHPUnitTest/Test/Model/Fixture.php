<?php

/**
 * @loadSharedFixture testFixtureArrayMerge.yaml
 */
class EcomDev_PHPUnitTest_Test_Model_Fixture extends EcomDev_PHPUnit_Test_Case
{
    public function testFixtureArrayMerge(): void
    {
        require_once $this->_getVfsUrl('app/code/community/EcomDev/PHPUnit/Test/Model/ExampleClass.php');

        $testCase = new EcomDev_PHPUnitTest_Test_Model_ExampleClass();
        $testCase->setName('testLoadFixtureOrder');
        $this->getFixture()->loadForClass(get_class($testCase));
        $this->getFixture()->loadByTestCase($testCase);
        $this->getFixture()->apply();
    }

    public function testLoadClassBeforeMethodFixtures(): void
    {
        require_once $this->_getVfsUrl('app/code/community/EcomDev/PHPUnit/Test/Model/ExampleClass.php');

        $testCase = new EcomDev_PHPUnitTest_Test_Model_ExampleClass();
        $testCase->setName('testLoadFixtureOrder');
        $this->getFixture()->loadForClass(get_class($testCase));
        $this->getFixture()->loadByTestCase($testCase);
        $this->getFixture()->apply();
        $this->assertEquals('methodFixtureValue', Mage::getStoreConfig('sample/path'));
    }

    protected function _getVfsUrl($path): string
    {
        return $this->getFixture()->getVfs()->url($path);
    }
}

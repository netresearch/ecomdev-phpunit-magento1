<?php
/**
 * PHP Unit test suite for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev_PHPUnit
 * @copyright  Copyright (c) 2013 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */

class EcomDev_PHPUnitTest_Test_Helper_Mock extends EcomDev_PHPUnit_Test_Case
{
    public function testMockClassAlias()
    {
        $mock = $this->mockClassAlias('model', 'catalog/product', ['getId'], [['entity_id' => 1]]);

        $this->assertInstanceOf(EcomDev_PHPUnit_Mock_Proxy::class, $mock);
        $this->assertStringContainsString($this->getGroupedClassName('model', 'catalog/product'), $mock->getMockClass());
        $this->assertTrue(method_exists($mock->getMock(), 'getId'));
        $this->assertEquals(1, $mock->getMock()->getEntityId());
    }

    public function testModelMock()
    {
        $mock = $this->mockModel('catalog/product', ['getId'], [['entity_id' => 1]]);

        $this->assertInstanceOf(EcomDev_PHPUnit_Mock_Proxy::class, $mock);
        $this->assertStringContainsString($this->getGroupedClassName('model', 'catalog/product'),  $mock->getMockClass());
        $this->assertTrue(method_exists($mock->getMock(), 'getId'));
        $this->assertEquals(1, $mock->getMock()->getEntityId());
    }

    public function testBlockMock()
    {
        $mock = $this->mockBlock('catalog/product_view', ['getTemplate'], [['product_id' => 1]]);

        $this->assertInstanceOf(EcomDev_PHPUnit_Mock_Proxy::class, $mock);
        $this->assertStringContainsString($this->getGroupedClassName('block', 'catalog/product_view'), $mock->getMockClass());
        $this->assertTrue(method_exists($mock->getMock(), 'getTemplate'));
        $this->assertEquals(1, $mock->getMock()->getProductId());
    }

    public function testHelperMock()
    {
        $mock = $this->mockHelper('catalog/category', ['getStoreCategories']);

        $this->assertInstanceOf(EcomDev_PHPUnit_Mock_Proxy::class, $mock);
        $this->assertStringContainsString($this->getGroupedClassName('helper', 'catalog/category'), $mock->getMockClass());
        $this->assertTrue(method_exists($mock->getMock(), 'getStoreCategories'));
    }
}
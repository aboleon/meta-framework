<?php

namespace Tests\Unit\Traits;

use MetaFramework\Facades\MetaFacade;
use MetaFramework\Models\Bloc;
use MetaFramework\Models\Meta;
use PHPUnit\Framework\TestCase;

class MetaParamsTest extends TestCase
{

    /**
     * @test
     * @covers MetaParams::hasForms
     * @covers MetaParams::isUsingForms
     */
    public function form_usage_is_disabled_by_default_and_can_be_set_by_method_call()
    {
        // Arrange
        $testable = new Meta();

        $this->assertFalse($testable->isUsingForms());

        // Act
        $testable->hasForms();

        // Assert
        $this->assertTrue($testable->isUsingForms());
    }

    /**
     * @test
     * @covers MetaParams::hasBlocs
     * @covers MetaParams::isUsingBlocs
     */
    public function bloc_usage_is_disabled_by_default_and_can_be_set_by_method_call()
    {
        // Arrange
        $testable = new Meta();

        $this->assertFalse($testable->isUsingBlocs());

        // Act
        $testable->hasBlocs();

        // Assert
        $this->assertTrue($testable->isUsingBlocs());
    }

    /**
     * @test
     * @covers MetaParams::isReliyingOnMeta
     */
    public function submodel_is_using_meta_database_model_by_default()
    {
        // Make new submodel variation of Meta model
        $testable = new Meta\SubModelExample();

        // SubModel relies on Meta model by default
        $this->assertTrue($testable->isReliyingOnMeta());

        // Submodel has its own table (database model)
        $testable->setTable('submodel_table');
        $this->assertTrue($testable->getTable() === 'submodel_table');

        // Assert SubModel is not relying on Meta Model
        $this->assertFalse($testable->isReliyingOnMeta());
    }

    /**
     * @test
     * @covers MetaParams::isStoringMetaContentAsJson
     */

    public function submodel_is_not_storing_content_as_json_by_default()
    {
        // Make new submodel variation of Meta model
        $testable = new Meta\SubModelExample();

        // Assert SubModel is not storing json in content field
        $this->assertFalse($testable->isStoringMetaContentAsJson());
    }
    /**
     * @test
     * @covers MetaParams::storeMetaContentAsJson
     */
    public function submodel_is_storing_content_as_json()
    {
        // Make new submodel variation of Meta model
        $testable = new Meta\SubModelExample();

        $testable->storeMetaContentAsJson();

        // Assert SubModel will store json in content field
        $this->assertTrue($testable->isStoringMetaContentAsJson());
    }
}

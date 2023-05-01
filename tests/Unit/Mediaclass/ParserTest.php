<?php

namespace Tests\Unit\Mediaclass;

use MetaFramework\Mediaclass\Config;
use MetaFramework\Models\Meta\SubModelExample;
use Orchestra\Testbench\TestCase;
use MetaFramework\Mediaclass\Models\Media;
use MetaFramework\Mediaclass\Parser;

class ParserTest extends TestCase
{
    protected Media $media;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->setMedia();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('mediaclass.dimensions', [
            'test_size' => [
                'width' => 123,
                'height' => 456,
            ],
        ]);
    }
    public function testParserConstructionAndProperties()
    {

        // Add necessary properties to the Media object based on your Media class implementation

        $parser = new Parser($this->media);

        $this->assertEquals(1, $parser->id);
        $this->assertEquals('testGroup', $parser->group);
        $this->assertEquals('testPosition', $parser->position);
        $this->assertEquals('Test Description', $parser->description);
    }
/*
    public function testParseUrls()
    {

        // Add necessary properties to the Media object based on your Media class implementation

        $parser = new Parser($this->media);

        // Mock the Path::mediaFolderName method if it has external dependencies
        // Mock the Storage facade methods if they have external dependencies

        $sizes = array_merge(array_keys(Config::getSizes()), ['cropped']);

        $urls = $parser->parseUrls($this->media, $sizes);
        de($urls);
        // Assert that the correct URL(s) are generated for your specific use case
        // Modify the assertions as needed, based on your expected output
        $this->assertArrayHasKey('test_size', $urls);
       // $this->assertEquals('expected_url', $urls['test_size']);
    }
*/
    private function setMedia(): void
    {

        $this->media = new Media();
        $this->media->id = 1;
        $this->media->group = 'testGroup';
        $this->media->position = 'testPosition';
        $this->media->description = ['en' => 'Test Description'];
        $this->media->mime = 'image/jpeg';
        $this->media->model = new SubModelExample();
        $this->media->filename = 'testFile';
        $this->media->extension = 'jpg';
    }
}

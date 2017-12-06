<?php

namespace Tests\Unit;

use \App\Helper\Algolia;

class AlgoliaTest extends \PHPUnit_Framework_TestCase
{
    /** @var Algolia  */
    protected $algoliaHelper;

    /**
     * AlgoliaTest constructor.
     *
     **/
    public function __construct()
    {
        parent::__construct();
        $this->algoliaHelper = new Algolia();
    }

    /**
     *
     * @covers Algolia::addApp
     */
    public function testAddApp()
    {
        $this->expectException('Exception');
        $this->algoliaHelper->addApp($this->getSampleApplicationWithMissingName());

        $this->expectException('Exception');
        $this->algoliaHelper->addApp($this->getSampleApplicationWithNonNumericRank());
    }

    /**
     * (successful app addition id tested in API functional test)
     *
     * @covers Algolia::addAppFromApi
     */
    public function testAddAppFromApi()
    {
        $result = $this->algoliaHelper->addAppFromApi(
            $this->getSampleApplicationWithMissingName()
        );
        $this->assertArrayHasKey('errors', $result);

        $result = $this->algoliaHelper->addAppFromApi(
            $this->getSampleApplicationWithNonNumericRank()
        );
        $this->assertArrayHasKey('errors', $result);
    }

    /**
     * @covers Algolia::validateAppData
     */
    public function testValidateAppData()
    {
        $result = $this->algoliaHelper->validateAppData($this->getSampleApplication());
        $this->assertEquals(0, count($result['errors']));

        $result = $this->algoliaHelper->validateAppData($this->getSampleApplicationWithMissingName());
        $this->assertGreaterThan(0, count($result['errors']));

        $result = $this->algoliaHelper->validateAppData($this->getSampleApplicationWithNonNumericRank());
        $this->assertGreaterThan(0, count($result['errors']));
    }

    /**
     * @covers Algolia::getIndexCategories
     */
    public function testGetIndexCategories()
    {
        $result = $this->algoliaHelper->getIndexCategories();
        $this->assertInternalType('array', $result);
    }

    /**
     * @covers Algolia::searchAppsByName
     */
    public function testSearchAppsByName()
    {
        $result = $this->algoliaHelper->searchAppsByName('book');
        $this->assertInternalType('array', $result);
    }

    /**
     * Sample application data
     */
    protected function getSampleApplication()
    {
        return [
            'name'     => 'Damcou book',
            'image'    => 'http://www.hostingpics.net/thumbs/49/53/04/mini_495304applelogoblue175px.jpg',
            'link'     => 'http://itunes.apple.com/us/app/ibooks/id364709193?mt=8',
            'category' => 'Books',
            'rank'     =>  3
        ];
    }

    /**
     * Sample application data with missing name
     */
    protected function getSampleApplicationWithMissingName()
    {
        return [
            'name'     => '',
            'image'    => 'http://www.hostingpics.net/thumbs/49/53/04/mini_495304applelogoblue175px.jpg',
            'link'     => 'http://itunes.apple.com/us/app/ibooks/id364709193?mt=8',
            'category' => 'Books',
            'rank'     =>  3
        ];
    }

    /**
     * Sample application data with non numeric rank
     */
    protected function getSampleApplicationWithNonNumericRank()
    {
        return [
            'name'     => 'Damcou book',
            'image'    => 'http://www.hostingpics.net/thumbs/49/53/04/mini_495304applelogoblue175px.jpg',
            'link'     => 'http://itunes.apple.com/us/app/ibooks/id364709193?mt=8',
            'category' => 'Books',
            'rank'     =>  'abc'
        ];
    }
}

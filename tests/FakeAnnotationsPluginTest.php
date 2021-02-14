<?php


namespace Apie\Tests\FakeAnnotationsPlugin;

use Apie\Core\Annotations\ApiResource;
use Apie\Core\Apie;
use Apie\CorePlugin\DataLayers\NullDataLayer;
use PHPUnit\Framework\TestCase;

class FakeAnnotationsPluginTest extends TestCase
{
    /**
     * @var Apie
     */
    private $apie;

    protected function setUp(): void
    {
        $config = [
            Status::class => ApiResource::createFromArray([
                'retrieveClass' => NullDataLayer::class,
                'persistClass' => NullDataLayer::class
            ])
        ];
        $this->apie = new Apie(
            [
                new StaticConfigPlugin(''),
                new FakeAnnotationsPlugin($config),
                new StatusCheckPlugin([])
            ], true, null);
    }

    public function test_override_config_working()
    {
        $specGenerator = $this->apie->getOpenApiSpecGenerator();

        $doc = $specGenerator->getOpenApiSpec();

        $actual = $doc->paths['/status/{id}'];
        $this->assertNotNull($actual->get);
        $this->assertNotNull($actual->put);
        $this->assertNotNull($actual->delete);

        $actual = $doc->paths['/status'];
        $this->assertNotNull($actual->get);
        $this->assertNotNull($actual->post);
    }
}

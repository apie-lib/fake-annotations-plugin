<?php


namespace Apie\FakeAnnotationsPlugin;

use Apie\Core\PluginInterfaces\AnnotationReaderProviderInterface;
use Apie\Core\PluginInterfaces\ApieAwareInterface;
use Apie\Core\PluginInterfaces\ApieAwareTrait;
use Apie\CorePlugin\CorePlugin;
use Doctrine\Common\Annotations\Reader;

final class FakeAnnotationsPlugin implements AnnotationReaderProviderInterface, ApieAwareInterface
{
    use ApieAwareTrait;

    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getAnnotationReader(): Reader
    {
        $reader = $this->getApie()->getPlugin(CorePlugin::class)->getAnnotationReader();
        return new ExtendReaderWithConfigReader($reader, $this->config);
    }
}

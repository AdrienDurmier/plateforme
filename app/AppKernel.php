<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // Bundles Symfony
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            // Bundles de la plateforme
            new Plateforme\CoreBundle\PlateformeCoreBundle(),
            new Plateforme\CatalogueBundle\PlateformeCatalogueBundle(),
            new Plateforme\EcommerceBundle\PlateformeEcommerceBundle(),
            new Plateforme\UserBundle\PlateformeUserBundle(),
            // Bundles de la communauté
            new PUGX\MultiUserBundle\PUGXMultiUserBundle(),                     // @see https://github.com/PUGX/PUGXMultiUserBundle/blob/master/Resources/doc/index.md
            new FOS\UserBundle\FOSUserBundle(),                                 // @see http://knpbundles.com/FriendsOfSymfony/FOSUserBundle
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),                     // http://symfony.com/doc/master/bundles/IvoryCKEditorBundle/index.html + installation CKeditor: http://symfony.com/doc/master/bundles/IvoryCKEditorBundle/installation.html,
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            // Bundles de la communauté
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}

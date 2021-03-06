<?php
    namespace Core\Providers;

    use Symfony\Component\Routing\Generator\UrlGenerator;
    use Twig_Loader_Filesystem;
    use Twig_Environment;
    use Twig_SimpleFunction;

    class TwigServiceProvider extends ServiceProvider
    {
        public function provide(array $options = []){
            $loader = new Twig_Loader_Filesystem($this->config['dir']);
            $twig = new Twig_Environment($loader, array(
                'cache' => $this->config['cache'],
                'auto_reload' => true
            ));
            if (!isset($options['urlGenerator']) || false == $options['urlGenerator'] instanceof UrlGenerator) {
                throw new \Exception('Twig provide must have UrlGenerator');
            }
            $functionUrlGenerator = new Twig_SimpleFunction('url', function($name, $parameters = []) use ($options){
                return $options['urlGenerator']->generate($name, $parameters);  
            });

            $twig->addFunction($functionUrlGenerator);

            return $twig;
        }
    }
    
?>
<?php


namespace Demo\SymfonyContainer\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * This is run at compile stage only.
 *
 * https://symfony.com/doc/current/service_container/tags.html
 */
class ApiManagerCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        // Get the API manager name we should be using.  
        $apiManagerName = $container->getParameter('api_manager_name');
        
        // Get the config for all API managers. 
        $apiManagersConfig = $container->getParameter('api_managers');

        
        // Get API manager config for the specific API manager we're using. 
        $apiManagerConfig = $apiManagersConfig[$apiManagerName];
        
        // Get base URL
        $baseUrl = $apiManagerConfig['base_url'];
        

        $baseContentTypeServiceDefinition = $container->getDefinition('api.base_content_type');


        // Loop through all the services tagged with ApiManager (where the tag name = ApiManager)
        $apiManagerServices = $container->findTaggedServiceIds('ApiManager');
        foreach($apiManagerServices as $id => $tags) {
            foreach($tags as $tag) {
                if ($tag['api_name'] == $apiManagerName) {

                    // We're found the matching API Manager.

                    // Get the class of the Api Manager
                    $apiManagerServiceDefinition = $container->findDefinition($id);
                    $apiManagerClass = $apiManagerServiceDefinition->getClass();


                    // Now fill in the missing bits for the api.base_content_type service definition.

                    // Set the class
                    $baseContentTypeServiceDefinition->setClass($apiManagerClass);

                    // Update first constructor argument (baseURL)
                    $baseContentTypeServiceDefinition->replaceArgument(0, $baseUrl);

                    // Update second constructor argument (the config specific for this Api Manager)
                    $baseContentTypeServiceDefinition->replaceArgument(1, $apiManagerConfig);
                }
            }
        }
        
        // TODO: throw exception if not service could be found
    }
}
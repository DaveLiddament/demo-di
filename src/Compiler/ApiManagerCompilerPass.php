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
                    
                    
                    
                    // Finally setup content types
                    $contentTypeServices = $container->findTaggedServiceIds('ContentType');
                    foreach($contentTypeServices as $contentTypeId => $contentTypeTags) {
                        foreach($contentTypeTags as $contentTypeTag) {
                            $contentTypeKey = $contentTypeTag['content_type_key'];
                            $contentTypeConfig = $apiManagerConfig[$contentTypeKey];


                            $contentTypeServiceDefinition = $container->findDefinition($contentTypeId);
                            // Update the second constructor argument (config). This is specific to API manager AND content type
                            $contentTypeServiceDefinition->replaceArgument(1, $contentTypeConfig);
                        }
                    }
                    
                }
            }
        }
        
        // TODO: throw exception if not service could be found
    }
}
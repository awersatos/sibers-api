<?php
/**
 * Created by PhpStorm.
 * User: jedi
 * Date: 05.01.18
 * Time: 15:31
 */

namespace Sibers\ApiBundle\Swagger;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class SwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    const OPERATIONS = ['get', 'post', 'put', 'delete'];

    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $customDefinition = [
            'name' => 'fields',
            'definition' => 'Fields to remove of the outpout',
            'default' => 'id',
            'in' => 'query',
        ];


        // e.g. add a custom parameter
        //$docs['paths']['/foos']['get']['parameters'][] = $customDefinition;

        $pathIterator = $docs['paths']->getIterator();

        while ($pathIterator->valid()) {
            $path = $pathIterator->key();
            $pathItems = $pathIterator->current();
            foreach ($pathItems as $operation => $operationObj) {
                if (in_array($operation, self::OPERATIONS)) {
                    $operationObjIterator = $operationObj->getIterator();
                    while ($operationObjIterator->valid()) {
                        $operationKey = $operationObjIterator->key();
                        if ($operationKey == 'responses') {
                            $responses = $operationObjIterator->current();
                            foreach ($responses as $statusCode => $responseObj) {
                                /*$responseObjIterator = $responseObj->getIterator();
                                while ($responseObjIterator->valid()) {
                                    $responseKey = $responseObjIterator->key();
                                    $responseValue = $responseObjIterator->current();
                                    $responseObjIterator->next();
                                }*/
                            }
                        }

                        $operationObjIterator->next();
                    }
                }
            }
            $pathIterator->next();
        }


        // Override title
        $docs['info']['title'] = 'My Api Foo';

        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
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
                            foreach ($responses as $statusCode => $response) {
                                if (($statusCode == 200) || ($statusCode == 201)) {
                                    $properties = ['status' => ['type' => 'string'], 'response' => $response['schema']];
                                    $docs['paths'][$path][$operation]['responses'][$statusCode]['schema'] = [];
                                    $docs['paths'][$path][$operation]['responses'][$statusCode]['schema']['properties'] = $properties;
                                } elseif ($statusCode == 204) {
                                    $docs['paths'][$path][$operation]['responses'][$statusCode]['schema']['properties']
                                        = ['status' => ['type' => 'string'], 'response' => ['type' => 'array', 'items' => ['type' => 'string']]];
                                } else {
                                    $docs['paths'][$path][$operation]['responses'][$statusCode]['schema']['properties']
                                        = ['status' => ['type' => 'string'], 'errors' => ['type' => 'array', 'items' => ['type' => 'array', 'items' => ['type' => 'string']]]];
                                }
                            }
                        }

                        $operationObjIterator->next();
                    }
                }
            }
            $pathIterator->next();
        }

        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
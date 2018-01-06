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

        /*
                $definitionsIterator = $docs['definitions']->getIterator();
                while ($definitionsIterator->valid()) {
                    $definitionName = $definitionsIterator->key();
                    $definitionObj = $definitionsIterator->current();
                    $definitionObjIterator = $definitionObj->getIterator();

                    while($definitionObjIterator->valid()){

                    }


                    $definitionsIterator->next();
                }
        */

        $docs['paths']['/api/foos']['get']['responses'][200]['schema']['properties'] = ['status' => ['type' => 'string'], 'response' => $docs['paths']['/api/foos']['get']['responses'][200]['schema']];
        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}
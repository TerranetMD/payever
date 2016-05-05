<?php

namespace AppBundle\Serializer;

use Knp\Component\Pager\Paginator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PaginatorSerializer implements NormalizerInterface
{
    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize.
     * @param string $format The format being (de-)serialized from or into.
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Paginator;
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|bool|int|float|null
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'currentPageNumber' => (int) $object->getCurrentPageNumber(),
            'numItemsPerPage' => (int) $object->getItemNumberPerPage(),
            'totalCount' => (int) $object->getTotalItemCount(),
            'pageCount' => (int) $object->getPageCount(),
        ];
    }
}
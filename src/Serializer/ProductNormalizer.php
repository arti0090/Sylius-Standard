<?php

declare(strict_types=1);

namespace App\Serializer;

use Sylius\Bundle\ApiBundle\Serializer\ProductNormalizer as DecoratedProductNormalizer;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

final class ProductNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'product_normalizer_already_called';

    /** @var DecoratedProductNormalizer $decoratedNormalizer */
    private $decoratedNormalizer;

    public function __construct(DecoratedProductNormalizer $decoratedNormalizer)
    {
        $this->decoratedNormalizer = $decoratedNormalizer;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $data = $this->decoratedNormalizer->normalize($object, $format, $context);

        unset($data['translations']);

        return $data;
    }

    public function supportsNormalization($data, $format = null, $context = []): bool
    {
        return $this->decoratedNormalizer->supportsNormalization($data, $format, $context);
    }
}

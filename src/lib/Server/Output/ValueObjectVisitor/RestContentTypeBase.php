<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzPlatformRest\Server\Output\ValueObjectVisitor;

use EzSystems\EzPlatformRest\Output\ValueObjectVisitor;
use eZ\Publish\API\Repository\Values;

/**
 * Base for RestContentType related value object visitors.
 */
abstract class RestContentTypeBase extends ValueObjectVisitor
{
    /**
     * Returns a suffix for the URL type to generate on basis of the given
     * $contentTypeStatus.
     *
     * @param int $contentTypeStatus
     *
     * @return string
     */
    protected function getUrlTypeSuffix($contentTypeStatus)
    {
        switch ($contentTypeStatus) {
            case Values\ContentType\ContentType::STATUS_DEFINED:
                return '';

            case Values\ContentType\ContentType::STATUS_DRAFT:
                return 'Draft';

            case Values\ContentType\ContentType::STATUS_MODIFIED:
                return 'Modified';
        }

        return '';
    }

    /**
     * Serializes the given $contentTypeStatus to a string representation.
     *
     * @param int $contentTypeStatus
     *
     * @return string
     */
    protected function serializeStatus($contentTypeStatus)
    {
        switch ($contentTypeStatus) {
            case Values\ContentType\ContentType::STATUS_DEFINED:
                return 'DEFINED';

            case Values\ContentType\ContentType::STATUS_DRAFT:
                return 'DRAFT';

            case Values\ContentType\ContentType::STATUS_MODIFIED:
                return 'MODIFIED';
        }

        throw new \RuntimeException("Unknown content type status: '{$contentTypeStatus}'.");
    }
}

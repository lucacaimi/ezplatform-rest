<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzPlatformRest\Server\Input\Parser\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Field as FieldCriterion;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;
use EzSystems\EzPlatformRest\Input\BaseParser;
use EzSystems\EzPlatformRest\Input\ParsingDispatcher;
use EzSystems\EzPlatformRest\Exceptions;

/**
 * Parser for Field Criterion.
 */
class Field extends BaseParser
{
    const OPERATORS = [
        'IN' => Operator::IN,
        'EQ' => Operator::EQ,
        'GT' => Operator::GT,
        'GTE' => Operator::GTE,
        'LT' => Operator::LT,
        'LTE' => Operator::LTE,
        'LIKE' => Operator::LIKE,
        'BETWEEN' => Operator::BETWEEN,
        'CONTAINS' => Operator::CONTAINS,
    ];

    /**
     * Parses input structure to a Criterion object.
     *
     * @param array $data
     * @param \EzSystems\EzPlatformRest\Input\ParsingDispatcher $parsingDispatcher
     *
     * @throws \EzSystems\EzPlatformRest\Exceptions\Parser
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\Criterion\Field
     */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher)
    {
        if (!array_key_exists('Field', $data)) {
            throw new Exceptions\Parser('Invalid <Field> format');
        }

        $fieldData = $data['Field'];
        if (empty($fieldData['name']) || empty($fieldData['operator']) || !array_key_exists('value', $fieldData)) {
            throw new Exceptions\Parser('<Field> format expects name, operator and value keys');
        }

        $operator = $this->getOperator($fieldData['operator']);

        return new FieldCriterion(
            $fieldData['name'],
            $operator,
            $fieldData['value']
        );
    }

    /**
     * Get operator for the given literal name.
     *
     * For the full list of supported operators:
     *
     * @see \EzSystems\EzPlatformRest\Server\Input\Parser\Criterion\Field::OPERATORS
     *
     * @param string $operatorName operator literal operator name
     *
     * @return string
     */
    private function getOperator($operatorName)
    {
        $operatorName = strtoupper($operatorName);
        if (!isset(self::OPERATORS[$operatorName])) {
            throw new Exceptions\Parser(
                sprintf(
                    'Unexpected Field operator, expected one of the following: %s',
                    implode(', ', array_keys(self::OPERATORS))
                )
            );
        }

        return self::OPERATORS[$operatorName];
    }
}

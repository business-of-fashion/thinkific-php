<?php

namespace Thinkific\Aggregators;

use Guzzle\Http\QueryAggregator\QueryAggregatorInterface;
use Guzzle\Http\QueryString;

/**
 * Custom Aggregator for body query string
 */
class PhpAggregator implements QueryAggregatorInterface
{
    public function aggregate($key, $value, QueryString $query)
    {
        $ret = array();

        foreach ($value as $k => $v) {
            if (is_array($v)) {
                $k   = "{$key}[]";
                $ret = array_merge($ret, self::aggregate($k, $v, $query));
            } else {
                $k   = "{$key}[{$k}]";
                $ret[$query->encodeValue($k)] = $query->encodeValue($v);
            }
        }

        return $ret;
    }
}

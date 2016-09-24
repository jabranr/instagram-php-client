<?php

namespace Jabran;

use Jabran\BaseClient;

class Client extends BaseClient	{

    /**
     * Setup an API call to search media
     *
     * @param string $resource
     * @param float $lat
     * @param float $lng
     * @param int $distance
     * @param int $count
     * @param int $min_timestamp
     * @param int $max_timestamp
     * @return mix
     */
    public function search($lat, $lng, $distance = 10, $count = 30, $min_timestamp = null, $max_timestamp = null) {

        if (!$lng || !$lat) {
            throw new \InvalidArgumentException('Expecting values for both latitude and logitude.');
        }

        $params = array();
        $params['lat'] = (float) $lat;
        $params['lng'] = (float) $lng;
        $params['distance'] = (int) $distance;
        $params['count'] = (int) $count;

        if (null !== $min_timestamp) {
            $params['min_timestamp'] = (int) $min_timestamp;
        }

        if (null !== $max_timestamp) {
            $params['max_timestamp'] = (int) $max_timestamp;
        }

        return $this->get('/media/search', $params);
    }
}
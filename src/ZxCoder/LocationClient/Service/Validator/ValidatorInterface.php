<?php
/**
 * Created by PhpStorm.
 * User: zx-coder
 * Date: 10.10.16
 * Time: 9:49
 */

namespace ZxCoder\LocationClient\Service\Validator;

interface ValidatorInterface {

    /**
     * @param  $response
     * @return bool
     */
    public function isValidResponse($response);
}

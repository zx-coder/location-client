<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 14:01
 */

namespace ZxCoder\LocationClient\Service\Validator;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraint;

class JsonValidator implements ValidatorInterface
{
    /**
     * @return Constraint
     */
    private function getSuccessConstraint()
    {
        return
            new Collection([
                'data' =>  new Collection([
                    'locations' => new All(new Collection([
                        'name' => new Required([
                            new NotBlank(),
                            new Type('string')
                        ]),
                        'coordinates' => new Collection([
                            'lat' => new Required([
                                new NotBlank(),
                                new Type('numeric')
                            ]),
                            'long' => new Required([
                                new NotBlank(),
                                new Type('numeric')
                            ])
                        ])
                    ]))
                ]),
                'success' => new Required([
                    new NotBlank(),
                    new Type('boolean')
                ]),
            ]);
    }

    /**
     * @return Constraint
     */
    private function getFailConstraint()
    {
        return
            new Collection([
                'data' =>  new Collection([
                    'message' => new Required([
                        new NotBlank(),
                        new Type('string')
                    ]),
                    'code' => new Required([
                        new NotBlank(),
                        new Type('string')
                    ])
                ]),
                'success' => new Required([
                    new Type('boolean')
                ]),
            ]);
    }

    /**
     * @param  array $response
     * @return bool
     */
    public function isValidResponse($response)
    {
        $validator = Validation::createValidator();
        $violationsOfSuccessConstraint = $validator->validate($response, $this->getSuccessConstraint());
        $violationsOfFailConstraint    = $validator->validate($response, $this->getFailConstraint());

        if (0 === count($violationsOfSuccessConstraint) || 0 === count($violationsOfFailConstraint)) {
            return true;
        } else {
           return false;
        }
    }
}

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zx-coder
 * Date: 09.10.16
 * Time: 1:00
 */

namespace ZxCoder\LocationClient\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationsController extends Controller
{
    /**
     * @Route("/locations_success", name="locations_success")
     * @return JsonResponse
     */
    public function successAction()
    {
        return new JsonResponse([
           'data' => [
                'locations' => [
                    [
                        'name' => 'name',
                        'coordinates' => [
                            'lat'  => 21.1,
                            'long' => 22.1,
                        ]
                    ],
                    [
                        'name' => 'name1',
                        'coordinates' => [
                            'lat'  => 23.1,
                            'long' => 22.1,
                        ]
                    ],
                ]
            ],
           'success' => true,
        ]);
    }

    /**
     * @Route("/locations_fail", name="locations_fail")
     * @return JsonResponse
     */
    public function failAction()
    {
        return new JsonResponse([
            'data' => [
                'message' => 'error',
                'code'    => '500',
            ],
            'success' => false,
        ]);
    }
}

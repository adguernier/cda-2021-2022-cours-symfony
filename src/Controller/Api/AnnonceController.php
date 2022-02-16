<?php

namespace App\Controller\Api;

use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/api/annonce/search-by-position")
     */
    public function searchByPosition(Request $request, AddressRepository $addressRepository): Response
    {
        $lat = $request->query->get('lat');
        $lng = $request->query->get('lon');
        $radius = $request->query->get('radius', 10);

        $addresses = $addressRepository->findByPosition($lat, $lng, $radius);
        dd($addresses);
    }
}

<?php

namespace App\Controller\Api;

use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/api/annonce/search-by-position")
     */
    public function searchByPosition(
        Request $request, 
        AddressRepository $addressRepository
    ): Response
    {
        $lat = $request->query->get('lat', 48.5914309773888);
        $lng = $request->query->get('lon', 7.705663193322531);

        $radius = $request->query->get('radius', 10);

        $addresses = $addressRepository->findByPosition($lat, $lng, $radius);

        return $this->json($addresses, Response::HTTP_OK, [], [
            'groups' => ['address', 'annonce']
        ]);
    }
}
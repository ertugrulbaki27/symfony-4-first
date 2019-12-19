<?php


namespace App\Controller;


use App\Entity\Hotel;
use App\Services\DateCalculator;
use App\Services\RandomNumberGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    private const HOTEL_OPENED = 1969;


    /**
     * @Route("/")
     */
    public function home(LoggerInterface $logger, DateCalculator $dateCalculator)
    {
//        return new Response(
//            '<h1>My first symfony</h1>'
//        );

        //return  $this->json(['data' => 'here']);

        $logger->info('homepage loaded');

//        $year = random_int(0, 100);

        $year = $dateCalculator->yearsDifference(self::HOTEL_OPENED);

        $hotels = $this->getDoctrine()
                        ->getRepository(Hotel::class)
                        ->findAllBelowPrice(750);
                         //->findAll();
//                       ->findOneBy(['name' => 'ertugrul']);

        $images = [
                ['url' => 'images/hotel/intro_room.jpg', 'class' => ''],
                ['url' => 'images/hotel/intro_pool.jpg', 'class' => ''],
                ['url' => 'images/hotel/intro_dining.jpg', 'class' => ''],
                ['url' => 'images/hotel/intro_attractions.jpg', 'class' => ''],
            ];

        return $this->render('index.html.twig', [
            'year' => $year,
            'images' => $images,
            'hotels' => $hotels
        ]);
    }
}
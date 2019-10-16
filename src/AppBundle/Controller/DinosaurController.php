<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dinosaur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DinosaurController extends Controller
{
    /**
     * @Route("/", name="dinosaur_list")
     */
    public function indexAction($isLinux)
    {
        $dinos = $this->getDoctrine()
            ->getRepository('AppBundle:Dinosaur')
            ->findAll();

        /*
        $request = new Request();
        $request->attributes->set(
            '_controller',
            'AppBundle:Dinosaur:_latestTweets'
        );
        $httpKernel = $this->container->get('http_kernel');
        $response = $httpKernel->hande(
            $request,
            HttpKernelInterface::SUB_REQUEST
        );
        */

        return $this->render('dinosaurs/index.html.twig', [
            'dinos' => $dinos,
            'isMac' => $isLinux
        ]);
    }

    /**
     * @Route("/dinosaurs/{id}", name="dinosaur_show")
     */
    public function showAction($id, Request $request, $foo = 'optional')
    {
        $dino = $this->getDoctrine()
            ->getRepository('AppBundle:Dinosaur')
            ->find($id);

        if (!$dino) {
            throw $this->createNotFoundException('That dino is extinct!');
        }

        return $this->render('dinosaurs/show.html.twig', [
            'dino' => $dino,
        ]);
    }

    public function _latestTweetsAction($userOnLinux)
    {
        $tweets = [
            'Dino Dino Dino',
            'Eating lollipops..',
            'Rock climbing...'
        ];

        return $this->render('dinosaurs/_latestTweets.html.twig', [
            'tweets' => $tweets,
            'isLinux' => $userOnLinux,
        ]);
    }
}
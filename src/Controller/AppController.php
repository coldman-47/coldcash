<?php

namespace App\Controller;

use Hhxsv5\SSE\SSE;
use Hhxsv5\SSE\Event;
use Hhxsv5\SSE\StopSSEException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    /**
     * @Route("/app", name="app")
     */

    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    /**
     * @Route(
     *  "/api/test",
     *  name="test",
     *  methods={"get"}
     * )
     */
    public function getNewsStream()
    {
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        // $response->headers->set('X-Accel-Buffering', 'no'); // Nginx: unbuffered responses suitable for Comet and HTTP streaming applications
        $response->setCallback(function () {
            $callback = function () {
                $id = mt_rand(1, 1000);
                $news = [['id' => $id, 'title' => 'title ' . $id, 'content' => 'content ' . $id]]; // Get news from database or service.
                if (empty($news)) {
                    return false; // Return false if no new messages
                }
                $shouldStop = false; // Stop if something happens or to clear connection, browser will retry
                if ($shouldStop) {
                    throw new StopSSEException();
                }
                return json_encode(compact('news'));
                // return ['event' => 'ping', 'data' => 'ping data']; // Custom event temporarily: send ping event
                // return ['id' => uniqid(), 'data' => json_encode(compact('news'))]; // Custom event Id
            };
            (new SSE(new Event($callback, 'news')))->start();
        });
        dump($response);
        return $response;
    }
}

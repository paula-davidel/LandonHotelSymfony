<?php
// src/Controller/ReservationsController.php
namespace App\Controller;

use App\Entity\Client;
use App\Entity\Room;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationsController extends AbstractController
{
    /**
     * @Route("/reservations", name="reservations")
     */
    public function showIndex()
    {
//        $routeName= $_SERVER["BASE"];
//        return $this->render("reservations/index.html.twig",
//            [
//                "base_url" => $routeName
//            ]);
        $reservations = $this->getDoctrine()->getManager()->getRepository(Reservation::class)
                        ->findAll();

        foreach ($reservations as $reservation)
        {
            $client_id = $reservation->getClientId();
            $room_id = $reservation->getRoomId();

            $client_name = $this->getDoctrine()->getManager()->getRepository(Client::class)->find(["id" => $client_id]);
            $room_name = $this->getDoctrine()->getManager()->getRepository(Room::class)->find(["id" => $room_id]);

            $data["info"][] =  array(
                            "client_name" => $client_name->getName(). " " . $client_name->getLastName(),
                            "room_name"   => $room_name->getName(),
                            "date_in"     => $reservation->getDateIn(),
                            "date_out"    => $reservation->getDateOut()
            );
        }

        return $this->render("reservations/index.html.twig",$data);

    }

     /**
     * @Route("/reservation/{id_client}", name="booking")
     */
     public function book(Request $request, $id_client)
     {
         $data = [];
         $data['id_client'] = $id_client;


         $data['rooms'] = null;
         $data['dates']['from'] = '';
         $data['dates']['to'] = '';
         $form = $this->createFormBuilder()
             ->add('dateFrom')
             ->add('dateTo')
             ->getForm();

         $form->handleRequest($request);

         if ($form->isSubmitted()) {
             $form_data = $form->getData();

             $data['dates']['from'] = $form_data['dateFrom'];
             $data['dates']['to'] = $form_data['dateTo'];

             $em = $this->getDoctrine()->getManager();
             $rooms = $em->getRepository(Room::class)
                 ->getAvailableRooms($form_data['dateFrom'], $form_data['dateTo']);
//             $rooms = $em->getRepository(Room::class)
//                    ->findAll();

             $data['rooms'] = $rooms;
         }

         $client = $this
             ->getDoctrine()
             ->getRepository(Client::class)
             ->find($id_client);

         $data['client'] = $client;

         return $this->render("reservations/book.html.twig", $data);
     }


    /**
     * @Route("/book_room/{id_client}/{id_room}/{date_in}/{date_out}", name="book_room")
     **/
    public function bookRoom($id_client, $id_room, $date_in, $date_out)
    {

        $reservation = new Reservation();
        $reservation->setDateIn(new \DateTime($date_in));
        $reservation->setDateOut(new \DateTime($date_out));

        $em = $this->getDoctrine()->getManager();

        $reservation->setClientId($id_client);
        $reservation->setRoomId($id_room);

        $em->persist($reservation);
        $em->flush();

        return $this->redirectToRoute("clients");
    }

}
<?php

namespace App\Controller;

use App\Entity\ReservatieTafel;
use App\Entity\Reservatie;
use App\Form\ReservatieTafelType;
use App\Repository\ReservatieTafelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/reservatie_tafel")
 */
class ReservatieTafelController extends AbstractController
{

    /**
     * @Route("/reserveren", name="reserveren")
     */
    public function index2(Request $request, \Swift_Mailer $mailer): Response
    {

        $form = $this->createFormBuilder()
            ->add('datumtijd', DateTimeType::class, [
                'data' => new \DateTime("now"),
                'input' => 'datetime',
                'widget' => 'choice',
                'minutes' => [0, 15, 30, 45],
                'hours' => [17, 18, 19, 20, 21],
            ])
            ->add('aantalpersonen', IntegerType::class, [
                'data' => 2
            ])
            ->add('reserveren', SubmitType::class, array('label' => 'Reserveren'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // haal data uit het form op en zet ze vervolgens in variabelen
            $reserveerinfo = $form->getData();
            #dump($reserveerinfo);

            $input_datumtijd = ($reserveerinfo['datumtijd']);
            $input_aantalpersonen = $reserveerinfo['aantalpersonen'];


            $em = $this->getDoctrine()->getManager();

            //haal de reserveringen van de ingevoerde dag op functie staat in ReservatieRepository
            $reserveringen = $em->getRepository('App:Reservatie')->findreserveringendag($input_datumtijd);



            #dump($reserveringen); //ARRAY

            // haal voor iedere reservering van de dag de tafelid(s) op en vul array
            $reserveringids = [];
            foreach ($reserveringen as $reservering) {
                //dump($reservering); //value
                // zoek voor iedere reservering de bijbehorende tussentabel, functie staat in ReservatieTafelRepository
                $tussentabelres = $em->getRepository('App:ReservatieTafel')->findrestafelids($reservering);


                // bepaal voor iedere tussentabel het bijbehorende ID van de tafel(s)
                foreach ($tussentabelres as $tussentabel) {
                    $tafelids = $tussentabel->getTafelId()->getId();
                    // voeg het gevonden tafel id toe aan het array dat de gereserveerde tafelds heeft
                    array_push($reserveringids, $tafelids);
                }
            }
            // dump($reserveringids);

            // om achter de vrije tafels te komen moeten we alle kamers op zoeken en daar de gereserveerde in weghalen

            //haal alle tafels op
            $tafels = $em->getRepository('App:Tafel')->findAll();

            // alle gereserveerde tafels staan in $reserveringids en die halen we uit het array met alle tafels
            foreach ($tafels as $key => $tafel) {
                foreach ($reserveringids as $resid) {
                    if ($tafel->getId() == $resid) {
                        // verwijder de bezette tafel.
                        unset($tafels[$key]);
                    }
                }
            }
            //dump($tafels);

            // kijk of er voldoende plaats is door voor alle niet gereserveerde kamers tde plaatsen te tellen
            $aantalplaatsenvrij = 0;
            foreach ($tafels as $key => $tafel) {
                $aantalplaatsenvrij=$aantalplaatsenvrij+$tafel->getPersonen();
            }
            //dump($aantalplaatsenvrij);

            if ($aantalplaatsenvrij < $input_aantalpersonen) {
                $this->addFlash(
                    'notice',
                    'Helaas zitten wij deze dag al vol voor dit aantal personen. Wij hebben voor die dag nog ' . $aantalplaatsenvrij . ' plaatsen vrij'
                );
                return $this->redirectToRoute('reserveren');

            } else {

                $reservatie = new Reservatie();
                $reservatie->setUserId($this->getUser());
                $reservatie->setMedewerkerId($this->getUser());
                $reservatie->setAantal($input_aantalpersonen);
                $reservatie->setDatumTijd($input_datumtijd);
                $em->persist($reservatie);

                $reservatieTafel = new ReservatieTafel();
                $reservatieTafel->setReservatieId($reservatie);
                // zoek de eerste vrije tafel in het array array_shift zoekt de eerste en verwijdert hem ook uit het array
                $reservatieTafel->setTafelId(array_shift($tafels));
                $em->persist($reservatieTafel);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Wij hebben voor u gereserveerd'
                );

                // stuur een email naar de klant de persoon die de reservering maakt en ook 1 naar je eigen restaurant zodat je weet dat iemand gereserveerd heeft
                // als een medewerker dus zelf een reservering maakt krijg je 2 mails

                //haal het email adres van de ingelogde persoon op
                $emailreserveerder = $this->getUser()->getEmail();
                #dump($email);
                #exit();


                $message = (new \Swift_Message('Reservering Excellent Taste'))
                    ->setFrom('lucatester12@gmail.com')
                    ->setTo($emailreserveerder)
                    ->setBody(
                        $this->renderView(
                        // templates/reservatie_tafel/reservatie.txt.twig
                            'emails/reservatie.txt.twig',
                            ['variabele1' => $input_datumtijd, 'variabele2' => $input_aantalpersonen]
                        )
                    );

                $mailer->send($message);

            }
            //exit();


        }

        return $this->render('reserveren/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/", name="reservatie_tafel_index", methods={"GET"})
     */
    public function index(ReservatieTafelRepository $reservatieTafelRepository): Response
    {

        return $this->render('reservatie_tafel/index.html.twig', [
            'reservatie_tafels' => $reservatieTafelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reservatie_tafel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservatieTafel = new ReservatieTafel();
        $form = $this->createForm(ReservatieTafelType::class, $reservatieTafel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservatieTafel);
            $entityManager->flush();

            return $this->redirectToRoute('reservatie_tafel_index');
        }

        return $this->render('reservatie_tafel/new.html.twig', [
            'reservatie_tafel' => $reservatieTafel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservatie_tafel_show", methods={"GET"})
     */
    public function show(ReservatieTafel $reservatieTafel): Response
    {
        return $this->render('reservatie_tafel/show.html.twig', [
            'reservatie_tafel' => $reservatieTafel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservatie_tafel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReservatieTafel $reservatieTafel): Response
    {
        $form = $this->createForm(ReservatieTafelType::class, $reservatieTafel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservatie_tafel_index');
        }

        return $this->render('reservatie_tafel/edit.html.twig', [
            'reservatie_tafel' => $reservatieTafel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservatie_tafel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ReservatieTafel $reservatieTafel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservatieTafel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservatieTafel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservatie_tafel_index');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index2(Request $request, \Swift_Mailer $mailer): Response
    {

        $form = $this->createFormBuilder()
            ->add('naam', TextType::class)
            ->add('achternaam', TextType::class)
            ->add('email', EmailType::class)
            ->add('adres', TextType::class)
            ->add('huisnummer', TextType::class)
            ->add('postcode', TextType::class)
            ->add('plaats', TextType::class)
            ->add('telefoonnummer', TextType::class)
            ->add('commentaar', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // haal data uit het form op
            $contactinfo = $form->getData();

            $input_naam = $contactinfo['naam'];
            $input_achternaam = $contactinfo['achternaam'];
            $input_email = $contactinfo['email'];
            $input_adres = $contactinfo['adres'];
            $input_huisnummer = $contactinfo['huisnummer'];
            $input_postcode = $contactinfo['postcode'];
            $input_plaats = $contactinfo['plaats'];
            $input_telefoonnummer = $contactinfo['telefoonnummer'];
            $input_commentaar = $contactinfo['commentaar'];


            $message = (new \Swift_Message('EL Mundo'))
                ->setFrom($input_email)
                ->setTo('giovannivr@live.com')
                ->setBody(
                    $this->renderView(
                    // templates/contact/reservatie.txt.twig
                        'contact/email.txt.twig',
                        ['variabele1' => $input_naam, 'variabele2' => $input_achternaam, 'variabele3' => $input_adres, 'variabele4' => $input_huisnummer,
                            'variabele5' => $input_postcode, 'variabele6' => $input_plaats, 'variabele7' => $input_telefoonnummer, 'variabele8' => $input_commentaar]
                    )
                );

            $mailer->send($message);

            return $this->redirectToRoute('homepage');


        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}

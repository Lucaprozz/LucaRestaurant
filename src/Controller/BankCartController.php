<?php

namespace App\Controller;

use App\Entity\BankCart;
use App\Form\BankCartType;
use App\Repository\BankCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bank_cart")
 */
class BankCartController extends AbstractController
{
    /**
     * @Route("/", name="bank_cart_index", methods={"GET"})
     */
    public function index(BankCartRepository $bankCartRepository): Response
    {
        return $this->render('bank_cart/index.html.twig', [
            'bank_carts' => $bankCartRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bank_cart_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bankCart = new BankCart();
        $form = $this->createForm(BankCartType::class, $bankCart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bankCart);
            $entityManager->flush();

            return $this->redirectToRoute('bank_cart_index');
        }

        return $this->render('bank_cart/new.html.twig', [
            'bank_cart' => $bankCart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bank_cart_show", methods={"GET"})
     */
    public function show(BankCart $bankCart): Response
    {
        return $this->render('bank_cart/show.html.twig', [
            'bank_cart' => $bankCart,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bank_cart_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BankCart $bankCart): Response
    {
        $form = $this->createForm(BankCartType::class, $bankCart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bank_cart_index');
        }

        return $this->render('bank_cart/edit.html.twig', [
            'bank_cart' => $bankCart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bank_cart_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BankCart $bankCart): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bankCart->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bankCart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bank_cart_index');
    }
}

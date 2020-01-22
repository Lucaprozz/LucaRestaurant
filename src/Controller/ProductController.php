<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // lees de sessie parameter uit met 'Cart' 'Cart' bevat de bestelede items met aantal , eerste keer leeg
        $cart = $this->session->get('Cart', []);

        $alleproductenquery = $productRepository->findAll();

        // Paginate the results of the query
        $pagproducts = $paginator->paginate(
        // Doctrine Query, not results
            $alleproductenquery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        return $this->render('product/index.html.twig', [
            'products' => $pagproducts,
            'cart' => $cart,
        ]);
    }

    // Route om alleen de producten te laten zeen van de aangeklikte category
    // In de twig file
    /**
     * @Route("index/{id}", name="product_index_categorie", methods={"GET"})
     */
    public function indexuser(ProductRepository $productRepository, CategorieRepository $categorieRepository, $id, Request $request, PaginatorInterface $paginator): Response
    {

        // lees de sessie parameter uit met 'Cart' 'Cart' bevat de bestelede items met aantal , eerste keer leeg
        $cart = $this->session->get('Cart', []);
        $em = $this->getDoctrine()->getManager();
        $allerelevanteproducten = $productRepository->findBy(array('categorie_id' => $id)); // haal alle product records op is niet juist alleen de producten met categorie id


        // Paginate the results of the query
        $pagproducts = $paginator->paginate(
        // Doctrine Query, not results
            $allerelevanteproducten,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        return $this->render('product/index.html.twig', [
            'products' => $pagproducts,
            'cart' => $cart,
        ]);
    }
    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/{id}/add", name="product_add", methods={"GET","POST"})
     */
    public function add(Product $product, ProductRepository $productRepository): Response
    {
        $cart = $this->session->get('Cart');

        // als het roduct ID al in de cart staat dan verhoog aantal met 1, anders is anders maak product ID aan in kaart met aantal 1
        $id = $product->getId();
        if(isset($cart[$id])) {
            $cart[$id]['Aantal']++;
        } else {
            $cart[$id]['Aantal'] = 1;
        }

        $this->session->set('Cart', $cart);

        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/{id}/remove", name="product_remove", methods={"GET","POST"})
     */
    public function remove(Product $product, ProductRepository $productRepository): Response
    {
        // deze functie haalt 1 van het aantal af en als het aantal kleiner of gelijk aan 1 is haalt hij hem helemaal weg
        $cart = $this->session->get('Cart');
        $id = $product->getId();
        if(isset($cart[$id])) {
            $cart[$id]['Aantal']--;
            if($cart[$id]['Aantal'] <=1){
                unset($cart[$id]);
            }
        }

        $this->session->set('Cart', $cart);

        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/{id}/del", name="product_del", methods={"GET","POST"})
     */
    public function del(Product $product, ProductRepository $productRepository): Response
    {
        // haal de cart op
        $cart = $this->session->get('Cart');
        // zoek het ID van het product
        $id = $product->getId();

        // verwijder het product ID uit de cart als hij er in staat
        if(isset($cart[$id])) {
            unset($cart[$id]);
        }

        // schrijf de nieuwe cart weg in de sessie onder 'Cart'
        $this->session->set('Cart', $cart);

        // laat de nieuwe bestellijst zien
        return $this->redirectToRoute("cart");
    }
}

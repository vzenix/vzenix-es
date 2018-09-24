<?php
// src/App/Controller/DemoController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use VZenix\Bundle\BlogBundle\Entity\Post;

class MainController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('general/index.html.twig', array('main_class' => 'home'));
    }

    /**
     * @Route("/acerca-de")
     */
    public function aboutAction()
    {
        return $this->render('general/about.html.twig', array('main_class' => 'about', 'title' => 'VZenix, Condiciones de uso'));
    }

    /**
     * @Route("/proyectos")
     */
    public function proyectosAction()
    {
        return $this->render('general/proyectos.html.twig', array('main_class' => 'proyectos', 'title' => 'VZenix, Proyectos'));
    }

    /**
     * Sitemap View
     * @Route("/sitemap")
     */
    public function sitemapAction()
    {
        $request = Request::createFromGlobals();
        $xml = new \SimpleXMLElement('<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>', LIBXML_NOERROR);

        $entries = $this
            ->getDoctrine()
            ->getRepository(Post::class)
            ->findBy(array(), array('created' => 'DESC'), 1000, 0);
            $entries = is_array($entries) ? $entries : array();

        $item = $xml->addChild('url');
        $item->addChild('loc', $request->getSchemeAndHttpHost());
        $item->addChild('lastmod', (new \DateTime('2018-09-18'))->format("Y-m-d"));

        $item = $xml->addChild('url');
        $item->addChild('loc', $request->getSchemeAndHttpHost() . '/acerca-de');
        $item->addChild('lastmod', (new \DateTime('2018-09-18'))->format("Y-m-d"));

        $item = $xml->addChild('url');
        $item->addChild('loc', $request->getSchemeAndHttpHost() . '/proyectos');
        $item->addChild('lastmod', (new \DateTime('2018-09-18'))->format("Y-m-d"));

        $item = $xml->addChild('url');
        $item->addChild('loc', $request->getSchemeAndHttpHost() . '/blog');
        $item->addChild('lastmod', current($entries)->getCreated()->format("Y-m-d"));
       
        foreach ($entries AS $entry) {
            $item = $xml->addChild('url');
            $item->addChild('loc', $this->generateUrl('blog_show', array('slug' => $entry->getFriendly())));
            $item->addChild('lastmod', $entry->getCreated()->format("Y-m-d"));
        }

        $response = new Response($xml->asXML());
        $response->headers->set('Content-Type', 'application/xml; charset=utf-8');
        return $response;
    }
}

<?php
namespace VZenix\Bundle\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use VZenix\Bundle\BlogBundle\Entity\Post;

/**
 * controller
 * @author Francisco Muros Espadas <paco@vzenix.es>
 */
class EntriesController extends AbstractController
{

    /**
     * @var \VZenix\Bundle\BlogBundle\Repository\PostRepository
     */
    private $repositoryPost;

    /**
     * HTML View
     */
    public function listAction($page = 1)
    {
        $this->repositoryPost = $this
            ->getDoctrine()
            ->getRepository(Post::class);

        $request = Request::createFromGlobals();
        $query = $request->query->get('q');

        $limit = 4;
        $offset = $limit * ($page - 1);
        $entries = is_string($query) && trim($query) != "" ?
            $this->repositoryPost->findByField(trim($query), $limit, $offset) :
            $this->repositoryPost->findBy(array(), array('created' => 'DESC'), $limit, $offset);

        $total = is_string($query) && trim($query) != "" ?
            $this->repositoryPost->countByField(trim($query)) :
            $this->repositoryPost->countBy();

        $pageTotal = $total > 0 ? $total / $limit : 1;
        if (floor($pageTotal) != $pageTotal) {
            $pageTotal = floor($pageTotal);
            $pageTotal++;
        }

        // ROLE_BLOG
        return $this->render('blog/entries.html.twig', array(
            'role_manage' => $this->get('security.authorization_checker')->isGranted('ROLE_BLOG'),
            'entries' => is_array($entries) ? $entries : array(),
            'total' => (int) $total,
            'pagination' => array(
                'current' => $page,
                'total' => $pageTotal,
                'url_prev' => $page > 1 ? $this->generateUrl('blog_list_page', array('page' => (int) ($page - 1))) : null,
                'url_next' => $page < $pageTotal ? $this->generateUrl('blog_list_page', array('page' => (int) ($page + 1))) : null
            ),
        ));
    }

    /**
     * RSS View
     */
    public function rssAction($page = 1)
    {
        $this->repositoryPost = $this
            ->getDoctrine()
            ->getRepository(Post::class);

        $limit = 10;
        $offset = $limit * ($page - 1);
        $entries = $this->repositoryPost->findBy(array(), array('created' => 'DESC'), $limit, $offset);
        $total = $this->repositoryPost->countBy();
        $pageTotal = $total > 0 ? $total / $limit : 1;
        if (floor($pageTotal) != $pageTotal) {
            $pageTotal = floor($pageTotal);
            $pageTotal++;
        }

        $xml = new \SimpleXMLElement('<rss></rss>', LIBXML_NOERROR);
        $xml->addAttribute('version', '2.0');

        $xmlChanel = $xml->addChild('channel');
        $xmlChanel->addChild('title', 'Blog VZenix');
        $xmlChanel->addChild('description', 'RSS para seguir las entradas en el blog');
        $xmlChanel->addChild('link', 'https://vzenix.es/blog');

        $entries = is_array($entries) ? $entries : array();
        foreach ($entries AS $entry) {
            $item = $xmlChanel->addChild('item');
            $item->addChild('title', $entry->getTitle());
            $item->addChild('description', $entry->getTitle());
            $item->addChild('link', $this->generateUrl('blog_show', array('slug' => $entry->getFriendly())));
            $item->addChild('guid', \base64_encode($entry->getFriendly()));
            $item->addChild('pubDate', $entry->getCreated()->format(\DateTime::RFC2822));
        }

        $response = new Response($xml->asXML());
        return $response;
    }
}

<?php
namespace VZenix\Bundle\BlogBundle\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use VZenix\Bundle\BlogBundle\Entity\Post;

/**
 * controller
 * @author Francisco Muros Espadas <paco@vzenix.es>
 */
class EntryController extends AbstractController
{
    /**
     * @var \VZenix\Bundle\BlogBundle\Repository\PostRepository
     */
    private $repositoryPost;

    public function showAction($slug)
    {
        $this->repositoryPost = $this
            ->getDoctrine()
            ->getRepository(Post::class);

        $entry = $this->repositoryPost->findBy(array('friendly' => $slug), array(), 1, 0);
        if (\is_array($entry)) {
            $entry = \current($entry);
        }

        if (!$entry instanceof Post) {
            return $this->render('blog/entry-no-found.html.twig', array(
                'role_manage' => $this->get('security.authorization_checker')->isGranted('ROLE_BLOG')
            ));
        }

        // ROLE_BLOG
        return $this->render('blog/entry.html.twig', array(
            'role_manage' => $this->get('security.authorization_checker')->isGranted('ROLE_BLOG'),
            'entry' => $entry
        ));
    }

    public function createAction()
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG');
        $em = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        $em->persist($product);
        $em->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    public function editAction()
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG');
        $number = random_int(0, 100);
        return new Response(
            '<html><body>Lucky number (EntryController editAction :: ' . $slug . '): '.$number.'</body></html>'
        );
    }

    public function deleteAction()
    {
        $this->denyAccessUnlessGranted('ROLE_BLOG');
        $number = random_int(0, 100);
        return new Response(
            '<html><body>Lucky number (EntryController deleteAction :: ' . $slug . '): '.$number.'</body></html>'
        );
    }
}

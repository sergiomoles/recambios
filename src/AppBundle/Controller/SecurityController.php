<?php
    namespace AppBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Component\HttpFoundation\Response;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class SecurityController extends Controller
{

    /**
    * @Route("/", name="recambios_route")
    */
    public function recambiosAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );

    }

    /**
    * @Route("/recambios_check", name="recambios_check")
     * @Security("has_role('ROLE_ADMIN')")
    */

    public function recambiosCheckAction()
    {
    // this controller will not be executed,
    // as the route is handled by the Security system

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->find('AppBundle:User', 1);

        return $this->render(
            'security/portada.html.twig',
            array('usuario' => $usuario )
        );
    }

}
<?php 
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

/**
 * Clase utilizada para testeo. Añado en la base de datos de test (test_modo) el usuario root. 
 * @author XGS
 *
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    private $data = [
        'ROLE_ADMIN' => [
            'username' => 'root',
            'email' => 'root@root.com',
            'plainPassword' => 'root'
        ]
    ];

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        foreach ($this->data as $role => $attrs) {
            $user = $userManager->createUser();
            foreach ($attrs as $attr => $val) {
                $function = 'set'. ucwords($attr);
                $user->$function($val);
                $user->setEnabled(true);
            }
            $user->setRoles(['ROLE_ADMIN', $role]);
            $userManager->updateUser($user, true);
        }
    }
}
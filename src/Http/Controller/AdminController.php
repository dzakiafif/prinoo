<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 15:54
 */

namespace Komal\prinoo\Http\Controller;


use Komal\prinoo\Domain\Entity\User;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminController implements ControllerProviderInterface
{

    private $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/list-user',[$this,'listUserAction']);

        $controllers->get('/delete-user/{id}',[$this,'deleteUserAction']);

        $controllers->match('/update-user/{id}',[$this,'editUserAction']);

        return $controllers;
        // TODO: Implement connect() method.
    }

    public function listUserAction()
    {
        $dataUser = $this->app['user.repository']->findAll();

        if($dataUser != null){
            echo 'SUKSES';
        }else {
            echo 'GAGAL';
        }

        return $this->app['twig']->render('list-user.twig');
    }
    public function deleteUserAction(Request $request)
    {
        $user = $this->app['user.repository']->findById($request->get('id'));

        $this->app['orm.em']->remove($user);
        $this->app['orm.em']->flush();

        return 'data berhasil dihapus';
    }

    public function editUserAction(Request $request)
    {
        $userInfo = $this->app['user.repository']->findById($request->get('id'));

        if($request->getMethod() === 'GET'){
            return $this->app['twig']->render('update-user.twig',['data'=>$userInfo]);
        }
        
        if($request->getMethod() === 'POST'){
            $kampret = $this->app['orm.em']->getRepository('Komal\prinoo\Domain\Entity\User')->findById($request->get('id'));
            if($kampret instanceof User){
                $kampret->setId($request->get('id'));
                $kampret->setEmail($request->get('email'));
                $kampret->setFirstName($request->get('first-name'));
                $kampret->setLastName($request->get('last-name'));
                $kampret->setNoHp($request->get('no-hp'));
                $kampret->setJenisKelamin($request->get('jenis-kelamin'));
                $kampret->setAlamat($request->get('alamat'));
                $kampret->setPassword($request->get('password'));
                $kampret->setCreatedAt(new \DateTime());
                $kampret->setUpdatedAt(new \DateTime());
            }

            $this->app['orm.em']->flush();
            
            return 'Data berhasil di Update';
        }
    }
}
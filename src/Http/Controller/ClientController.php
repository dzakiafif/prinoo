<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 15:53
 */

namespace Komal\prinoo\Http\Controller;


use Komal\prinoo\Domain\Entity\User;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class ClientController implements ControllerProviderInterface
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

        $controllers->get('/createRaw',[$this,'createRawAction']);

        $controllers->match('/registration-client',[$this,'registrationClientAction'])->bind('registration');

        $controllers->match('/login',[$this,'loginAction'])->bind('login');

        return $controllers;
    }

    public function createRawAction()
    {
        $user = User::create('dzakiafif12@gmail.com','afif','082245655117','menara34','L','jl.sunan ampel');

        $this->app['orm.em']->persist($user);
        $this->app['orm.em']->flush();

        return 'OK';
    }

    public function registrationClientAction(Request $request)
    {
        $email = $request->get('email');
        $firstName = $request->get('first-name');
        $lastName = $request->get('last-name');
        $noHp = $request->get('no-hp');
        $jenisKelamin = $request->get('jenis-kelamin');
        $alamat = $request->get('alamat');
        $password = $request->get('password');

        if($request->getMethod() == 'GET'){
            return $this->app['twig']->render('register.twig');
        }

        $info = User::create($email,$firstName,$lastName,$noHp,$jenisKelamin,$alamat,$password);

        $this->app['orm.em']->persist($info);
        $this->app['orm.em']->flush();

        return 'OK';

    }

    public function loginAction(Request $request)
    {
        if($request->getMethod()=='POST'){
            $email = $request->get('email');
            $pass = md5($request->get('password'));
            $data = $this->app['user.repository']->findByEmail($email);
//            $userList = $this->app['user.repository']->findAll();

            if($data != null){
                if($pass == $data->getPassword()){
                    return 'SUKSES';
                }else{
                    return 'GAGAL';
                }
            }else{
                return 'EMAIL TIDAK COCOK';
            }
        }

        return $this->app['twig']->render('login.twig');
    }
}
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

        $controllers->match('/reset-password',[$this,'resetPasswordAction']);

        $controllers->match('/reset/{token}',[$this,'clientResetAction']);

        $controllers->get('/home',[$this,'homeClientAction'])->bind('home');

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

            if($data != null){
                if($pass == $data->getPassword()){
                    return $this->app->redirect('/home');
                }else{
                    return $this->app->redirect('/login');
                }
            }else{
                return 'EMAIL TIDAK COCOK';
            }
        }

        return $this->app['twig']->render('login.twig');
    }

    public function resetPasswordAction(Request $request)
    {
        if($request->getMethod() == 'POST')
        {
            $user = $this->app['user.repository']->findByEmail($request->get('email'));

            $token = $user->getToken();

            if($user != null){
                $transport = \Swift_SmtpTransport::newInstance(
                    'smtp.gmail.com',587,'tls')
                    ->setUsername('dzakiafif12@gmail.com')
                    ->setPassword('dzakiafif');

                $message = \Swift_Message::newInstance();
                $message->setSubject('Reset Password');
                $message->setFrom(['noreply@prinoo.com']);
                $message->setTo([$request->get('email')]);
                $message->setBody(
                    $this->app['twig']->render('reset-tmp.twig',['token'=>$token,'host'=>$request->getHost()]),'text/html'
                );

                $mailer = \Swift_Mailer::newInstance($transport);
                $mailer->send($message);

                return 'OK';
            }else{
                return 'cek email apakah sudah benar apa tidak';
            }
        }
        return $this->app['twig']->render('reset-password.twig');
    }

    public function clientResetAction(Request $request)
    {
        $data = $this->app['user.repository']->findByToken($request->get('token'));

        if($data != null){
            if($request->getMethod() == 'POST'){
                $data->setPassword($request->get('password'));

                $this->app['orm.em']->flush();

                $this->app['session']->getFlashBag()->add('message_success','Password telah berhasil diganti');

                return $this->app->redirect($this->app['url_generator']->generate('login'));
            }
        }else{
            return 'token tidak valid';
        }

        return $this->app['twig']->render('new-password.twig');

    }

    public function homeClientAction()
    {
        return 'ini home client';
    }
}
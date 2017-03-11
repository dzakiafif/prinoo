<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 15:53
 */

namespace Komal\prinoo\Http\Controller;


use Komal\prinoo\Domain\Entity\Order;
use Komal\prinoo\Domain\Entity\User;
use Komal\prinoo\Domain\Services\UserPasswordMatcher;
use Komal\prinoo\Http\Form\LoginForm;
use Komal\prinoo\Http\Form\RegistrationForm;
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

        $controllers->match('/create-order',[$this,'createOrderAction']);

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
        $registration = new RegistrationForm();
        $formBuilder = $this->app['form.factory']->create($registration,$registration);

        if($request->getMethod() == 'GET'){
            return $this->app['twig']->render('register.twig',['form'=>$formBuilder->createView()]);
        }

        $formBuilder->handleRequest($request);

        if(!$formBuilder->isValid()){
            return $this->app['twig']->render('register.twig',['form'=>$formBuilder->createView()]);
        }
        
//        $files = $registration->getUserProperty();
//        $fileName = md5(uniqid()). '.' . $files->guessExtension();

        $user = User::create($registration->getEmail(),$registration->getFirstName(),$registration->getLastName(),$registration->getNoHp(),$registration->getJenisKelamin(),$registration->getAlamat(),$registration->getPassword());

        $this->app['orm.em']->persist($user);
        $this->app['orm.em']->flush();

//        $dirName = $this->app['foto.path'] . '/user/' . $user->getId();
//
//       if(is_dir($dirName)== false){
//           mkdir($dirName,0755);
//       }
//        $files->move($dirName, $fileName . '.' . $files->guessExtension());

        return 'OK';

    }

    public function loginAction(Request $request)
    {
//        $login = new LoginForm();
//        $formBuilder = $this->app['form.factory']->create($login,$login);
//
//        if($request->getMethod()=='GET')
//        {
//            return $this->app['twig']->render('login.twig',['form'=>$formBuilder->createView()]);
//        }
//
//        $formBuilder->handleRequest($request);
//
//        $data = $this->app['user.repository']->findByemail($login->getEmail());
//
//        if($data == null){
//            $this->app['session']->getFlashBag('
//            message_error','email incorrect'
//            );
//            return $this->app['twig']->render('login.twig',['form'=>$formBuilder->createView()]);
//        }
//
//        if(!(new UserPasswordMatcher($login->getPassword(),$data))->match())
//        {
//            $this->app['session']->getFlashbag(
//                'message_error','email or password not match given'
//            );
//            return $this->app['twig']->render('login.twig',['form'=>$formBuilder->createView()]);
//        }
//
////        $this->app['session']->set('role',['value'=>$data->getRole()]);
////        $this->app['session']->set('email',['value'=>$data->getEmail()]);
////        $role = $request->get('role');
//
//        if($request->getMethod() == 'POST'){
//            if($data != null){
//                if($login->getPassword() == $data->getPassword()){
//                    return $this->app->redirect('/home');
//
//                }
//            }
//        }
        if($request->getMethod()=='POST'){
            $email = $request->get('email');
            $pass = md5($request->get('password'));
            $data = $this->app['user.repository']->findByEmail($email);

            if($data != null){
                if($pass == $data->getPassword()){
                    return $this->app->redirect('/home');
//                    return 'ok';
                }else{
//                    return 'gagal';
                    return $this->app->redirect('/login');
                }
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

    public function createOrderAction(Request $request)
    {
        if($request->getMethod() == 'POST')
        {
            $namaProduk = $request->get('nama-produk');
            $userId = $request->get('user-id');
            $jenisProduk = $request->get('jenis-produk');
            $bahan = $request->get('bahan');
            $ukuranPanjang = $request->get('ukuran-panjang');
            $ukuranLebar = $request->get('ukuran-lebar');
            $jumlahBarang = $request->get('jumlah-barang');
            $kualitas = $request->get('kualitas');
            $orderProperty = $request->files->get('order-property');
            $jumlahHarga = $request->get('jumlah-harga');

            $filename = md5(uniqid()) . '.' . $orderProperty->guessExtension();

            $data = Order::create($namaProduk,$userId,$jenisProduk,$bahan,$ukuranPanjang,$ukuranLebar,$jumlahBarang,$kualitas,$orderProperty,$jumlahHarga);

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            $dirName = $this->app['foto.path'] . '/order/' . $data->getId();

            if(is_dir($dirName)== false){
                mkdir($dirName,0755);
            }

            $orderProperty->move($dirName,$filename. '.' . $orderProperty->guessExtension());

            return 'OK';


        }
    }

    public function homeClientAction()
    {
        return 'ini home client';
    }
}
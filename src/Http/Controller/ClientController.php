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

        $controllers->match('/', [$this, 'landingPageAction'])
            ->bind('landing_page');

        $controllers->match('/registration-client', [$this, 'registrationClientAction'])
            ->bind('registration');

        $controllers->match('/login', [$this, 'loginAction'])
            ->bind('login');

        $controllers->match('/reset-password', [$this, 'resetPasswordAction'])
            ->bind('reset_password');

        $controllers->match('/reset/{token}', [$this, 'clientResetAction'])
            ->bind('reset_with_token');

        $controllers->get('/home', [$this, 'homeClientAction'])
            ->bind('home');

        $controllers->match('/create-order', [$this, 'createOrderAction'])
            ->bind('create_order');

        $controllers->get('/logout', [$this, 'logoutAction'])
            ->bind('logout');

        $controllers->get('/delete-order/{id}', [$this, 'deleteOrderAction'])
            ->bind('delete_order');

        $controllers->get('/list-barang', [$this, 'listBarangAction'])
            ->bind('list_barang');

        $controllers->get('/createDummy', [$this, 'createDummyAction'])
            ->bind('create_dummy');

        return $controllers;
    }

    public function landingPageAction()
    {
        return $this->app['twig']->render('home.twig');
    }

    public function createDummyAction()
    {
        for ($i = 0; $i < 10; $i++) {
            $data = User::createDummy();

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();
        }

        return 'Mari';
    }

    public function registrationClientAction(Request $request)
    {
        $registration = new RegistrationForm();
        $formBuilder = $this->app['form.factory']->create($registration, $registration);

        if ($request->getMethod() == 'GET') {
            return $this->app['twig']->render('register.twig', ['form' => $formBuilder->createView()]);
        }

        $formBuilder->handleRequest($request);

        if (!$formBuilder->isValid()) {
            return $this->app['twig']->render('register.twig', ['form' => $formBuilder->createView()]);
        }

        $user = User::create($registration->getEmail(), $registration->getFirstName(), $registration->getLastName(), $registration->getNoHp(), $registration->getJenisKelamin(), $registration->getAlamat(), $registration->getPassword());

        $this->app['orm.em']->persist($user);
        $this->app['orm.em']->flush();

        return 'OK';

    }

    public function loginAction(Request $request)
    {
        $loginForm = new LoginForm();
        $formBuilder = $this->app['form.factory']->create($loginForm, $loginForm);

        $formBuilder->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            $email = $loginForm->getEmail();
            $pass = md5($loginForm->getPassword());
            $data = $this->app['user.repository']->findByEmail($email);

            if ($data != null) {
                if ($pass == $data->getPassword()) {

                    $this->app['session']->set('email', ['value' => $email]);

                    return $this->app->redirect('/home');
                } else {
                    return $this->app->redirect('/login');
                }
            }
        }

        return $this->app['twig']->render('login.twig', ['form' => $formBuilder->createView()]);
    }

    public function resetPasswordAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $user = $this->app['user.repository']->findByEmail($request->get('email'));

            $token = $user->getToken();

            if ($user != null) {
                $transport = \Swift_SmtpTransport::newInstance(
                    'smtp.gmail.com', 587, 'tls')
                    ->setUsername('dzakiafif12@gmail.com')
                    ->setPassword('dzakiafif');

                $message = \Swift_Message::newInstance();
                $message->setSubject('Reset Password');
                $message->setFrom(['noreply@prinoo.com']);
                $message->setTo([$request->get('email')]);
                $message->setBody(
                    $this->app['twig']->render('reset-tmp.twig', ['token' => $token, 'host' => $request->getHost()]), 'text/html'
                );

                $mailer = \Swift_Mailer::newInstance($transport);
                $mailer->send($message);

                return 'OK';
            } else {
                return 'cek email apakah sudah benar apa tidak';
            }
        }
        return $this->app['twig']->render('reset-password.twig');
    }

    public function clientResetAction(Request $request)
    {
        $data = $this->app['user.repository']->findByToken($request->get('token'));

        if ($data != null) {
            if ($request->getMethod() == 'POST') {
                $data->setPassword($request->get('password'));
                $data->setToken('');

                $this->app['orm.em']->flush();

                $this->app['session']->getFlashBag()->add('message_success', 'Password telah berhasil diganti');

                return $this->app->redirect($this->app['url_generator']->generate('login'));
            }
        } else {
            return 'token tidak valid';
        }

        return $this->app['twig']->render('new-password.twig');

    }

    public function createOrderAction(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $namaProduk = $request->get('nama-produk');
            $bahan = $request->get('bahan');
            $ukuranPanjang = $request->get('ukuran-panjang');
            $ukuranLebar = $request->get('ukuran-lebar');
            $jumlahBarang = $request->get('jumlah-barang');
            $kualitas = $request->get('kualitas');
            $orderProperty = $request->files->get('order-property');
            $jumlahHarga = $request->get('jumlah-harga');

            $filename = md5(uniqid()) . '.' . $orderProperty->guessExtension();

            $data = Order::create($namaProduk, $this->app['session']->findByEmail($request->get('email')['value']), $this->app['barang.repository']->findById($request->get('barang')), $bahan, $ukuranPanjang, $ukuranLebar, $jumlahBarang, $kualitas, $orderProperty, $jumlahHarga);

            $dirName = $this->app['foto.path'] . '/order/' . $data->getId();

            if (is_dir($dirName) == false) {
                mkdir($dirName, 0755);
            }

            $orderProperty->move($dirName, $filename . '.' . $orderProperty->guessExtension());

            $this->app['orm.em']->persist($data);
            $this->app['orm.em']->flush();

            return 'OK';
        }

        return $this->app['twig']->render('order.twig');

    }

    public function deleteOrderAction(Request $request)
    {
        $order = $this->app['order.repository']->findById($request->get('id'));

        $this->app['orm.em']->remove($order);
        $this->app['orm.em']->flush();

        return 'order berhasil di delete';
    }

    public function listBarangAction()
    {
        $dataInfo = $this->app['barang.repository']->findAll();

        return $this->app['twig']->render('list-barang.twig', ['data' => $dataInfo]);
    }

    public function logoutAction()
    {
        $this->app['session']->clear();

        return 'berhasil logout';
    }

    public function homeClientAction()
    {
        return $this->app['twig']->render('dashboard.twig');
    }
}
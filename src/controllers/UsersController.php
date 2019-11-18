<?php

class UsersController extends Controller
{

    public function indexAction(): void
    {
        if ($this->isUserAuth()) {
            header('Location: /articles');
            die;
        }

        if (isset($_REQUEST['empty'])) {
            $empty = true;
        } elseif (isset($_REQUEST['auth-error'])) {
            $auth_error = true;
        }
        require_once "../views/login/index.phtml";
        die;
    }

    public function loginAction(): void
    {
        $request = $this->getRequest();

        $this->checkRequestFields($request, '/?empty=1');

        $auth = (new Users())->authUser(trim($request['login']), trim($request['password']));

        if (!$auth) {
            header('Location: /?auth-error=1');
            die;
        }

        if(isset($request['remember'])) {
            (new Model())->saveSessionId();
        }
        header('Location: /articles');
        die;
    }

    public function showSignFormAction(): void
    {
        if (isset($_REQUEST['empty'])) {
            $empty = true;
        }

        if (isset($_REQUEST['error'])) {
            $create_user_error = true;
        }
        require_once "../views/sign-up/index.phtml";
    }

    public function signUpAction(): void
    {
        $request = $this->getRequest();

        $this->checkRequestFields($request, '/user/sign-up?empty=1');

        $result = (new Users())->createNewUser($request);
        if (!$result) {
            header('Location: /user/sign-up?error=1');
            die;
        }

        header('Location: /');
        die;
    }

    public function logoutAction(): void
    {
        session_destroy();
        header('Location: /');
        die;
    }

}
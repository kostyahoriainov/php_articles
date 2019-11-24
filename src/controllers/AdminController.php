<?php

class AdminController extends Controller
{
    public function indexAction(): void
    {
        $this->checkAuth();
        $this->checkAdminPermission();

        $location = 'admin';
        $user_id = (new Model())->getAuthUserId();
        $users_model = new Users();
        $auth_user = $users_model->getUserById($user_id);

        $all_users = $users_model->all();;

        require_once "../views/admin/users/index.phtml";
    }

    public function addUserBlockAction(): void
    {
        $this->checkAuth();
        $this->checkAdminPermission();

        $user_id = $_REQUEST['user_id'];

        $result = (new Users())->addBlockUser($user_id);

        header('Location: /admin/index');
    }

    public function removeUserBlockAction(): void
    {
        $this->checkAuth();
        $this->checkAdminPermission();

        $user_id = $_REQUEST['user_id'];

        $result = (new Users())->removeBlockUser($user_id);

        header('Location: /admin/index');
    }

    public function addModerateUserAction(): void
    {
        $this->checkAuth();
        $this->checkAdminPermission();

        $user_id = $_REQUEST['user_id'];

        $result = (new Users())->addModerateUser($user_id);

        header('Location: /admin/index');
    }

    public function removeModerateUserAction(): void
    {
        $this->checkAuth();
        $this->checkAdminPermission();

        $user_id = $_REQUEST['user_id'];

        $result = (new Users())->removeModerateUser($user_id);

        header('Location: /admin/index');
    }

    public function removeCommentAction(): bool
    {
        $this->checkAuth();
        $this->checkAdminPermission();

        $comment_id = $_REQUEST['comment-id'];
        $article_id = $_REQUEST['article-id'];

        $result = (new Comments())->remove($comment_id);

        header("Location: /articles/detail?id=$article_id" );
    }

    protected function checkAdminPermission(): void
    {
        $admin_user_id = (new Model())->getAuthUserId();
        $admin_user = (new Users())->getUserById($admin_user_id);

        if (!in_array($admin_user['user_type_id'], UserTypes::ADMINISTRATION)) {
            echo 'PERMISSION DENIED';
            die;
        }
    }
}
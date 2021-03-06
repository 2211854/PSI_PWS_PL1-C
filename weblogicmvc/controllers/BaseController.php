<?php
require_once './models/Auth.php';

class BaseController
{
    protected function renderView($view, array $params = [])
    {
        extract($params);

        $auth = new Auth();

        if($auth->isLoggedIn())
        {
            if($view == 'site/index'){
                $this->redirectToRoute('backoffice','index');
            }
            else{
                require_once './views/layout/header.php';
                require_once './views/' . $view . '.php';
                require_once './views/layout/footer.php';
            }
        }
        elseif($view == 'login/index'){
            require_once './views/layout/headerLogin.php';
            require_once './views/' . $view . '.php';
            require_once './views/layout/footerLogin.php';
        }else{
            require_once './views/layout/headerSite.php';
            require_once './views/' . $view . '.php';
            require_once './views/layout/footerSite.php';
        }


    }

    protected function redirectToRoute($controllerPrefix, $action, $params = []){
        $url = 'Location: ./?c='.$controllerPrefix.'&a='.$action;
        foreach ($params as $paramKey => $paramValue){
            $url.='&'.$paramKey.'='.$paramValue;
        }
        header($url);
    }
}
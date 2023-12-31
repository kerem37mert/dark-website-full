<?php
define('BASE_URL', '/site/');


if(empty($_GET["address"])):
    $_GET["address"] = "home";
endif;

$address = explode("/", mb_strtolower(trim($_GET["address"], "/")));



switch ($address[0]):
    case "home":
        if(isset($address[1])):
            header("location:".BASE_URL."404");
            exit;
        endif;
        require_once "app/controllers/HomeController.php";
        $homeController = new HomeController();
        $homeController->index();
        break;

    case "about":
        if(isset($address[1])):
            header("location:".BASE_URL."404");
            exit;
        endif;
        require_once "app/controllers/AboutController.php";
        $aboutController = new AboutController();
        $aboutController->index();
        break;

    case "contact":
        if(isset($address[1])):
            header("location:".BASE_URL."404");
            exit;
        endif;
        require_once "app/controllers/ContactController.php";
        $contactController = new ContactController();
        $contactController->index();
        break;

    case "contents":
        if(isset($address[1])):
            header("location:".BASE_URL."404");
            exit;
        endif;
        require_once "app/controllers/ContentsController.php";
        $contentsController = new ContentsController();
        $contentsController->index();
        break;

    case "content":
        if(isset($address[2])):
            header("location:".BASE_URL."404");
            exit;
        endif;
        require_once "app/controllers/ContentController.php";
        $contentController = new ContentController();
        $contentController->index($address[1]);
        break;


    //OPERATIONS START
    case "operation":
        //Mesaj Göndeme
        if($address[1] == "sendmessage"):
            require_once "app/controllers/ContactController.php";
            $contactController = new ContactController();
            $status = $contactController->addMessage();
            header("location:".BASE_URL."contact?insert=$status");
            exit;

        //İçerik Arama
        elseif($address[1] == "search"):
            require_once "libs/Controller.php";
            $controller = new Controller();
            $controller->getSearchContents();
        else:
            header("location:".BASE_URL."404");
            exit;
        endif;
        break;
    //OPERATIONS END


    // ADMIN START //
    case "admin":
        require_once "app/controllers/AdminController.php";
        $adminController = new AdminController();

        if($adminController->sessionControl()):
            if(empty($address[1]) || $address[1] == "home"):
                $adminController->home();
            else:
                switch($address[1]):
                    case "logout":
                        $adminController->logout();
                        break;

                    case "newcontent":
                        $adminController->newContent();
                        break;

                    case "settings":
                        $adminController->settings();
                        break;

                    case "content":
                        if(empty($address[2])):
                            header("location:".BASE_URL."404");
                            exit;
                        else:
                            $adminController->content($address[2]);
                        endif;
                        break;

                    case "contents":
                        $adminController->contents();
                        break;

                    case "messages":
                        $adminController->messages();
                        break;

                    case "message":
                        if(empty($address[2])):
                            header("location:".BASE_URL."404");
                            exit;
                        else:
                            $adminController->message($address[2]);
                        endif;
                        break;

                    default:
                        header("location:".BASE_URL."404");
                        exit;
                endswitch;
            endif;
        else:
            $adminController->login();
        endif;
        break;


    case "adminoperation":
        require_once "app/controllers/AdminController.php";
        $adminController = new AdminController();

        switch($address[1]):
            case "logincontrol":
                $adminController->loginControl();
                break;
                
            case "addcontent":
                if($adminController->sessionControl()):
                    $adminController->addContent();
                endif;
                break;

            case "updatesettings":
                if($adminController->sessionControl()):
                    $adminController->updateSettings();
                endif;
                break;

            case "updatecontent":
                if($adminController->sessionControl()):
                    $adminController->updateContent();
                endif;
                break;

            case "updatehighlights":
                if($adminController->sessionControl()):
                    $adminController->updatehighlights();
                endif;
                break;

            case "deletemessage":
                if($adminController->sessionControl()):
                    $adminController->deleteMessage();
                endif;
                break;

            case "deletecontent":
                if($adminController->sessionControl()):
                    $adminController->deleteContent();
                endif;
                break;
        endswitch;
        break;
    // ADMIN END //

    default:
        require_once "app/controllers/PageNotFoundController.php";
        $pageNotFoundController = new PageNotFoundController();
        $pageNotFoundController->index();
endswitch;
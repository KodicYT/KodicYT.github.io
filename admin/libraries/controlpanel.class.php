<?php

require_once "template.class.php";

/**
 * Contains a set of useful methods that helps and simplify the execution of the Control Panel
 */
class ControlPanel {

    private $siteTitle;
    private $siteSubTitle;
    private $siteLogo;
    private $siteTheme;
    private $logged;

    /**
     * Build a new ControlPanel class
     * 
     * @param String $siteTitle    The site main title
     * @param String $siteSubTitle The site subtitle
     * @param String $siteLogo     The site logo URL
     * @param String $siteTheme       The control panel theme
     */
    public function __construct($siteTitle, $siteSubTitle, $siteLogo, $siteTheme)
    {
        $this->siteTitle = $siteTitle;
        $this->siteSubTitle = $siteSubTitle;
        $this->siteLogo = $siteLogo;
        $this->siteTheme = $siteTheme;
        $logged = false;
    }

    /**
     * React to the values of the $dataArray parameter
     *
     * @param array $dataArray The data array being parsed
     * 
     * @return bool True if the redirect was done
     */
    public function tryRedirectFromArray($dataArray)
    {
        if (isset($dataArray['redirect'])) {
            switch ($dataArray['redirect']) {
                case "cart-order": header("Location: cart-order.php?id=" . $dataArray['order_id']); break;
                case "cart-low-stock": header("Location: cart-availability.php"); break;
                case "blog-comment": header("Location: blog.php?category=" . $dataArray['category'] . "&post=" . $dataArray['post']); break;
                case "guestbook-comment": header("Location: guestbook.php?post=" . $dataArray['post']); break;
                case "user": header("Location: privatearea.php"); break;
            }
            exit;
        }
    }

    /**
     * Enter the page if the login is ok, otherwise redirect to the login page
     * 
     * @return Void
     */
    public function accessOrRedirect()
    {
        // Login check
        $this->logged = false;
        $login = Configuration::getPrivateArea();
        // If this is not the login page, let's check if the session is ready
        if ($login->checkAccess("admin/" . basename($_SERVER['PHP_SELF'])) !== 0) {
            $login->savePage();
            if (isset($_SERVER['HTTP_REFERER']) && basename($_SERVER['HTTP_REFERER']) == "login.php") {
                header("Location: login.php?error");
                exit;
            }
            header("Location: login.php");
            exit;
        }
        $this->logged = true;
    }

    /**
     * Try to login to the control panel if the session is already set
     * 
     * @return Void
     */
    public function attemptAutoLogin()
    {
        $login = Configuration::getPrivateArea();
        // If this is the login page, let's do the redirect if the session is already set
        if ($login->checkAccess("admin/index.php") === 0) {
            header("Location: " . ($login->getSavedPage() ? $login->getSavedPage() : "index.php"));
            exit;
        }
    }

    /**
     * Get the main template object already populated with the main vars
     * 
     * @return Template
     */
    public function getMainTemplate()
    {
        $template = $this->getTemplate("templates/common/main.php");

        // Set the theme
        $template->theme = $this->siteTheme;

        // Get the username
        $user = Configuration::getPrivateArea()->whoIsLogged();
        if ($user !== false) {
            $template->username = $user['username'];
        } else {
            $template->username = "";
        }

        return $template;
    }

    /**
     * Get a template object already populated with the main vars
     *
     * @param  String $templatePath The path to the template file
     * 
     * @return Template
     */
    public function getTemplate($templatePath)
    {
        global $imSettings;

        $template = new Template($templatePath);

        // ImSettings
        $template->imSettings = $imSettings;

        // Generic data
        $template->sitetitle = $this->siteTitle;
        $template->sitesubtitle = $this->siteSubTitle;
        $template->logo = $this->siteLogo;

        return $template;
    }

    /**
     * Report the login with the WSX5 Manager
     * 
     * @return Void
     */
    public function loginWsx5Manager()
    {
        $_SESSION['is_wsx5_manager'] = true;
    }

    /**
     * Return true if this site is being loaded in the WSX5 Manager app
     * 
     * @return boolean
     */
    public function isWsx5Manager() {
        return isset($_SESSION['is_wsx5_manager']) && $_SESSION['is_wsx5_manager'];
    }
}

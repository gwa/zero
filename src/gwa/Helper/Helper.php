<?php

namespace Gwa\Wordpress\Template\Helper;

class Helper
{
    /**
     * Instance of admin helper.
     *
     * @var object
     */
    protected $adminHelper;

    /**
     * Instance of public helper.
     *
     * @var object
     */
    protected $publicHelper;

    /**
     * Helper.
     */
    public function __construct()
    {
        $this->adminHelper  = new AdminHelper();
        $this->publicHelper = new PublicHelper();
    }

    /**
     * Admin Helper instance.
     *
     * @return object
     */
    public function admin()
    {
        return $this->adminHelper;
    }

    /**
     * Public Helper instance.
     *
     * @return object
     */
    public function public()
    {
        return $this->adminHelper;
    }
}

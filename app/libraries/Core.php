<?php
//Core app class
class Core
{

    protected $currentController = 'Pages';//Không có controller nào trong controllers thì tự động load pages
    protected $currentMethod = 'index';//Trong pages controller, load method index
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        //Look in 'controllers' for first value, ucwords will capitalize first
        if (file_exists('../app/controllers/'. ucwords($url[0]) . '.php')) {//ucwords: chuyển kí tự đầu của chuỗi thành in hoa
            //Will set a new controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        //Require the controller
        require_once '../app/controllers/'. $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        //Check the second path of url
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        //Get parameters
        $this->params = $url ? array_values($url) : [];

        //Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');//Xóa kí tự dư thừa ở cuối chuỗi

            //Allow filter variables as string/number
            $url = filter_var($url, FILTER_SANITIZE_URL);

            //Breaking into an array
            $url = explode('/', $url);
            return $url;
        }
    }
}

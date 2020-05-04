<?php 

class Master extends Controller
{


    public function __construct(){
        return $this->index();
    }

    public function index(){

        $this->setRequest();

        if($this->getRequest() !== false){


            $data = $this->getRequest();

            if(isset($data->action))
            {
                $response = false;
                switch($data->action)
                {
                    case 'action';
                        $res = $this->getConfigProjectActionIdByActionName($data);
                        $response = $this->getActionTemplate($res->ConfigID);

                        error_log('data from website: '.print_r($response, 1));
                    break;
                }
                echo json_encode($response);
            }

        }

    }

    private function getConfigProjectActionIdByActionName($input)
    {
        $data = new stdClass();
        $data->api = 'database';
        $data->connection = 'CORE';
        $data->procedure = __FUNCTION__;
        $data->params->name = $input->actionName;
        $data->params->projectId = $input->projectId;
        $res = json_decode(API_model::doAPI($data));
        if(isset($res[0]) && $res[0]->code == '6000'){
            return $res[0];
        }

    }

    private function getActionTemplate($input)
    {
        $data = new stdClass();
        $data->api = 'database';
        $data->connection = 'TEMPLATE';
        $data->procedure = __FUNCTION__;
        $data->params->name = $input;
        $res = json_decode(API_model::doAPI($data));
        if(isset($res[0]) && $res[0]->code == '6000'){
            return $res[0]->template;
        }

    }

}
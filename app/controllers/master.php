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
                        error_log('action name: '.print_r($res, 1));
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
        $res = json_decode(ApiModel::doAPI($data));
        error_log('getConfigProjectActionIdByActionName: '.print_r($res, 1));
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
        $res = json_decode(ApiModel::doAPI($data));
        if(isset($res[0]) && $res[0]->code == '6000'){
            return $res[0]->template;
        }

    }

}
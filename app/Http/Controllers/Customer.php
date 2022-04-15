<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer\Customer_Main;
use App\Models\Logs;
use App\Traits\Sanitize;
use App\Traits\LogsTrait;

class Customer extends Controller
{
    use Sanitize;
    use LogsTrait;
    
    private $model;
    public $msg = 'Houve uma instalibade na sua requisição, logs com maiores detalhes foram salvos.';

    function __construct(Customer_Main $model) {
        $this->model = $model;
    }

    public function create(Request $request)
    {
        try {
            $data = [];
            $data['name'] = $request->input('name');
            $data['cpf'] = $request->input('cpf');
            $data['phone'] = $request->input('phone');
            $data['license_plate'] = $request->input('license_plate');

            //trait
            $data = $this->removeCharacters($data);
            $data['created_at'] = date("Y-m-d H:i:s");

            $this->model->insert($data);

            return json_encode([
                'message' => 'Dados Salvos com sucesso!',
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->saveLog($e->getMessage(), $e->getLine(), $e->getCode(), 'Controllers_Customer@create');

            return [
                'message' => $this->msg,
                'status' => 'error'
            ];
        }
    }

    public function update($id, Request $request)
    {
        try {
            $message = [];
            $status = [];

            $data = [];
            $data['name'] = $request->input('name');
            $data['cpf'] = $request->input('cpf');
            $data['phone'] = $request->input('phone');
            $data['license_plate'] = $request->input('license_plate');

            //trait
            $data = $this->removeCharacters($data);

            $data = $this->model->where('id', $id)->update($data);
        
            if ($data) {
                $message = 'Dados Atualizados com sucesso!';
                $status = 'success';
            } else {
                $message = 'Usuário não encontrado';
                $status = 'error';
            }
            return json_encode([
                'message' => $message,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            $this->saveLog($e->getMessage(), $e->getLine(), $e->getCode(), 'Controllers_Customer@update');

            return [
                'message' => $this->msg,
                'status' => 'error'
            ];
        }
    }

    public function delete($id)
    {
        try {
            $message = [];
            $status = [];

            $data = $this->model->where('id', $id)->delete();
        
            if ($data) {
                $message = 'Dados deletados com sucesso!';
                $status = 'success';
            } else {
                $message = 'Usuário não encontrado';
                $status = 'error';
            }
            return json_encode([
                'message' => $message,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            $log = [
                'message' =>  $e->getMessage(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'file' => 'Controllers_Customer@delete'
            ];
            $saveLog = new Logs();
            $saveLog->insert($log);
            
            return [
                'message' => $this->msg,
                'status' => 'error'
            ];
        }
    }

    public function getUser($id)
    {
        try {
            $message = [];
            $status = [];

            $data = $this->model->where('id', $id)->get();

            if (!$data) {
                $message = 'Dados Encontrados com sucesso!';
                $status = 'success';
            } else {
                $message = 'Usuário não encontrado';
                $status = 'error';
            }
            return json_encode([
                'message' => $message,
                'status' => $status,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $this->saveLog($e->getMessage(), $e->getLine(), $e->getCode(), 'Controllers_Customer@getUser');
            
            return [
                'message' => $this->msg,
                'status' => 'error'
            ];
        }
    }

    public function search($number)
    {
        try {
            $data = $this->model->where('license_plate', 'like', '%_'.$number.'')->get();

            return json_encode([
                'status' => 'success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $this->saveLog($e->getMessage(), $e->getLine(), $e->getCode(), 'Controllers_Customer@search');
            
            return [
                'message' => $this->msg,
                'status' => 'error'
            ];
        }
    }

}

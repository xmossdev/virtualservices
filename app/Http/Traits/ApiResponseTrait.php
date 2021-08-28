<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait ApiResponseTrait {

    public function isValid(array $rules, array $messages) {
        $request = request();
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            $messages = $validator->messages();
            $errors = $messages->all();
            return $this->createResponse(400, $errors);
        }
        return false;
    }

    public function createResponse(int $code, $message = ''){
        return response()->json([
            'success' => ($code == 200),
            'message' =>  $message
        ], $code);
    }

    public function catchException(\Exception $e){
        Log::error($e->getMessage(), $e->getTrace());
        return $this->createResponse(500, $e->getMessage());
    }

}

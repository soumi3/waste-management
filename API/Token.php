<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, X-APP-VERSION, X-APP-VERSION, X-DEVELOPMENT-VERSION");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

   class Token{
    static function Sign($playload , $key ,$expire = null){
        //Header
        $header = ['algo'=>'HS256','type'=>'HWT'];
        if($expire){
            $header['expire'] = time() + $expire;
        }
        $header_encoded = base64_encode(json_encode($header));

        //$playload
        $playload_encoded = base64_encode(json_encode($playload));

        //Signature
        $signature = hash_hmac('SHA256', $header_encoded.$playload_encoded, $key);
        $signature_encoded = base64_encode($signature);

        return $header_encoded.'.'.$playload_encoded.'.'.$signature_encoded;

    }
    static function Verify($token, $key){
        //break token part
        $token_parts = explode('.',$token);

        //generate Signature
        $signature = base64_encode(hash_hmac('SHA256',$token_parts[0].$token_parts[1],$key));

        //Verify Signature
        if($signature != $token_parts[2]){
            echo 'Invalid token';
            return false;
        }
        $header = json_decode(base64_decode($token_parts[0]),true);
           if(isset($header['expire'])){
              if($header['expire'] < time()){
                echo 'Token expire';
                return false;
              }
           }
        $playload = json_decode(base64_decode($token_parts[1]),true);
        return $playload;
    }


   }

        // $token = Token::Sign(['id'=>'hghj','name'=>'rahul',"age"=>26],'KEY');
        // echo $token;

        
        //$token = Token::Sign(['id'=>'hghj'],'KEY',30);
        //echo $token;
        
          //$token = "eyJhbGdvIjoiSFMyNTYiLCJ0eXBlIjoiSFdUIiwiZXhwaXJlIjoxNzEzNTE2NjcxfQ==.eyJuYW1lIjoiTmlybWFsIFNhcmthciIsInVzZXJfY29udGFjdCI6Ijg1Mjg1Mjg1MiIsImRhdGUiOiJUdWVzZGF5IDE2dGggb2YgQXByaWwgMjAyNCAwMjoyMToxMSBQTSIsImlkIjoiMjYifQ==.ZDI2ZDBkY2Y0ZDk1OGQwODU3NjBmNTYxZjM5NDgxZDU1M2M2MjE2MmUxM2YxODdkM2Q1N2NmYmY2YjUyOGY4ZA==";
        // print_r(Token::Verify($token ,'KEY'));

?>
<?php
class ControllerExtensionModuletvcmsinstagramslider extends Controller {
	
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(!empty($setting['status'])){
	
	    		$language_id 								= $this->config->get('config_language_id');
				$data['title'] 								= $setting['tvcmsinstagramslider_des'][$language_id]['main_title'];
				$data['tvcmsinstagramslider_username'] 		= $setting['tvcmsinstagramslider_username'];
    			$data['tvcmsinstagramslider_clientid'] 		= $setting['tvcmsinstagramslider_clientid'];
    			$data['tvcmsinstagramslider_clientsecret'] 	= $setting['tvcmsinstagramslider_clientsecret'];
    			$data['tvcmsinstagramslider_imagenumber'] 	= $setting['tvcmsinstagramslider_imagenumber'];
    			$data['tvcmsinstagramslider_accesstoken'] 	= $setting['tvcmsinstagramslider_accesstoken'];
    			$data['tvcmsinstagramslider_refresh'] 		= $setting['tvcmsinstagramslider_refresh'];
    			$data['tvcmsinstagramslider_imageformat'] 	= $setting['tvcmsinstagramslider_imageformat'];
				$data['tvcmsinstagramslider_rezise'] 		= $setting['tvcmsinstagramslider_rezise'];
		        $access_token 								= $setting['tvcmsinstagramslider_accesstoken'];
		        $nb 										= $setting['tvcmsinstagramslider_imagenumber'];

		        $url 										= 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$access_token.'&count='.$nb;
		        $ch 										= curl_init($url);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        $json 										= curl_exec($ch);
		        curl_close($ch);
		        $instagram_pics 							= array();
		        $values 									= json_decode($json, true);
		        if (!$values || (isset($values['meta']['error_message']) && $values['meta']['error_message'])) {
		            return array();
		        }
		        foreach ($values['data'] as $key => $item) {

		       		$imageformat 	= $data['tvcmsinstagramslider_imageformat'];
					$rezise 		= $data['tvcmsinstagramslider_rezise'];
					// $rezise 		= "";
		            $image 			= $item['images']['standard_resolution']['url'];
		            if ($imageformat && !$rezise) {
		                $image = $item['images'][$imageformat]['url'];
		            } elseif ($rezise) {
		                $image = $this->imagickResize($image, 'crop', $rezise);
		            }

		            $instagram_pics[] = array(
		                'image' 	=> $image,
		                'caption' 	=> isset($item['caption']['text']) ? $item['caption']['text'] : '',
		                'link' 		=> $item['link'],
		            );
		        }
		        $data['instagram_pics'] = $instagram_pics;

				return $this->load->view('extension/module/tvcmsinstagramslider', $data);
			}	
		}
	}

	public static function imagickResize($image, $type, $width, $height = null){
        if (!class_exists('Image')) {
            return $image;
        }

        if (is_null($height)) {
            $height = $width;
        }

        $image_name = md5($image) . '_' . $type . '_' . $width . '_' . $height . '.jpg';
        $image_local = DIR_IMAGE. "catalog/themevolty/instagram/". $image_name;
        if (!file_exists($image_local)) {
            copy($image, $image_local);
            if (!file_exists($image_local)) {
                return;
            }
            chmod($image_local, 0755);
            $thumb = new Image($image_local);
            if ($type == 'crop') {
                $thumb->crop(0, 0, $width, $height);
            } elseif ($type == 'resize') {
                $thumb->resize($width, $height, true);
            }
            $thumb->save($image_local);
        }

        return HTTP_SERVER. "image/catalog/themevolty/instagram/". $image_name;
    }
   

   
}

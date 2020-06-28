<?php
class ControllerExtensionModuleTvcmstwoofferbanner extends Controller {
	public function index($setting) {
		if($this->config->get('theme_default_directory') == "opc_electronic_electron_2501"){
			if(isset($setting['status'])){
				$this->load->model('tool/image');

				$data['bannarlist'] = array();
				$status		 						= $this->status();
				$data['status_title'] 				= $status['title'];
				$data['status_short_description'] 	= $status['short_description'];
				$data['status_description'] 		= $status['description'];
				$data['status_btncaption'] 			= $status['btncaption'];
				$data['status_link'] 				= $status['link'];

				foreach ($setting['tvcmstwoofferbanner'] as $key => $value) {
					$front_land_id = (int)$this->config->get('config_language_id');
	 				if($key == $front_land_id){

						if(!empty($value['tvcmstwoofferbannersub_image_1'])){
							$image_1 = $this->model_tool_image->resize($value['tvcmstwoofferbannersub_image_1'],$value['tvcmstwoofferbannersub_width_1'],$value['tvcmstwoofferbannersub_height_1']);
						}else{
							$image_1 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_btn_1'])){
							$tvcmstwoofferbannersub_img_btn_1 = $value['tvcmstwoofferbannersub_img_btn_1'];
						}else{
							$tvcmstwoofferbannersub_img_btn_1 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_link_1'])){
							$tvcmstwoofferbannersub_link_1 = $value['tvcmstwoofferbannersub_link_1'];
						}else{
							$tvcmstwoofferbannersub_link_1 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_title_1'])){
							$tvcmstwoofferbannersub_img_title_1 = $value['tvcmstwoofferbannersub_img_title_1'];
						}else{
							$tvcmstwoofferbannersub_img_title_1 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_subtitle_1'])){
							$tvcmstwoofferbannersub_img_subtitle_1 = $value['tvcmstwoofferbannersub_img_subtitle_1'];
						}else{
							$tvcmstwoofferbannersub_img_subtitle_1 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_description_1'])){
							$tvcmstwoofferbannersub_img_description_1 = $value['tvcmstwoofferbannersub_img_description_1'];
						}else{
							$tvcmstwoofferbannersub_img_description_1 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_align_1'])){
							$tvcmstwoofferbannersub_img_align_1 = $value['tvcmstwoofferbannersub_img_align_1'];
						}else{
							$tvcmstwoofferbannersub_img_align_1 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_image_2'])){
							$image_2 = $this->model_tool_image->resize($value['tvcmstwoofferbannersub_image_2'],$value['tvcmstwoofferbannersub_width_2'],$value['tvcmstwoofferbannersub_height_2']);
						}else{
							$image_2 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_btn_2'])){
							$tvcmstwoofferbannersub_img_btn_2 = $value['tvcmstwoofferbannersub_img_btn_2'];
						}else{
							$tvcmstwoofferbannersub_img_btn_2 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_link_2'])){
							$tvcmstwoofferbannersub_link_2 = $value['tvcmstwoofferbannersub_link_2'];
						}else{
							$tvcmstwoofferbannersub_link_2 = "";
						}
						if(!empty($value['tvcmstwoofferbannersub_img_title_2'])){
							$tvcmstwoofferbannersub_img_title_2 = $value['tvcmstwoofferbannersub_img_title_2'];
						}else{
							$tvcmstwoofferbannersub_img_title_2 = "";
						}
						if(!empty($value['tvcmstwoofferbannersub_img_subtitle_2'])){
							$tvcmstwoofferbannersub_img_subtitle_2 = $value['tvcmstwoofferbannersub_img_subtitle_2'];
						}else{
							$tvcmstwoofferbannersub_img_subtitle_2 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_description_2'])){
							$tvcmstwoofferbannersub_img_description_2 = $value['tvcmstwoofferbannersub_img_description_2'];
						}else{
							$tvcmstwoofferbannersub_img_description_2 = null;
						}
						if(!empty($value['tvcmstwoofferbannersub_img_align_2'])){
							$tvcmstwoofferbannersub_img_align_2 = $value['tvcmstwoofferbannersub_img_align_2'];
						}else{
							$tvcmstwoofferbannersub_img_align_2 = null;
						}
						$data['bannarlist'] = array(
							'tvcmstwoofferbannersub_image_1' 			=> $image_1,
							'tvcmstwoofferbannersub_img_btn_1' 			=> $tvcmstwoofferbannersub_img_btn_1,
							'tvcmstwoofferbannersub_link_1' 			=> $tvcmstwoofferbannersub_link_1,
							'tvcmstwoofferbannersub_img_title_1' 		=> $tvcmstwoofferbannersub_img_title_1,
							'tvcmstwoofferbannersub_img_subtitle_1'		=> $tvcmstwoofferbannersub_img_subtitle_1,
							'tvcmstwoofferbannersub_img_description_1' 	=> $tvcmstwoofferbannersub_img_description_1,
							'tvcmstwoofferbannersub_img_align_1' 		=> $tvcmstwoofferbannersub_img_align_1,
							'tvcmstwoofferbannersub_image_2' 			=>$image_2,
							'tvcmstwoofferbannersub_img_btn_2' 			=>$tvcmstwoofferbannersub_img_btn_2,
							'tvcmstwoofferbannersub_link_2' 			=>$tvcmstwoofferbannersub_link_2,
							'tvcmstwoofferbannersub_img_title_2' 		=>$tvcmstwoofferbannersub_img_title_2,
							'tvcmstwoofferbannersub_img_subtitle_2'		=>$tvcmstwoofferbannersub_img_subtitle_2,
							'tvcmstwoofferbannersub_img_description_2'	=>$tvcmstwoofferbannersub_img_description_2,
							'tvcmstwoofferbannersub_img_align_2' 		=>$tvcmstwoofferbannersub_img_align_2
						);			
					}
				}
				return $this->load->view('extension/module/tvcmstwoofferbanner', $data);
			}
		}
	}
	protected function status(){
		return $this->Tvcmsthemevoltystatus->twobannersstatus();
	}
}

<?php


namespace xavoc\allsamaj;

class Tool_SamajNews extends \xepan\cms\View_Tool {

	public $options=[
					'no_of_record'=>10,
					'no_of_column'=>' ',
					'detail_url_page'=>null

	];
	
	function init(){
		parent::init();
		
		$samaj_id = $this->app->stickyGET('samaj_id');
		$n = $this->add('xavoc\allsamaj\Model_News');
		if($samaj_id){
			$n->addCondition('samaj_id',$samaj_id);		
		}
		$lister = $this->add('CompleteLister',null,null,['view/samajnews']);

		$lister->addHook('formatRow',function($l){
			if($this->options['no_of_column']){
				$l->current_row_html['col'] = $this->options['no_of_column'];
			}else{
				$l->current_row_html['col'] = "";
			}

			if($this->options['detail_url_page']){
				$l->current_row_html['detail_url'] = $this->options['detail_url_page'];
			}



			if($this->options['detail_url_page']){
				$l->current_row_html['detail_url'] = $this->options['detail_url_page'];
			}	

			$l->current_row_html['content'] = $l->model['content'];		
			$l->current_row_html['date'] = date('F d, Y',strtotime($l->model['date']));
		});
		
		$lister->setModel($n);

		if($this->options['no_of_record']){
			$paginator = $lister->add('Paginator',null,'paginator');
			$paginator->setRowsPerPage($this->options['no_of_record']);

			$samaj_model->setLimit($this->options['no_of_record']);
		}
	}

	// function defaultTemplate(){
	// 	return ['view/samajnews1'];
	// }
}